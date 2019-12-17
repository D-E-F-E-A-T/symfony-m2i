<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthorFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AuthorFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $manager->persist(
            $this->createAuthor("Ayatollah", "TaGueule", "tg@gmail.com", 1)
        );
        $manager->persist(
            $this->createAuthor("Ayatollah", "Radar", "rd@gmail.com", 2)
        );
        $manager->persist(
            $this->createAuthor("Ayatollah", "MarechalMeziane", "mm@gmail.com", 3)
        );
        $manager->persist(
            $this->createAuthor("Ayatollah", "Chaton", "ch@gmail.com", 4)
        );
        $manager->flush();
    }

    private function createAuthor($firstName, $name, $email, $order)
    {
        $author = new Author();
        $author->setFirstName($firstName)->setName($name)
            ->setPassword($this->encoder->encodePassword($author, '123'))
        ->setEmail($email);
        $this->addReference("author_$order", $author);
        return $author;
    }
}
