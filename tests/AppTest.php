<?php


namespace App\Tests;

use App\Entity\BlogPost;
use App\Factory\BlogPostDTOFactory;
use App\DTO\BlogPostDTO;
use App\Repository\BlogCommentRepository;
use App\Repository\BlogPostRepository;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testCheckAdd()
    {
        $this->assertEquals(4, 2 + 2);
    }
}