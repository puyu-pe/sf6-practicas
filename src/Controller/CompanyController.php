<?php

namespace App\Controller;

use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/company/show')]
    public function show(): Response
    {
        return new Response(
            '<html><body> SHOW COMPANY </body></html>'
        );
    }

    #[Route('/company/update')]
    public function update(): Response
    {
        return new Response(
            '<html><body> UPDATE COMPANY </body></html>'
        );
    }

    #[Route('/company/delete')]
    public function delete(): Response
    {
        return new Response(
            '<html><body> DELETE COMPANY </body></html>'
        );
    }

    #[Route('/company/list')]
    public function list(): Response
    {
        return new Response(
            '<html><body> LIST COMPANY </body></html>'
        );
    }
}