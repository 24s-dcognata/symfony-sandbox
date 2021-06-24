<?php


namespace App\Factory;

use App\DTO\BlogPostDTO;
use App\Repository\BlogCommentRepository;
use App\Repository\BlogPostRepository;

final class BlogPostDTOFactory
{
    /** @var BlogPostRepository */
    private $postRepository;

    /** @var BlogCommentRepository */
    private $commentRepository;

    private $now;

    public function __construct(BlogPostRepository $postRepository, BlogCommentRepository $commentRepository, $now)
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->now = $now;
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(): array
    {
        $postViews = [];

        foreach ($this->postRepository->getAll() as $post) {
            $isLessThanAWeekOld = (clone $post->getPublishedAt())->add(new \DateInterval('P1W')) > $this->now;

            $postViews[] = new BlogPostDTO(
                $post->getTitle(),
                $this->commentRepository->countByBlogPost($post),
                $isLessThanAWeekOld
            );
        }

        return $postViews;
    }
}