<?php

namespace App\Test\Controller;

use App\Entity\CompanyAdditionalInfo;
use App\Repository\CompanyAdditionalInfoRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyAdditionalInfoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompanyAdditionalInfoRepository $repository;
    private string $path = '/company/additional/info/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(CompanyAdditionalInfo::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompanyAdditionalInfo index');

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
            'company_additional_info[phone]' => 'Testing',
            'company_additional_info[email]' => 'Testing',
            'company_additional_info[facebook]' => 'Testing',
            'company_additional_info[instagram]' => 'Testing',
            'company_additional_info[website]' => 'Testing',
            'company_additional_info[company]' => 'Testing',
        ]);

        self::assertResponseRedirects('/company/additional/info/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompanyAdditionalInfo();
        $fixture->setPhone('My Title');
        $fixture->setEmail('My Title');
        $fixture->setFacebook('My Title');
        $fixture->setInstagram('My Title');
        $fixture->setWebsite('My Title');
        $fixture->setCompany('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompanyAdditionalInfo');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompanyAdditionalInfo();
        $fixture->setPhone('My Title');
        $fixture->setEmail('My Title');
        $fixture->setFacebook('My Title');
        $fixture->setInstagram('My Title');
        $fixture->setWebsite('My Title');
        $fixture->setCompany('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'company_additional_info[phone]' => 'Something New',
            'company_additional_info[email]' => 'Something New',
            'company_additional_info[facebook]' => 'Something New',
            'company_additional_info[instagram]' => 'Something New',
            'company_additional_info[website]' => 'Something New',
            'company_additional_info[company]' => 'Something New',
        ]);

        self::assertResponseRedirects('/company/additional/info/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPhone());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getFacebook());
        self::assertSame('Something New', $fixture[0]->getInstagram());
        self::assertSame('Something New', $fixture[0]->getWebsite());
        self::assertSame('Something New', $fixture[0]->getCompany());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new CompanyAdditionalInfo();
        $fixture->setPhone('My Title');
        $fixture->setEmail('My Title');
        $fixture->setFacebook('My Title');
        $fixture->setInstagram('My Title');
        $fixture->setWebsite('My Title');
        $fixture->setCompany('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/company/additional/info/');
    }
}
