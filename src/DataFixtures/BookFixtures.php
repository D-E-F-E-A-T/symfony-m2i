<?php


namespace App\DataFixtures;


use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BookFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $book = $this->createBook("La République", "Platon", 10);
        $manager->persist($book);

        $book = $this->createBook("Le Panquet", "Platon", 13);
        $manager->persist($book);

        $book = $this->createBook("Three men in a boat", "Jerome K Jerome", 12);
        $manager->persist($book);

        $book = $this->createBook("Vernon Subutex", "V. Despentes", 15);
        $manager->persist($book);

        $book = $this->createBook("Dune", "Frnak Herbert", 8);
        $manager->persist($book);

        $manager->flush();
    }
    private  function createBook($title, $author, $price){
        $book = new Book();
        $book->setTitle($title)->setAuthor($author)->setPrice($price);
        return $book;
;
    }
}