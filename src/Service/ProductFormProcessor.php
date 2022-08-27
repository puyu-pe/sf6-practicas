<?php

namespace App\Service;

use App\Entity\Product;
use App\Form\Model\Product\ProductDto;
use App\Form\Type\Product\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class ProductFormProcessor
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private FileUploader $fileUploader,
        private EntityManagerInterface $entityManager
    )
    {
    }


    /**
     * @param Request $request
     * @return array [Product $product, FormInterface $form]
     */
    public function __invoke(Request $request) : array
    {
        $productDto = new ProductDto();
        $form = $this->formFactory->create(ProductType::class, $productDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = new Product();
            $product->setDescription($productDto->getDescription());
            $product->setBrand($productDto->getBrand());
            $product->setPrice($productDto->getPrice());
            $product->setCategory($productDto->getCategory());

            if ($productDto->getImageBase64()) {
                $filename = $this->fileUploader->uploadBase64File($productDto->getImageBase64());
                $product->setImage($filename);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();
            return [$product, null];
        }

        return [null, $form];
    }
}