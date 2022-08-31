<?php

namespace App\Controller\Api;
use App\Repository\CustomerRepository;
use App\Service\CustomerFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/customer')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function getAction(
        CustomerRepository $customerRepository
    ): array
    {
        return $customerRepository->findAll();
    }

    #[Rest\Post(path: '/customer')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function postAction(
        Request                $request,
        CustomerFormProcessor   $customerFormProcessor
    )
    {
        [$customer,$error] = ($customerFormProcessor)($request);
        $statusCode = $customer ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data =  $customer ?? $error;

        return View::create($data,$statusCode);
    }

    #[Rest\Delete(path: '/customer/{id}', requirements: ['id' => '\d+'])]
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
