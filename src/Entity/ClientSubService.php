<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientSubServiceRepository")
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *          "country": "partial",
 *          "city": "partial",
 *          "user": "exact",
 *          "user.name": "partial",
 *          "service": "exact",
 *          "service.name": "partial"
 *     }
 * )
 * @ApiFilter(
 *     DateFilter::class,
 *     properties={
 *          "published"
 *     }
 * )
 * @ApiFilter(
 *     RangeFilter::class,
 *     properties={
 *          "id"
 *     }
 * )
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={
 *          "id",
 *          "published",
 *          "service"
 *     },
 *     arguments={
 *          "orderParameterName"="_order"
 *     }
 * )
 *@ApiFilter(
 *     PropertyFilter::class,
 *     arguments={
 *          "parameterName": "properties",
 *          "overrideDefaultProperties": false,
 *          "whitelist": {"id", "service", "subServices"}
 *     }
 * )
 * @ApiResource(
 *     attributes={
 *          "order"={"published": "DESC"},
 *          "pagination_client_enabled"=true
 *     },
 *     itemOperations={
 *          "get"={
 *                  "normalization_context"={
 *                      "groups"={"get-client-sub-service-with-author"}
 *                  }
 *          },
 *          "put"={
 *              "access_control"="is_granted('edit_for_client', object) and object.getUser() == user",
 *              "access_control_message"="You do not have permissions for this resource, or you are trying to insert wrong values"
 *          }
 *     },
 *     collectionOperations={
 *          "get"={
 *              "access_control"="is_granted('ROLE_SERVICE_PROVIDER'),
 *              "normalization_context"={
 *                  "groups"={"get-client-sub-service-with-author"}
 *              }
 *          },
 *          "post"={
 *              "access_control"="is_granted('create_for_client', object)",
 *              "access_control_message"="You do not have permissions for this resource, or you are trying to insert wrong values"
 *          }
 *     },
 *     denormalizationContext={
 *          "groups"={"post"}
 *     }
 * )
 */
class ClientSubService implements AuthoredEntityInterface, PublishedDateEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get-client-sub-service-with-author"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clientSubServices")
     * @Groups({"get-client-sub-service-with-author"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="clientSubServices")
     * @Assert\NotBlank()
     * @Groups({"post", "get-client-sub-service-with-author"})
     */
    private $service;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SubService", inversedBy="clientSubServices")
     * @Groups({"post", "get-client-sub-service-with-author"})
     */
    private $subServices;

    private $subService;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"post", "get-client-sub-service-with-author"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"post", "get-client-sub-service-with-author"})
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commment", mappedBy="clientSubService")
     * @Groups({"post", "get-client-sub-service-with-author"})
     * @ApiSubresource()
     */
    private $commments;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"post", "get-client-sub-service-with-author"})
     */
    private $published;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"post", "get-client-sub-service-with-author"})
     */
    private $description;

    public function __construct()
    {
        $this->subServices = new ArrayCollection();
        $this->commments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): AuthoredEntityInterface
    {
        $this->user = $user;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|SubService[]
     */
    public function getSubServices(): Collection
    {
        return $this->subServices;
    }

    public function addSubService(SubService $subService): self
    {
        if (!$this->subServices->contains($subService)) {
            $this->subServices[] = $subService;
        }

        return $this;
    }

    public function removeSubService(SubService $subService): self
    {
        if ($this->subServices->contains($subService)) {
            $this->subServices->removeElement($subService);
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getSubService(){
        return $this->subServices;
    }

    public function setSubService(Collection $subServices){
        $this->subServices = $subServices;
    }

    /**
     * @return Collection|Commment[]
     */
    public function getCommments(): Collection
    {
        return $this->commments;
    }

    public function addCommment(Commment $commment): self
    {
        if (!$this->commments->contains($commment)) {
            $this->commments[] = $commment;
            $commment->setClientSubService($this);
        }

        return $this;
    }

    public function removeCommment(Commment $commment): self
    {
        if ($this->commments->contains($commment)) {
            $this->commments->removeElement($commment);
            // set the owning side to null (unless already changed)
            if ($commment->getClientSubService() === $this) {
                $commment->setClientSubService(null);
            }
        }

        return $this;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): PublishedDateEntityInterface
    {
        $this->published = $published;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function __toString()
    {
        return $this->getUser()->getName();
    }
}
