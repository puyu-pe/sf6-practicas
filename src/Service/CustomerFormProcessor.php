<?php

namespace App\Service;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class CustomerFormProcessor
{

    public function __construct(
        private FormFactoryInterface $formFactory,
        private EntityManagerInterface $entityManager
    )
    {
    }
    public function __invoke(Request $request): array
    {
        $customer = new Customer();
        $form = $this->formFactory->create(CustomerType::class,$customer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            return [$customer,null];

        }
        return [null,$form];
    }
}