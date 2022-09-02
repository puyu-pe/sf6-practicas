<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use App\Service\ProductFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/products')]
    #[Rest\View(serializerGroups: ['group2'])]
    public function getAction(
        ProductRepository $productRepository
    ): array
    {
        return $productRepository->findAll();
    }

    #[Rest\Post(path: '/products')]
    #[Rest\View(serializerGroups: ['group1'])]
    public function postAction(
        Request              $request,
        ProductFormProcessor $productFormProcessor
    ): View
    {
        [$product, $error] = ($productFormProcessor)($request);
        $statusCode = $product ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $product ?? $error;
        return View::create($data, $statusCode);
    }

    #[Rest\Delete(path: '/products/{id}', requirements: ['id' => '\d+'])]
    public function deleteAction(
        int                    $id,
        ProductRepository      $productRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        try {
            $product = $productRepository->find($id);

            if (!$product) {
                throw new RuntimeException('No existe el producto');
            }

            $entityManager->remove($product);
            $entityManager->flush();

            $response = [
                'success' => true,
                'message' => 'El producto fue eliminado'
            ];
            return new jsonResponse($response);
        } catch (Throwable $th) {
            $response = [
                'success' => false,
                'message' => $th->getMessage()
            ];
            return new jsonResponse($response);
        }
    }
}