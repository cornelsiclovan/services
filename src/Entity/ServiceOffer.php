<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *          "author.id": "exact",
 *          "clientSubService": "exact"
 *     }
 * )
 * @ApiResource(
 *     mercure="true",
 *     attributes={
 *          "order"={"published": "DESC"},
 *          "pagination_client_enabled"=true,
 *          "pagination_client_items_per_page"=true
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={
 *                   "groups"={"get-service-offer-with-author"}
 *              }
 *          },
 *          "put"={
 *              "access_control"="is_granted('ROLE_SERVICE_PROVIDER') and object.getAuthor() == user",
 *              "access_control_message"="You do not have access to this resource.",
 *              "denormalization_context"={
 *                  "groups"={"put"}
 *              },
 *              "normalization_context"={
 *                   "groups"={"get-service-offer-with-author"}
 *              }
 *          }
 *     },
 *     collectionOperations={
 *          "post"={
 *              "access_control"="is_granted('ROLE_SERVICE_PROVIDER')",
 *              "access_control_message"="You do not have access to this resource",
 *              "normalization_context"={
 *                  "groups"={"get-service-offer-with-author"}
 *              }
 *          },
 *          "get"={
 *               "normalization_context"={
 *                   "groups"={"get-service-offer-with-author"}
 *              }
 *          }
 *     },
 *     subresourceOperations={
 *          "api_client_sub_services_service_offers_get_subresource"={
 *              "normalization_context"={
 *                   "groups"={"get-service-offer-with-author"}
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ServiceOfferRepository")
 * @UniqueEntity(
 *     fields={"author", "clientSubService"},
 *     message="You allready posted one offer for this service, please review and update if necessary."
 * )
 */
class ServiceOffer implements PublishedDateEntityInterface, AuthoredEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-service-offer-with-author", "get-author-with-service-offers", "get-client-sub-service-with-author"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"get-service-offer-with-author"})
     */
    private $published;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Groups({"get-service-offer-with-author", "put"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     * @Groups({"get-service-offer-with-author", "put"})
     */
    private $currency;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Groups({"get-service-offer-with-author", "put"})
     */
    private $timeNecessary;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull()
     * @Groups({"get-service-offer-with-author", "get-client-sub-service-with-author"})
     */
    private $accepted;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClientSubService", inversedBy="serviceOffers")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     * @Groups({"get-service-offer-with-author", "get-author-with-service-offers", "get-collection"})
     */
    private $clientSubService;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="serviceOffers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-service-offer-with-author"})
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-service-offer-with-author"})
     * @Assert\NotBlank()
     * @Groups({"put"})
     */
    private $comment;


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

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
