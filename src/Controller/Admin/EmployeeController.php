<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EmployeeType;
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
}
