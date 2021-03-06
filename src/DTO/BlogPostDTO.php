<?php


namespace App\DTO;

final class BlogPostDTO
{
    /** @var string */
    public $title;

    /** @var int */
    public $commentsNumber;

    /** @var bool */
    public $isNew;

    public function __construct(string $title, int $commentsNumber, bool $isNew)
    {
        $this->title = $title;
        $this->commentsNumber = $commentsNumber;
        $this->isNew = $isNew;
    }
}