<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use http\Client\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractFOSRestController
{
    #[Route('/customer')]
    #[Rest\Get(path: '/api/customer')]
    //#[Rest\View(serializerGroups: ['group2'])]
    public function getAction (
        CustomerRepository $customerRepository
    ): Array
    {
        $customer = $customerRepository->findAll();
        return $customer;
    }
    #[Rest\Post(path: '/api/customer')]
    //#[Rest\View(serializerGroups: ['group1'])]
    public function postAction (
        Request $request
    ): array
    {
        var_dump($request->getContent());
        return [];
    }

}