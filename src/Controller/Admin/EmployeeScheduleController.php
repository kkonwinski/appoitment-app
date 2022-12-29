<?php

namespace App\Controller\Admin;

use App\Entity\EmployeeSchedule;
use App\Entity\User;
use App\Form\EmployeeScheduleType;
use App\Repository\EmployeeScheduleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('admin/employee/schedule', name: 'admin_employee_schedule_')]
class EmployeeScheduleController extends AbstractController
{
    #[Route('/list/{id}', name: 'list', methods: ['GET', 'POST'])]
    public function list(
        User $user,
        EmployeeScheduleRepository $employeeScheduleRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {


        $employeeSchedules = $paginator->paginate(
            $employeeScheduleRepository->findEmployeeSchedulesByUser($user), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );


        return $this->render('admin/employee_schedule/list.html.twig', [
            'employeeSchedules' => $employeeSchedules,
            'user' => $user,
        ]);
    }

    #[Route('/new/{id}', name: 'new', methods: ['GET', 'POST'])]
    public function new(User $user, Request $request, EmployeeScheduleRepository $employeeScheduleRepository): Response
    {
        $employeeSchedule = new EmployeeSchedule();
        $form = $this->createForm(EmployeeScheduleType::class, $employeeSchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeSchedule->setUser($user);
            $employeeScheduleRepository->save($employeeSchedule, true);

            return $this->redirectToRoute('admin_employee_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/employee_schedule/new.html.twig', [
            'employee_schedule' => $employeeSchedule,
            'form' => $form,
        ]);
    }

//    #[Route('/{id}', name: 'show', methods: ['GET'])]
//    public function show(EmployeeSchedule $employeeSchedule): Response
//    {
//        return $this->render('employee_schedule/show.html.twig', [
//            'employee_schedule' => $employeeSchedule,
//        ]);
//    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EmployeeSchedule $employeeSchedule,
        EmployeeScheduleRepository $employeeScheduleRepository
    ): Response {
        $form = $this->createForm(EmployeeScheduleType::class, $employeeSchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeScheduleRepository->save($employeeSchedule, true);

            return $this->redirectToRoute('admin_employee_schedule_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_schedule/edit.html.twig', [
            'employee_schedule' => $employeeSchedule,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        EmployeeSchedule $employeeSchedule,
        EmployeeScheduleRepository $employeeScheduleRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $employeeSchedule->getId(), $request->request->get('_token'))) {
            $employeeScheduleRepository->remove($employeeSchedule, true);
        }

        return $this->redirectToRoute('app_employee_schedule_index', [], Response::HTTP_SEE_OTHER);
    }
}
