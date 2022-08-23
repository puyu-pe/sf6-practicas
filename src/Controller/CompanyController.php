<?php

namespace App\Controller;

use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CompanyController extends AbstractController
{
    #[Route('/company')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $company = new Company();
        $company->setDescription('Puyu company');
        $company->setRuc(2098877654);
        $company->setStatus(TRUE);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($company);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new company with id ' . $company->getId());
    }

    #[Route('/company/update/{id}')]
    public function update(ManagerRegistry $doctrine, int $id ): Response
    {
        $entityManager = $doctrine->getManager();
        $company = $entityManager->getRepository(Company::class)->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                'No se encontro la empresa con el ID: '.$id
            );
        }

        $company->setDescription('Company EDIT');
        $entityManager->flush();

        return new Response('Descripcion de la compania actualizado ' . $company->getId());
    }

    #[Route('/company/delete/{id}')]
    public function delete(ManagerRegistry $doctrine, int $id ): Response
    {
        $entityManager = $doctrine->getManager();
        $company = $entityManager->getRepository(Company::class)->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                'No se encontro la empresa con el ID: '.$id
            );
        }

        $entityManager->remove($company);
        $entityManager->flush();

        return new Response('Compania eliminada' . $company->getId());
    }

    #[Route('/company/list')]
    public function list(ManagerRegistry $doctrine, NormalizerInterface $normalizer ): Response
    {
        $companys = $doctrine->getRepository(Company::class)->findAll();
        $data = $normalizer->normalize(
            $companys,
            null,
            ['groups' => ['group_1']]
        );;

        return new JsonResponse($data, 200);
    }
}