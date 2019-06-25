<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "put"={
 *              "access_control"="is_granted('ROLE_SERVICE_PROVIDER' and object.getAuthor() == user)",
 *              "access_control_message"="You do not have access to this resource."
 *          },
 *     },
 *     collectionOperations={
 *          "post"={
 *              "access_control"="is_granted('ROLE_SERVICE_PROVIDER')"
 *          },
 *          "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ServiceOfferRepository")
 * @UniqueEntity(
 *     fields={"author", "clientSubService"},
 *     message="You allready posted one offer for this post, you can update it."
 * )
 */
class ServiceOffer implements PublishedDateEntityInterface, AuthoredEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $currency;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $timeNecessary;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     */
    private $accepted;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientSubService", inversedBy="serviceOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clientSubService;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="serviceOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface
    {
        $this->published = $published;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTimeNecessary(): ?string
    {
        return $this->timeNecessary;
    }

    public function setTimeNecessary(string $timeNecessary): self
    {
        $this->timeNecessary = $timeNecessary;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * @return ClientSubService
     */
    public function getClientSubService(): ClientSubService
    {
        return $this->clientSubService;
    }

    /**
     * @param ClientSubService $clientSubService
     * @return ServiceOffer
     */
    public function setClientSubService(ClientSubService $clientSubService): self
    {
        $this->clientSubService = $clientSubService;
        return $this;
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
}
