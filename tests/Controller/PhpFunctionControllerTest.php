<?php

namespace App\Tests\Controller;

use App\Entity\PhpFunction;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PhpFunctionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/php/function/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(PhpFunction::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PhpFunction index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'php_function[title]' => 'Testing',
            'php_function[slug]' => 'Testing',
            'php_function[description]' => 'Testing',
            'php_function[text]' => 'Testing',
            'php_function[visibility]' => 'Testing',
            'php_function[createdAt]' => 'Testing',
            'php_function[updatedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PhpFunction();
        $fixture->setTitle('My Title');
        $fixture->setSlug('My Title');
        $fixture->setDescription('My Title');
        $fixture->setText('My Title');
        $fixture->setVisibility('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PhpFunction');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PhpFunction();
        $fixture->setTitle('Value');
        $fixture->setSlug('Value');
        $fixture->setDescription('Value');
        $fixture->setText('Value');
        $fixture->setVisibility('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'php_function[title]' => 'Something New',
            'php_function[slug]' => 'Something New',
            'php_function[description]' => 'Something New',
            'php_function[text]' => 'Something New',
            'php_function[visibility]' => 'Something New',
            'php_function[createdAt]' => 'Something New',
            'php_function[updatedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/php/function/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getText());
        self::assertSame('Something New', $fixture[0]->getVisibility());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new PhpFunction();
        $fixture->setTitle('Value');
        $fixture->setSlug('Value');
        $fixture->setDescription('Value');
        $fixture->setText('Value');
        $fixture->setVisibility('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/php/function/');
        self::assertSame(0, $this->repository->count([]));
    }
}
