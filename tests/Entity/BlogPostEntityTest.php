<?php


namespace App\Tests\Entity;

use App\Entity\BlogPost;
use Nelmio\Alice\Loader\NativeLoader;
use Nelmio\Alice\Throwable\LoadingThrowable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BlogPostEntityTest extends KernelTestCase
{
    private function getEntity(): BlogPost {
        return new BlogPost(
            "Je suis le titre",
            new \DateTime()
        );
    }

    private function assertHasErrors(BlogPost $blogPost, int $number) {
        self::bootKernel();
        $validator = self::getContainer()->get('validator');
        $this->assertCount($number, $validator->validate($blogPost));
    }

    public function testTitleIsValid()
    {
        $this->assertHasErrors($this->getEntity(), 0);
        $this->assertHasErrors($this->getEntity()
            ->setTitle(""), 1);
    }

    public function testDateIsValid()
    {
        $this->assertHasErrors($this->getEntity()
            ->setPublishedAt(new \DateTime()), 0);

        $this->assertHasErrors($this->getEntity(), 0);
    }

    /**
     * @throws LoadingThrowable
     */
    public function testNonUniqEntries()
    {
        $loader = self::getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $loader->load([
            dirname(__DIR__) . '/../fixtures/blog_post.yaml'
        ]);

        $this->assertHasErrors($this->getEntity()
            ->setTitle('Titre 1 pour test'), 1);
    }
}