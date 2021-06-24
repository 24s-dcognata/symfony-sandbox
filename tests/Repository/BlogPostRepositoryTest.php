<?php


namespace App\Tests\Repository;

use App\DataFixtures\BlogFixtures;
use App\Repository\BlogPostRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BlogPostRepositoryTest extends KernelTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testCount()
    {

        $this->databaseTool->loadFixtures([
            BlogFixtures::class
        ]);

        $blogPostCount = self::getContainer()->get(BlogPostRepository::class)->count([]);

        $this->assertEquals(2, $blogPostCount);
    }
}