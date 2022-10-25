<?php

namespace App\Test\Controller;

use App\Entity\EmployeeSchedule;
use App\Repository\EmployeeScheduleRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeScheduleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EmployeeScheduleRepository $repository;
    private string $path = '/employee/schedule/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(EmployeeSchedule::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmployeeSchedule index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'employee_schedule[dayFrom]' => 'Testing',
            'employee_schedule[dayTo]' => 'Testing',
            'employee_schedule[timeFrom]' => 'Testing',
            'employee_schedule[timeTo]' => 'Testing',
            'employee_schedule[repeatInfinity]' => 'Testing',
            'employee_schedule[createdAt]' => 'Testing',
            'employee_schedule[updatedAt]' => 'Testing',
            'employee_schedule[deletedAt]' => 'Testing',
            'employee_schedule[user]' => 'Testing',
        ]);

        self::assertResponseRedirects('/employee/schedule/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmployeeSchedule();
        $fixture->setDayFrom('My Title');
        $fixture->setDayTo('My Title');
        $fixture->setTimeFrom('My Title');
        $fixture->setTimeTo('My Title');
        $fixture->setRepeatInfinity('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setUser('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EmployeeSchedule');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new EmployeeSchedule();
        $fixture->setDayFrom('My Title');
        $fixture->setDayTo('My Title');
        $fixture->setTimeFrom('My Title');
        $fixture->setTimeTo('My Title');
        $fixture->setRepeatInfinity('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setUser('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'employee_schedule[dayFrom]' => 'Something New',
            'employee_schedule[dayTo]' => 'Something New',
            'employee_schedule[timeFrom]' => 'Something New',
            'employee_schedule[timeTo]' => 'Something New',
            'employee_schedule[repeatInfinity]' => 'Something New',
            'employee_schedule[createdAt]' => 'Something New',
            'employee_schedule[updatedAt]' => 'Something New',
            'employee_schedule[deletedAt]' => 'Something New',
            'employee_schedule[user]' => 'Something New',
        ]);

        self::assertResponseRedirects('/employee/schedule/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDayFrom());
        self::assertSame('Something New', $fixture[0]->getDayTo());
        self::assertSame('Something New', $fixture[0]->getTimeFrom());
        self::assertSame('Something New', $fixture[0]->getTimeTo());
        self::assertSame('Something New', $fixture[0]->getRepeatInfinity());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getUser());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new EmployeeSchedule();
        $fixture->setDayFrom('My Title');
        $fixture->setDayTo('My Title');
        $fixture->setTimeFrom('My Title');
        $fixture->setTimeTo('My Title');
        $fixture->setRepeatInfinity('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setUser('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/employee/schedule/');
    }
}
