<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProductController extends AbstractFOSRestController/*AbstractController*/
{
    #[Route('/product')]
    #[Rest\Get(path: '/api/products')]
    #[Rest\View(serializerGroups: ['group2'])]
    public function getAction (
        ProductRepository $productRepository
    ): Array
    {
        $products = $productRepository->findAll();
        return $products;
    }

    #[Rest\Post(path: '/api/products')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function postAction (
        Request $request
    ): array
    {
        var_dump($request->getContent());
        return [];
    }
    /*
    public function create(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $entityManager = $doctrine->getManager();
        $product = new Product();
        $product->setDescription('')
            ->setBrand('Microsoft')
            ->setCategory('informatica')
            ->setPrice(24.00);

        $errors = $validator->validate($product);

        if ($errors) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }*/

    #[Route('/product/show')]
    public function show(): Response
    {
        return new Response(
            '<html><body>show</body></html>'
        );
    }

    #[Route('/product/update')]
    public function update(): Response
    {
        return new Response(
            '<html><body>update</body></html>'
        );
    }

    #[Route('/product/delete')]
    public function delete(): Response
    {
        return new Response(
            '<html><body>delete</body></html>'
        );
    }

    #[Route('/product/list', 'GET')]
    public function list(ManagerRegistry $doctrine, NormalizerInterface $normalizer): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();
        $data = $normalizer->normalize(
            $products,
            null,
            ['groups' => ['group1']]
        );

        return new JsonResponse($data, 200);
    }
}