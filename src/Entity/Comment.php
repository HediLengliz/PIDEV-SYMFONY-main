<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $rate = null;

    #[ORM\ManyToOne(inversedBy: 'comment')]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Article $articleC = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getArticleC(): ?Article
    {
        return $this->articleC;
    }

    public function setArticleC(?Article $articleC): static
    {
        $this->articleC = $articleC;

        return $this;
    }
}
