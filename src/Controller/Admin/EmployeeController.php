<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/employee', name: 'admin_employee_')]
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
}
