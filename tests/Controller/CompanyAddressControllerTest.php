<?php

namespace App\Test\Controller;

use App\Entity\CompanyAddress;
use App\Repository\CompanyAddressRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyAddressControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompanyAddressRepository $repository;
    private string $path = '/company/address/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(CompanyAddress::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompanyAddress index');

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
            'company_address[city]' => 'Testing',
            'company_address[postCode]' => 'Testing',
            'company_address[country]' => 'Testing',
            'company_address[street]' => 'Testing',
            'company_address[buildingNumber]' => 'Testing',
            'company_address[company]' => 'Testing',
        ]);

        self::assertResponseRedirects('/company/address/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompanyAddress();
        $fixture->setCity('My Title');
        $fixture->setPostCode('My Title');
        $fixture->setCountry('My Title');
        $fixture->setStreet('My Title');
        $fixture->setBuildingNumber('My Title');
        $fixture->setCompany('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('CompanyAddress');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new CompanyAddress();
        $fixture->setCity('My Title');
        $fixture->setPostCode('My Title');
        $fixture->setCountry('My Title');
        $fixture->setStreet('My Title');
        $fixture->setBuildingNumber('My Title');
        $fixture->setCompany('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'company_address[city]' => 'Something New',
            'company_address[postCode]' => 'Something New',
            'company_address[country]' => 'Something New',
            'company_address[street]' => 'Something New',
            'company_address[buildingNumber]' => 'Something New',
            'company_address[company]' => 'Something New',
        ]);

        self::assertResponseRedirects('/company/address/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getPostCode());
        self::assertSame('Something New', $fixture[0]->getCountry());
        self::assertSame('Something New', $fixture[0]->getStreet());
        self::assertSame('Something New', $fixture[0]->getBuildingNumber());
        self::assertSame('Something New', $fixture[0]->getCompany());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new CompanyAddress();
        $fixture->setCity('My Title');
        $fixture->setPostCode('My Title');
        $fixture->setCountry('My Title');
        $fixture->setStreet('My Title');
        $fixture->setBuildingNumber('My Title');
        $fixture->setCompany('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/company/address/');
    }
}
