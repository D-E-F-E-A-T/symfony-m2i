<?php


namespace App\DataFixtures;


use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PublisherFixtures extends Fixture
{
    /**
     * @inheritDoc
     */

    public function load(ObjectManager $manager)
    {
        $manager->persist(
            $this->createPublisher("Grasset", "contact@grasset.fr", "www.grasset.fr")
        );
        $manager->persist(
            $this->createPublisher("PUF", "contact@puf.fr", "www.puf.fr")
        );
        $manager->persist(
            $this->createPublisher("Hachette", "contact@hachette.fr", "www.hachette.fr")
        );
        $manager->persist(
            $this->createPublisher("Seuil", "contact@seuil.fr", "www.seuil.fr")
        );
        $manager->flush();
    }

    private function createPublisher($name, $email, $site){
        $publisher = new Publisher();
        $publisher->setName($name)->setEmail($email)->setWebsite($site);
        $this->addReference("publisher_$name", $publisher);
        return $publisher;
    }
}