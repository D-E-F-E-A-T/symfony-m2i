<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $numberOfAuthors = 4;

        for ($i = 1; $i <= 100; $i++) {
            $article = new Article();
            $article->setTitle($faker->bs())
                ->setAuthor($this->getReference("author_" . mt_rand(1, $numberOfAuthors)))
                ->setText($faker->text(mt_rand(300, 1500)))
                ->setCreatedAt($faker->dateTimeThisDecade);

            $this->addReference("article_$i", $article);

            $manager->persist($article);
        }


        $manager->flush();
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
            AuthorFixtures::class
        ];
    }
}
