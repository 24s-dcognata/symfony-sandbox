<?php


namespace App\Tests\Entity;

use App\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationInterface;

class BlogPostEntityTest extends KernelTestCase
{
    /**
     * @var object|\Symfony\Component\Validator\Validator\ValidatorInterface|null
     */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->validator = self::getContainer()->get('validator');
    }

    private function getEntity(): BlogPost {
        return new BlogPost(
            "Je suis le titre",
            new \DateTime()
        );
    }

    private function assertHasErrors(BlogPost $blogPost, int $number) {
        $validation = $this->validator->validate($blogPost);
        $ret = "";
        /** @var ConstraintViolationInterface $error */
        foreach ($validation as $error) {
            $ret .= $error->getPropertyPath() . ' => ' . $error->getMessage() . PHP_EOL;
        }
        $this->assertCount($number, $validation, $ret);
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

    public function testNonUniqEntries()
    {
        $loader = self::getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $loader->load([
            dirname(__DIR__) . '/../fixtures/blog_post.yaml'
        ]);

        $this->assertHasErrors($this->getEntity()
            ->setTitle('Titre 1 pour test'), 1);
        $this->assertHasErrors($this->getEntity()
            ->setTitle('Titre 2 pour test'), 1);
        $this->assertHasErrors($this->getEntity()
            ->setTitle('Titre 3 pour test'), 0);
    }
}