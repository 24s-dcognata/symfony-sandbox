<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $blogPost = new \App\Entity\BlogPost(
             "Nouveau article",
             new \DateTime()
         );
         $manager->persist($blogPost);
         $blogPost2 = new \App\Entity\BlogPost(
             "Nouveau article 2",
             new \DateTime()
         );
         $manager->persist($blogPost2);


        $blogComment = new \App\Entity\BlogComment(
            $blogPost
        );
        $manager->persist($blogComment);

        $manager->flush();
    }
}
