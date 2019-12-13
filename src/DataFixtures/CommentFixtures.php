<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $numberOfArticles = 100;

        for ($i = 1; $i <= $numberOfArticles; $i++) {
            $article = $this->getReference("article_$i");
            for ($k = 0; $k < mt_rand(0, 10); $k++) {
                $comment = new Comment();
                $comment->setArticle($article)
                    ->setEmail($faker->email)
                    ->setText($faker->realText(mt_rand(50, 500)))
                    ->setCreatedAt($faker->dateTimeThisDecade);
                $manager->persist($comment);
            }

        }
        /* $manager->persist($this->createComment("de@de.de", "2014-01-01 20:53:46", "Je suis d'accord"));
         $manager->persist($this->createComment("ae@ae.ae", "2010-01-01 20:53:46", "Je ne suis pas d'accrod"));
         $manager->persist($this->createComment("ce@ce.ce", "2009-01-01 20:53:46", "ça dépands"));
         $manager->persist($this->createComment("be@be.be", "1995-01-01 20:53:46", "Rien à dire"));
         $manager->persist($this->createComment("ee@ee.ee", "2000-01-01 20:53:46", "Vous êtes encore là"));
 */
        $manager->flush();
    }
    /*  private function createComment($email, $createdAt, $text){
          $article = new Comment();p
          $date = new \DateTime($createdAt);
          $article->setEmail($email)->setCreatedAt($date)->setText($text);
          return $article;
      }*/
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
       return [
           ArticleFixtures::class
       ];
    }
}
