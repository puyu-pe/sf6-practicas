<?php

namespace App\Controller\Api;

use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class CompanyController extends AbstractFOSRestController
{
    #[Rest\Get(path: '/api/companys')]
    #[Rest\View(serializerGroups: ['group_1'])]
    public function getAction(
        ManagerRegistry $doctrine
    ): Array
    {
        $companys = $doctrine->getRepository(Company::class)->findAll();
        return $companys;
    }
}