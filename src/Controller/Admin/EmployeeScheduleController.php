<?php

namespace App\Controller;

use App\Entity\EmployeeSchedule;
use App\Form\EmployeeScheduleType;
use App\Repository\EmployeeScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employee/schedule')]
class EmployeeScheduleController extends AbstractController
{
    #[Route('/', name: 'app_employee_schedule_index', methods: ['GET'])]
    public function index(EmployeeScheduleRepository $employeeScheduleRepository): Response
    {
        return $this->render('employee_schedule/index.html.twig', [
            'employee_schedules' => $employeeScheduleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_employee_schedule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EmployeeScheduleRepository $employeeScheduleRepository): Response
    {
        $employeeSchedule = new EmployeeSchedule();
        $form = $this->createForm(EmployeeScheduleType::class, $employeeSchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeScheduleRepository->save($employeeSchedule, true);

            return $this->redirectToRoute('app_employee_schedule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_schedule/new.html.twig', [
            'employee_schedule' => $employeeSchedule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_schedule_show', methods: ['GET'])]
    public function show(EmployeeSchedule $employeeSchedule): Response
    {
        return $this->render('employee_schedule/show.html.twig', [
            'employee_schedule' => $employeeSchedule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_schedule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmployeeSchedule $employeeSchedule, EmployeeScheduleRepository $employeeScheduleRepository): Response
    {
        $form = $this->createForm(EmployeeScheduleType::class, $employeeSchedule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employeeScheduleRepository->save($employeeSchedule, true);

            return $this->redirectToRoute('app_employee_schedule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee_schedule/edit.html.twig', [
            'employee_schedule' => $employeeSchedule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_schedule_delete', methods: ['POST'])]
    public function delete(Request $request, EmployeeSchedule $employeeSchedule, EmployeeScheduleRepository $employeeScheduleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeSchedule->getId(), $request->request->get('_token'))) {
            $employeeScheduleRepository->remove($employeeSchedule, true);
        }

        return $this->redirectToRoute('app_employee_schedule_index', [], Response::HTTP_SEE_OTHER);
    }
}
