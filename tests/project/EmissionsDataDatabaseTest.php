<?php

namespace App\Tests\Entity;

use App\Entity\EmissionsData;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmissionsDataDatabaseTest extends KernelTestCase
{
    private $entityManager;
    private ?EmissionsData $emissionsData = null;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = static::getContainer()->get('doctrine')->getManager();

        // Create schema for this test run
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $schemaTool = new SchemaTool($this->entityManager);
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    }

    public function testPersistAndRetrieveEmissionsData(): void
    {
        $emissions = new EmissionsData();
        $emissions->setYear(2020);
        $emissions->setEmissionsSweden(36.5);
        $emissions->setEmissionsAbroad(65.2);
        $emissions->setTotal(101.7);

        $this->entityManager->persist($emissions);
        $this->entityManager->flush();

        $this->emissionsData = $emissions;

        // Retrieve from DB
        $saved = $this->entityManager->getRepository(EmissionsData::class)->find($emissions->getId());

        $this->assertNotNull($saved);
        $this->assertEquals(2020, $saved->getYear());
        $this->assertEquals(36.5, $saved->getEmissionsSweden());
        $this->assertEquals(65.2, $saved->getEmissionsAbroad());
        $this->assertEquals(101.7, $saved->getTotal());
    }

    protected function tearDown(): void
    {
        if ($this->entityManager && $this->emissionsData) {
            $entity = $this->entityManager->find(EmissionsData::class, $this->emissionsData->getId());

            if ($entity !== null) {
                $this->entityManager->remove($entity);
                $this->entityManager->flush();
            }

            $this->entityManager->close();
            $this->entityManager = null; // avoid memory leaks
        }

        parent::tearDown();
    }
}
