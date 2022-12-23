<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\CompanyAddress;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/company', name: 'admin_company_')]
#[IsGranted('ROLE_OWNER')]
class CompanyController extends AbstractController
{
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyRepository $companyRepository): Response
    {
//        if ($this->getUser()->getCompany()) {
//            return $this->redirectToRoute('admin_dashboard');
//        }

        $company = new Company();
        $companyAddresses = new CompanyAddress();
        $company->addCompanyAddress($companyAddresses);
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $company->addUser($this->getUser());

            $companyRepository->save($company, true);

            return $this->redirectToRoute('admin_dashboard', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }
}
