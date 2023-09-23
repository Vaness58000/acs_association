<?php

namespace App\Test\Controller;

use App\Entity\AddFiles;
use App\Repository\AddFilesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddFilesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AddFilesRepository $repository;
    private string $path = '/add/files/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(AddFiles::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AddFile index');

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
            'add_file[name]' => 'Testing',
            'add_file[src]' => 'Testing',
            'add_file[produits]' => 'Testing',
            'add_file[type]' => 'Testing',
        ]);

        self::assertResponseRedirects('/add/files/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new AddFiles();
        $fixture->setName('My Title');
        $fixture->setSrc('My Title');
        $fixture->setProduits('My Title');
        $fixture->setType('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AddFile');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new AddFiles();
        $fixture->setName('My Title');
        $fixture->setSrc('My Title');
        $fixture->setProduits('My Title');
        $fixture->setType('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'add_file[name]' => 'Something New',
            'add_file[src]' => 'Something New',
            'add_file[produits]' => 'Something New',
            'add_file[type]' => 'Something New',
        ]);

        self::assertResponseRedirects('/add/files/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSrc());
        self::assertSame('Something New', $fixture[0]->getProduits());
        self::assertSame('Something New', $fixture[0]->getType());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new AddFiles();
        $fixture->setName('My Title');
        $fixture->setSrc('My Title');
        $fixture->setProduits('My Title');
        $fixture->setType('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/add/files/');
    }
}
