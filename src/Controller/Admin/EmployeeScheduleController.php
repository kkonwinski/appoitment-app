<?php

namespace App\Controller\Admin;

use App\Entity\EmployeeSchedule;
use App\Entity\User;
use App\Form\EmployeeScheduleType;
use App\Repository\EmployeeScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/employee/schedule', name: 'admin_employee_schedule_')]
class EmployeeScheduleController extends AbstractController
{
    #[Route('/list/{slug}', name: 'list', methods: ['GET'])]
    public function index(
        User $user,
        EmployeeScheduleRepository $employeeScheduleRepository
    ): Response
    {
        return $this->render('admin/employee_schedule/list.html.twig', [
            'employee_schedules' => $employeeScheduleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeScheduleRepository $employeeScheduleRepository): Response
    {
        $employeeSchedule = new EmployeeSchedule();
        $form = $this->createForm(EmployeeScheduleType::class, $employeeSchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeScheduleRepository->save($employeeSchedule, true);

            return $this->redirectToRoute('admin_employee_schedule_list', [], Response::HTTP_SEE_OTHER);
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
