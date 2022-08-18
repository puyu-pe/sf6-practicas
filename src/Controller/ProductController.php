<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setDescription('Mouse')
            ->setBrand('Microsoft')
            ->setCategory('informatica')
            ->setPrice(24.00);

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

    #[Route('/product/list')]
    public function list(): Response
    {
        return new Response(
            '<html><body>list</body></html>'
        );
    }
}