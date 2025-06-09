<?php

namespace App\Tests\Entity;

use App\Entity\GoalArticle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;



class GoalArticleDatabaseTest extends KernelTestCase
{
    private GoalArticle $goalArticle;
    /** @phpstan-ignore-next-line */
    private $entityManager;

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

    public function testPersistAndRetrieveGoalArticle(): void
    {
        $goalArticle = new GoalArticle();
        $goalArticle->setNumber(12);
        $goalArticle->setName('Hållbar konsumtion och produktion');
        $goalArticle->setDescription('Mål 12 handlar om att minska belastningen på planeten.');
        $goalArticle->setDefination('Säkerställa hållbara konsumtions- och produktionsmönster.');
        $goalArticle->setArticleTitle('Om hållbarhet');
        $goalArticle->setArticle('Detta är en artikeltext.');

        $this->entityManager->persist($goalArticle);
        $this->entityManager->flush();

        $this->goalArticle = $goalArticle;

        // Retrieve the entity back from the database
        $savedGoalArticle = $this->entityManager->getRepository(GoalArticle::class)->find($goalArticle->getId());

        $this->assertNotNull($savedGoalArticle);
        $this->assertEquals(12, $savedGoalArticle->getNumber());
        $this->assertEquals('Hållbar konsumtion och produktion', $savedGoalArticle->getName());
        $this->assertEquals('Mål 12 handlar om att minska belastningen på planeten.', $savedGoalArticle->getDescription());
        $this->assertEquals('Säkerställa hållbara konsumtions- och produktionsmönster.', $savedGoalArticle->getDefination());
        $this->assertEquals('Om hållbarhet', $savedGoalArticle->getArticleTitle());
        $this->assertEquals('Detta är en artikeltext.', $savedGoalArticle->getArticle());
    }

    protected function tearDown(): void
    {
        if ($this->entityManager) {
            $goalFromDb = $this->entityManager->find(GoalArticle::class, $this->goalArticle->getId());

            if ($goalFromDb !== null) {
                $this->entityManager->remove($goalFromDb);
                $this->entityManager->flush();
            }

            $this->entityManager->close();
            $this->entityManager = null;
        }

        parent::tearDown();
    }

}
