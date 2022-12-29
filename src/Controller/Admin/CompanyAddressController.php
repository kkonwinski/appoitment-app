<?php

namespace App\Controller\Admin;

use App\Entity\CompanyAdditionalInfo;
use App\Entity\CompanyAddress;
use App\Form\CompanyAddressType;
use App\Repository\CompanyAddressRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/company/address', name: 'admin_company_address_')]
class CompanyAddressController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(CompanyAddressRepository $companyAddressRepository): Response
    {

        return $this->render('admin/company_address/index.html.twig', [
            'company_addresses' =>
                $companyAddressRepository->
                findBy(['company' => $this->getUser()->getCompany(),'deletedAt' => null]),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyAddressRepository $companyAddressRepository): Response
    {
        $companyAddress = new CompanyAddress();
        $companyAdditionalInfo = new CompanyAdditionalInfo();
        $companyAddress->addCompanyAdditionalInfo($companyAdditionalInfo);

        $form = $this->createForm(CompanyAddressType::class, $companyAddress);
        $form->handleRequest($request);

        if (
            $form->isSubmitted() &&
            $form->isValid()
        ) {
            $companyAddress->setCompany($this->getUser()->getCompany());
            $companyAddressRepository->save($companyAddress, true);

            return $this->redirectToRoute('admin_company_address_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/company_address/new.html.twig', [
            'companyAddress' => $companyAddress,
            'form' => $form,
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        CompanyAddress $companyAddress,
        CompanyAddressRepository $companyAddressRepository
    ): Response {
        $companyAddressRepository->checkIfCompanyAddressBelongsToUser($companyAddress, $this->getUser());

        $form = $this->createForm(CompanyAddressType::class, $companyAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyAddressRepository->save($companyAddress, true);

            return $this->redirectToRoute('admin_company_address_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/company_address/edit.html.twig', [
            'companyAddress' => $companyAddress,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        CompanyAddress $companyAddress,
        CompanyAddressRepository $companyAddressRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $companyAddress->getId(), $request->request->get('_token'))) {
            $companyAddressRepository->remove($companyAddress, true);
        }

        return $this->redirectToRoute('admin_company_address_list', [], Response::HTTP_SEE_OTHER);
    }
}
