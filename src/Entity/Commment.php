<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommmentRepository")
 * @ApiResource(
 *     itemOperations={
 *      "get",
 *      "put"={
            "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object.getAuthor() == user"
 *      }
 *     },
 *     collectionOperations={
 *      "get",
 *      "post"={
 *          "access_control"="is_granted('create_comment', object)",
 *          "access_control_message"="You do not have access to this resource"
 *      }
 *     }
 * )
 */
class Commment implements AuthoredEntityInterface, PublishedDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commments")
     * @Assert\NotNull()
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientSubService", inversedBy="commments")
     * @Assert\NotNull()
     * @Groups({"post"})
     */
    private $clientSubService;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"post"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setUser(?UserInterface $author): AuthoredEntityInterface
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


    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param mixed $published
     */
    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface
    {
        $this->published = $published;

        return $this;
    }


}
