<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommmentRepository")
 */
class Commment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commments")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientSubService", inversedBy="commments")
     */
    private $clientSubService;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getClientSubService(): ?ClientSubService
    {
        return $this->clientSubService;
    }

    public function setClientSubService(?ClientSubService $clientSubService): self
    {
        $this->clientSubService = $clientSubService;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
