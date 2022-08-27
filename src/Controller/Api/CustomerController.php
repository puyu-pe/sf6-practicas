<?php

namespace App\Controller\Api;
use App\Entity\Customer;
use App\Form\Type\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use mysql_xdevapi\Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/api/customer')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function getAction(
        CustomerRepository $customerRepository
    ): array
    {
        return $customerRepository->findAll();
    }

    #[Rest\Post(path: '/api/customer')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function postAction(
        Request                $request,
        EntityManagerInterface $entityManager
    ): Customer|FormInterface
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($customer);
            $entityManager->flush();
            return $customer;
        }

        return $form;
    }

    #[Rest\Delete(path: '/api/customer/{id}', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int                    $id,
        CustomerRepository      $customerRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        try {
            $customer = $customerRepository->find($id);

            if (!$customer)
                throw new \Exception('No existe el cliente');

            $entityManager->remove($customer);
            $entityManager->flush();

            $response = [
                'success' => true,
                'message' => 'El cliente fue eliminado'
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
