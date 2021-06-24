<?php


namespace App\Tests\Post;

use App\Entity\BlogPost;
use App\Factory\BlogPostDTOFactory;
use App\DTO\BlogPostDTO;
use App\Repository\BlogCommentRepository;
use App\Repository\BlogPostRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class GetBlogPostsListTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function test_get_new_and_old_posts()
    {
        $now = new \DateTime('2018-10-30');
        $post1 = new BlogPost('TDD c\'est bien', new \DateTime('2018-10-29'));
        $post2 = new BlogPost('Tester ce n\'est pas douter', new \DateTime('2018-10-01'));

        // mock of PostRepository interface
        /** @var BlogPostRepository $postRepository */
        $postRepository = $this->prophesize(BlogPostRepository::class);
        $postRepository->getAll()->shouldBeCalled()->willReturn([$post1, $post2]);

        // mock of CommentRepository interface
        /** @var BlogCommentRepository $commentRepository */
        $commentRepository = $this->prophesize(BlogCommentRepository::class);
        $commentRepository->countByBlogPost($post1)->shouldBeCalled()->willReturn(42);
        $commentRepository->countByBlogPost($post2)->shouldBeCalled()->willReturn(1);

        $getPostsList = new BlogPostDTOFactory($postRepository->reveal(), $commentRepository->reveal(), $now);

        $this->assertEquals(
            [
                new BlogPostDTO('TDD c\'est bien', 42, true),
                new BlogPostDTO('Tester ce n\'est pas douter', 1, false),
            ],
            $getPostsList()
        );
    }
}