<?php

namespace App\Controller\Admin;

use App\Entity\CompanyAdditionalInfo;
use App\Form\CompanyAdditionalInfoType;
use App\Repository\CompanyAdditionalInfoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company/additional/info', name: 'company_additional_info_')]
#[IsGranted('ROLE_OWNER')]
class CompanyAdditionalInfoController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(CompanyAdditionalInfoRepository $companyAdditionalInfoRepository): Response
    {
        return $this->render('company_additional_info/index.html.twig', [
            'company_additional_infos' => $companyAdditionalInfoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyAdditionalInfoRepository $companyAdditionalInfoRepository): Response
    {
        $companyAdditionalInfo = new CompanyAdditionalInfo();
        $form = $this->createForm(CompanyAdditionalInfoType::class, $companyAdditionalInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyAdditionalInfoRepository->save($companyAdditionalInfo, true);

            return $this->redirectToRoute('app_company_additional_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company_additional_info/new.html.twig', [
            'company_additional_info' => $companyAdditionalInfo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CompanyAdditionalInfo $companyAdditionalInfo,
        CompanyAdditionalInfoRepository $companyAdditionalInfoRepository
    ): Response {
        $form = $this->createForm(CompanyAdditionalInfoType::class, $companyAdditionalInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyAdditionalInfoRepository->save($companyAdditionalInfo, true);

            return $this->redirectToRoute('app_company_additional_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company_additional_info/edit.html.twig', [
            'company_additional_info' => $companyAdditionalInfo,
            'form' => $form,
        ]);
    }
}
