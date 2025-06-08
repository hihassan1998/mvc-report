<?php

namespace App\Tests\Entity;

use App\Entity\GoalArticle;
use PHPUnit\Framework\TestCase;

class GoalArticleTest extends TestCase
{
    public function testGoalArticleProperties(): void
    {
        $goal = new GoalArticle();

        $number = 12;
        $name = 'Hållbar konsumtion och produktion';
        $description = 'Mål 12 handlar om att säkerställa hållbara konsumtions- och produktionsmönster.';
        $defination = 'Minska ekologiskt fotavtryck genom ändrad produktion och konsumtion.';
        $article = 'Detta är en artikeltext.';
        $articleTitle = 'Artikel om hållbarhet';

        $goal->setNumber($number);
        $goal->setName($name);
        $goal->setDescription($description);
        $goal->setDefination($defination);
        $goal->setArticle($article);
        $goal->setArticleTitle($articleTitle);

        $this->assertSame($number, $goal->getNumber());
        $this->assertSame($name, $goal->getName());
        $this->assertSame($description, $goal->getDescription());
        $this->assertSame($defination, $goal->getDefination());
        $this->assertSame($article, $goal->getArticle());
        $this->assertSame($articleTitle, $goal->getArticleTitle());

        $this->assertNull($goal->getId());
    }
}
