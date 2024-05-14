<?php

namespace App\Test\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProduitsRepository $repository;
    private string $path = '/produits/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Produits::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit index');

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
            'produit[name]' => 'Testing',
            'produit[slug]' => 'Testing',
            'produit[achat_at]' => 'Testing',
            'produit[guarantee_at]' => 'Testing',
            'produit[price]' => 'Testing',
            'produit[content]' => 'Testing',
            'produit[active]' => 'Testing',
            'produit[created_at]' => 'Testing',
            'produit[categories]' => 'Testing',
            'produit[users]' => 'Testing',
            'produit[addFiles]' => 'Testing',
            'produit[images]' => 'Testing',
        ]);

        self::assertResponseRedirects('/produits/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setName('My Title');
        $fixture->setSlug('My Title');
        $fixture->setAchat_at('My Title');
        $fixture->setGuarantee_at('My Title');
        $fixture->setPrice('My Title');
        $fixture->setContent('My Title');
        $fixture->setActive('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setCategories('My Title');
        $fixture->setUsers('My Title');
        $fixture->setAddFiles('My Title');
        $fixture->setImages('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Produit');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Produits();
        $fixture->setName('My Title');
        $fixture->setSlug('My Title');
        $fixture->setAchat_at('My Title');
        $fixture->setGuarantee_at('My Title');
        $fixture->setPrice('My Title');
        $fixture->setContent('My Title');
        $fixture->setActive('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setCategories('My Title');
        $fixture->setUsers('My Title');
        $fixture->setAddFiles('My Title');
        $fixture->setImages('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'produit[name]' => 'Something New',
            'produit[slug]' => 'Something New',
            'produit[achat_at]' => 'Something New',
            'produit[guarantee_at]' => 'Something New',
            'produit[price]' => 'Something New',
            'produit[content]' => 'Something New',
            'produit[active]' => 'Something New',
            'produit[created_at]' => 'Something New',
            'produit[categories]' => 'Something New',
            'produit[users]' => 'Something New',
            'produit[addFiles]' => 'Something New',
            'produit[images]' => 'Something New',
        ]);

        self::assertResponseRedirects('/produits/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getAchat_at());
        self::assertSame('Something New', $fixture[0]->getGuarantee_at());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getContent());
        self::assertSame('Something New', $fixture[0]->getActive());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getCategories());
        self::assertSame('Something New', $fixture[0]->getUsers());
        self::assertSame('Something New', $fixture[0]->getAddFiles());
        self::assertSame('Something New', $fixture[0]->getImages());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Produits();
        $fixture->setName('My Title');
        $fixture->setSlug('My Title');
        $fixture->setAchat_at('My Title');
        $fixture->setGuarantee_at('My Title');
        $fixture->setPrice('My Title');
        $fixture->setContent('My Title');
        $fixture->setActive('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setCategories('My Title');
        $fixture->setUsers('My Title');
        $fixture->setAddFiles('My Title');
        $fixture->setImages('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/produits/');
    }
}
