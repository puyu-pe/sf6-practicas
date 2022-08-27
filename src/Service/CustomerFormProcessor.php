<?php

namespace App\Service;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class CustomerFormProcessor
{

    public function __construct(

        private FormFactory $formFactory,
        private EntityManagerInterface $entityManager
    )
    {
    }
    public function __invoke(Request $request): array
    {
        $customerDto = new CustomerDto();
        $form = $this->formFactory->create(CustomerType::class,$customerDto);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $customer = new Customer();
            $customer->setName($customerDto->getName());
            $customer->setLastname($customerDto->getLastname());
            $customer->setAddress($customerDto->getAddress());

            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            return [$customer,null];

        }
        return [null,$form];
    }
}