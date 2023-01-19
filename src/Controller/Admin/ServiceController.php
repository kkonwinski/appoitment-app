<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Entity\Service;
use App\Entity\User;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/service', name: 'admin_service_')]
#[IsGranted('ROLE_OWNER')]
class ServiceController extends AbstractController
{
    #[Route('/list/{slug}', name: 'list', methods: ['GET'])]
    public function list(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findByCompany($this->getUser()->getCompany());

        return $this->render(
            'admin/service/list.html.twig',
            [
            'services' => $services
            ]
        );
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceRepository $serviceRepository): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->addCompany($this->getUser()->getCompany());
            $service->save($service, true);
            $services = $serviceRepository->findBy(['companies'=>$this->getUser()->getCompany()]);

            return $this->redirectToRoute(
                'admin_service_list',
                [
                'slug' => $this->getUser()->getCompany()->getSlug()
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->save($service, true);

            return $this->redirectToRoute('admin_service_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $serviceRepository->remove($service, true);
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
