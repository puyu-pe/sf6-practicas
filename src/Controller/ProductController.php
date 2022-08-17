<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product')]
    public function create(): Response
    {
        return new Response(
            '<html><body>create</body></html>'
        );
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