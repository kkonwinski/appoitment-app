<?php

namespace App\Controller\Admin;

use App\Entity\CompanyAddress;
use App\Form\CompanyAddressType;
use App\Repository\CompanyAddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company/address')]
class CompanyAddressController extends AbstractController
{
    #[Route('/', name: 'app_company_address_index', methods: ['GET'])]
    public function index(CompanyAddressRepository $companyAddressRepository): Response
    {
        return $this->render('company_address/index.html.twig', [
            'company_addresses' => $companyAddressRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_company_address_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyAddressRepository $companyAddressRepository): Response
    {
        $companyAddress = new CompanyAddress();
        $form = $this->createForm(CompanyAddressType::class, $companyAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyAddressRepository->save($companyAddress, true);

            return $this->redirectToRoute('app_company_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company_address/new.html.twig', [
            'company_address' => $companyAddress,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_address_show', methods: ['GET'])]
    public function show(CompanyAddress $companyAddress): Response
    {
        return $this->render('company_address/show.html.twig', [
            'company_address' => $companyAddress,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_address_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompanyAddress $companyAddress, CompanyAddressRepository $companyAddressRepository): Response
    {
        $form = $this->createForm(CompanyAddressType::class, $companyAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyAddressRepository->save($companyAddress, true);

            return $this->redirectToRoute('app_company_address_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company_address/edit.html.twig', [
            'company_address' => $companyAddress,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_address_delete', methods: ['POST'])]
    public function delete(Request $request, CompanyAddress $companyAddress, CompanyAddressRepository $companyAddressRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$companyAddress->getId(), $request->request->get('_token'))) {
            $companyAddressRepository->remove($companyAddress, true);
        }

        return $this->redirectToRoute('app_company_address_index', [], Response::HTTP_SEE_OTHER);
    }
}
