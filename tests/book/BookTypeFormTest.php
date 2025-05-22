<?php

namespace App\Tests\Form;

use App\Entity\Book;
use App\Form\BookTypeForm;
use Symfony\Component\Form\Test\TypeTestCase;

class BookTypeFormTest extends TypeTestCase
{
    public function testFormCanBeCreated(): void
    {
        $form = $this->factory->create(BookTypeForm::class);

        $this->assertNotNull($form);
        $this->assertInstanceOf(BookTypeForm::class, $form->getConfig()->getType()->getInnerType());
    }

    public function testSubmitValidData(): void
    {
        $formData = [
            'title' => 'Test Book',
            'isbn' => '1234567890123',
            'author' => 'Test Author',
            'image' => 'test.jpg',
        ];

        $book = new Book();

        $form = $this->factory->create(BookTypeForm::class, $book);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('Test Book', $book->getTitle());
        $this->assertEquals('1234567890123', $book->getIsbn());
        $this->assertEquals('Test Author', $book->getAuthor());
        $this->assertEquals('test.jpg', $book->getImage());
    }
}
