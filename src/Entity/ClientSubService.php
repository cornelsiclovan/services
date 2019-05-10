<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientSubServiceRepository")
 * @ApiResource(
 *     itemOperations={
 *          "get"={
                "normalization_context"={
 *                  "groups"={"get-client-sub-service-with-author"}
 *              }
 *          },
 *          "put"={
 *              "access_control"="is_granted('edit_for_clien', object) and object.getUser() == user",
 *              "access_control_message"="You do not have permissions for this resource, or you are trying to insert wrong values"
 *          }
 *     },
 *     collectionOperations={
 *          "get"={"access_control"="is_granted('ROLE_SERVICE_PROVIDER')"},
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



    public function __toString()
    {
        return $this->getUser()->getName();
    }
}
