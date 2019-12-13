<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(
            $this->createAuthor("Ayatollah", "Ta Gueule", 1)
        );
        $manager->persist(
            $this->createAuthor("Ayatollah", "Radar", 2)
        );
        $manager->persist(
            $this->createAuthor("Ayatollah", "Maréchal Meziane", 3)
        );
        $manager->persist(
            $this->createAuthor("Ayatollah", "Chaton", 4)
        );
        $manager->flush();
    }

    private function createAuthor($firstName, $name, $order)
    {
        $author = new Author();
        $author->setFirstName($firstName)->setName($name);
        $this->addReference("author_$order", $author);
        return $author;
    }
}
