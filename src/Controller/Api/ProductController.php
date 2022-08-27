<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use mysql_xdevapi\Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/products')]
    #[Rest\View(serializerGroups: ['group2'])]
    public function getAction(
        ProductRepository $productRepository
    ): array
    {
        return $productRepository->findAll();
    }

    #[Rest\Post(path: '/products')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function postAction(
        Request                $request,
        EntityManagerInterface $entityManager
    ): Product|FormInterface
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
            return $product;
        }

        return $form;
    }

    #[Rest\Delete(path: '/products/{id}', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int                    $id,
        ProductRepository      $productRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        try {
            $product = $productRepository->find($id);

            if (!$product)
                throw new \Exception('No existe el producto');

            $entityManager->remove($product);
            $entityManager->flush();

            $response = [
                'success' => true,
                'message' => 'El producto fue eliminado'
            ];
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => $th->getMessage()
            ];
        } finally {
            return new jsonResponse($response);
        }
    }
}