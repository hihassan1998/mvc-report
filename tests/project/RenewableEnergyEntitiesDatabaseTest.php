<?php

namespace App\Tests\Entity;

use App\Entity\RenewableEnergyShare;
use App\Entity\RenewableEnergyUsage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;

class RenewableEnergyEntitiesDatabaseTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private RenewableEnergyShare $share;
    private RenewableEnergyUsage $usage;

    protected function setUp(): void
    {
        self::bootKernel();
        /** @phpstan-ignore-next-line */
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();

        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new SchemaTool($this->entityManager);
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    }

    public function testPersistAndRetrieveRenewableEnergyShare(): void
    {
        $share = new RenewableEnergyShare();
        $share->setYear(2022);
        $share->setTotal(55.5);
        $share->setHeatIndustry(60.2);
        $share->setElectricity(75.8);
        $share->setTransport(30.3);

        $this->entityManager->persist($share);
        $this->entityManager->flush();

        $this->share = $share;

        $saved = $this->entityManager->getRepository(RenewableEnergyShare::class)->find($share->getId());

        $this->assertNotNull($saved);
        $this->assertEquals(2022, $saved->getYear());
        $this->assertEquals(55.5, $saved->getTotal());
        $this->assertEquals(60.2, $saved->getHeatIndustry());
        $this->assertEquals(75.8, $saved->getElectricity());
        $this->assertEquals(30.3, $saved->getTransport());
    }

    public function testPersistAndRetrieveRenewableEnergyUsage(): void
    {
        $usage = new RenewableEnergyUsage();
        $usage->setYear(2023);
        $usage->setRenewableEnergyGoal(70.0);
        $usage->setTotalRenewableEnergy(65.4);

        $this->entityManager->persist($usage);
        $this->entityManager->flush();

        $this->usage = $usage;

        $saved = $this->entityManager->getRepository(RenewableEnergyUsage::class)->find($usage->getId());

        $this->assertNotNull($saved);
        $this->assertEquals(2023, $saved->getYear());
        $this->assertEquals(70.0, $saved->getRenewableEnergyGoal());
        $this->assertEquals(65.4, $saved->getTotalRenewableEnergy());
    }

    protected function tearDown(): void
    {
        if ($this->entityManager) {
            if (isset($this->share)) {
                $entity = $this->entityManager->find(RenewableEnergyShare::class, $this->share->getId());
                if ($entity !== null) {
                    $this->entityManager->remove($entity);
                }
            }

            if (isset($this->usage)) {
                $entity = $this->entityManager->find(RenewableEnergyUsage::class, $this->usage->getId());
                if ($entity !== null) {
                    $this->entityManager->remove($entity);
                }
            }

            $this->entityManager->flush();
            $this->entityManager->close();
        }

        parent::tearDown();
    }
}
