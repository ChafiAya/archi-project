<?php

namespace App\Tests\Controller;

use App\Entity\Calendrier;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CalendrierControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/calendrier/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Calendrier::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'calendrier[date]' => 'Testing',
            'calendrier[HD]' => 'Testing',
            'calendrier[HF]' => 'Testing',
            'calendrier[duree]' => 'Testing',
            'calendrier[salle]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Calendrier();
        $fixture->setSalle('My Title');
        $fixture->setDate('My Title');
        $fixture->setHD('My Title');
        $fixture->setHF('My Title');
        $fixture->setDuree('My Title');
        $fixture->setSalle('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Calendrier');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Calendrier();
        $fixture->setDate('Value');
        $fixture->setHD('Value');
        $fixture->setHF('Value');
        $fixture->setDuree('Value');
        $fixture->setSalle('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'calendrier[date]' => 'Something New',
            'calendrier[HD]' => 'Something New',
            'calendrier[HF]' => 'Something New',
            'calendrier[duree]' => 'Something New',
            'calendrier[salle]' => 'Something New',
        ]);

        self::assertResponseRedirects('/calendrier/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getHD());
        self::assertSame('Something New', $fixture[0]->getHF());
        self::assertSame('Something New', $fixture[0]->getDuree());
        self::assertSame('Something New', $fixture[0]->getSalle());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Calendrier();
        $fixture->setDate('Value');
        $fixture->setHD('Value');
        $fixture->setHF('Value');
        $fixture->setDuree('Value');
        $fixture->setSalle('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/calendrier/');
        self::assertSame(0, $this->repository->count([]));
    }
}
