<?php

namespace App\Controller\Admin;

use App\Entity\CompanyAddress;
use App\Entity\User;
use App\Form\EmployeeType;
use App\Repository\CompanyAddressRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/employee', name: 'admin_employee_')]
#[IsGranted('ROLE_OWNER')]
class EmployeeController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(
        PaginatorInterface $paginator,
        Request $request,
        UserRepository $userRepository
    ): Response {
        /** @var User $user */
        $user = $this->getUser();
        $company = $user->getCompany();

        $employees = $paginator->paginate(
            $userRepository->findEmployeesByCompany($company), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/employee/list.html.twig', [
            'employees' => $employees,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(UserRepository $userRepository): Response
    {
        $employee = new User();
        $form = $this->createForm(EmployeeType::class, $employee);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($employee, true);

            return $this->redirectToRoute('admin_dashboard', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/employee/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{slug}/edit', name: 'edit')]
    public function edit(
        User $employee,
        UserRepository $userRepository,
        Request $request
    ): Response {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($employee, true);

            return $this->redirectToRoute('admin_employee_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/employee/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        User $employee,
        UserRepository $userRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $employee->getId(), $request->request->get('_token'))) {
            $userRepository->remove($employee, true);
        }

        return $this->redirectToRoute('admin_employee_list', [], Response::HTTP_SEE_OTHER);
    }
}
