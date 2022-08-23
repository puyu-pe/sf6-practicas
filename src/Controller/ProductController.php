<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    #[Route('/product')]
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
    }

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