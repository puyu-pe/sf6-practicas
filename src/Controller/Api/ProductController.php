<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/api/products')]
    #[Rest\View(serializerGroups: ['group2'])]
    public function getAction(
        ProductRepository $productRepository
    ): array
    {
        return $productRepository->findAll();
    }

    #[Rest\Post(path: '/api/products')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function postAction(
        Request $request
    ): array
    {
        var_dump($request->getContent());

        return [];
    }
}