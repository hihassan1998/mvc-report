<?php

namespace App\Tests\Entity;

use App\Entity\EmissionsData;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class EmissionsDataDatabaseTest
 *
 * Integration test for the EmissionsData entity.
 * Tests persisting and retrieving EmissionsData objects using Doctrine ORM.
 */
class EmissionsDataDatabaseTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface|null
     * The entity manager used to interact with the database.
     */
    private $entityManager;
    /**
     * @var EmissionsData|null
     * The EmissionsData entity used during the test.
     */
    private ?EmissionsData $emissionsData = null;

    /**
     * Sets up the test environment.
     * Boots the Symfony kernel, initializes the entity manager,
     * and creates the database schema for the entity metadata.
     */
    protected function setUp(): void
    {
        self::bootKernel();
        /** @phpstan-ignore-next-line */
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();

        // Create schema for this test run
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $schemaTool = new SchemaTool($this->entityManager);
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    }
    /**
     * Tests persisting an EmissionsData entity and retrieving it from the database.
     * Asserts that all properties are saved and fetched correctly.
     */
    public function testPersistAndRetrieveEmissionsData(): void
    {
        $emissions = new EmissionsData();
        $emissions->setYear(2020);
        $emissions->setEmissionsSweden(36.5);
        $emissions->setEmissionsAbroad(65.2);
        $emissions->setTotal(101.7);

        /** @phpstan-ignore-next-line */
        $this->entityManager->persist($emissions);
        /** @phpstan-ignore-next-line */
        $this->entityManager->flush();

        $this->emissionsData = $emissions;

        // Retrieve from DB
        /** @phpstan-ignore-next-line */
        $saved = $this->entityManager->getRepository(EmissionsData::class)->find($emissions->getId());

        $this->assertNotNull($saved);
        $this->assertEquals(2020, $saved->getYear());
        $this->assertEquals(36.5, $saved->getEmissionsSweden());
        $this->assertEquals(65.2, $saved->getEmissionsAbroad());
        $this->assertEquals(101.7, $saved->getTotal());
    }

    /**
     * Cleans up after the test.
     * Removes the test entity from the database and closes the entity manager.
     */
    protected function tearDown(): void
    {
        if ($this->entityManager && $this->emissionsData) {
            $entity = $this->entityManager->find(EmissionsData::class, $this->emissionsData->getId());

            if ($entity !== null) {
                $this->entityManager->remove($entity);
                $this->entityManager->flush();
            }

            $this->entityManager->close();
            $this->entityManager = null;
        }

        parent::tearDown();
    }
}
