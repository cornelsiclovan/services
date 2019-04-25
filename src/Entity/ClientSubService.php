<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientSubServiceRepository")
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "put"={
 *              "access_control"="is_granted('ROLE_CLIENT') and object.getUser() == user",
 *              "access_control_message"="You do not have permissions for this resource"
 *          }
 *     },
 *     collectionOperations={
 *          "get"={
 *              "access_control"="is_granted('ROLE_SERVICE_PROVIDER')"
 *          },
 *          "post"={
 *              "access_control"="is_granted('ROLE_CLIENT')",
 *              "access_control_message"="You do not have permissions for this resource"
 *          }
 *     }
 * )
 */
class ClientSubService
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clientSubServices")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="clientSubServices")
     * @Assert\NotBlank()
     */
    private $service;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SubService", inversedBy="clientSubServices")
     */
    private $subServices;

    private $subService;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commment", mappedBy="clientSubService")
     */
    private $commments;

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

    public function setUser(?User $user): self
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

    public function __toString()
    {
        return $this->getUser()->getName();
    }
}
