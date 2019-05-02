<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *     },
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          }
 *     }
 * )
 * @UniqueEntity("name")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubService", mappedBy="service")
     */
    private $subServices;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSubService", mappedBy="service")
     */
    private $userSubServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientSubService", mappedBy="service")
     */
    private $clientSubServices;


    public function __construct()
    {
        $this->subServices = new ArrayCollection();
        $this->userSubServices = new ArrayCollection();
        $this->clientSubServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $subService->setService($this);
        }

        return $this;
    }

    public function removeSubService(SubService $subService): self
    {
        if ($this->subServices->contains($subService)) {
            $this->subServices->removeElement($subService);
            // set the owning side to null (unless already changed)
            if ($subService->getService() === $this) {
                $subService->setService(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }



    /**
     * @return Collection|UserSubService[]
     */
    public function getUserSubServices(): Collection
    {
        return $this->userSubServices;
    }

    public function addUserSubService(UserSubService $userSubService): self
    {
        if (!$this->userSubServices->contains($userSubService)) {
            $this->userSubServices[] = $userSubService;
            $userSubService->setService($this);
        }

        return $this;
    }

    public function removeUserSubService(UserSubService $userSubService): self
    {
        if ($this->userSubServices->contains($userSubService)) {
            $this->userSubServices->removeElement($userSubService);
            // set the owning side to null (unless already changed)
            if ($userSubService->getService() === $this) {
                $userSubService->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClientSubService[]
     */
    public function getClientSubServices(): Collection
    {
        return $this->clientSubServices;
    }

    public function addClientSubService(ClientSubService $clientSubService): self
    {
        if (!$this->clientSubServices->contains($clientSubService)) {
            $this->clientSubServices[] = $clientSubService;
            $clientSubService->setService($this);
        }

        return $this;
    }

    public function removeClientSubService(ClientSubService $clientSubService): self
    {
        if ($this->clientSubServices->contains($clientSubService)) {
            $this->clientSubServices->removeElement($clientSubService);
            // set the owning side to null (unless already changed)
            if ($clientSubService->getService() === $this) {
                $clientSubService->setService(null);
            }
        }

        return $this;
    }

}
