<?php

namespace App\Controller\Api;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/api/products')]
    #[Rest\View(serializerGroups: ['product'])]
    public function getAction(
        ManagerRegistry $doctrine
    ): Array
    {
        $products = $doctrine->getRepository(Product::class)->findAll();
        return $products;
    }
}