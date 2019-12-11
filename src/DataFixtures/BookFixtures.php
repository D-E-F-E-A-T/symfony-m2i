<?php


namespace App\DataFixtures;


use App\Entity\Book;
use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $book = $this->createBook("La République", "Platon", 10, "PUF");
        $manager->persist($book);

        $book = $this->createBook("Le Panquet", "Platon", 13, "Hachette");
        $manager->persist($book);

        $book = $this->createBook("Three men in a boat", "Jerome K Jerome", 12, "PUF");
        $manager->persist($book);

        $book = $this->createBook("Vernon Subutex", "V. Despentes", 15, "Seuil");
        $manager->persist($book);

        $book = $this->createBook("Dune", "Frnak Herbert", 8, "Grasset");
        $manager->persist($book);

        $manager->flush();
    }
    private  function createBook($title, $author, $price, $publisher){
        $book = new Book();
        $book->setTitle($title)->setAuthor($author)->setPrice($price)
        ->setPublisher($this->getReference("publisher_$publisher"));
        return $book;

    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
           PublisherFixtures::class
        ];
    }
}