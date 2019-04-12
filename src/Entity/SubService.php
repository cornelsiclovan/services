<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubServiceRepository")
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          }
 *     }
 * )
 */
class SubService
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="subServices")
     */
    private $service;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserSubService", mappedBy="subServices")
     */
    private $userSubServices;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ClientSubService", mappedBy="subServices")
     */
    private $clientSubServices;

    public function __construct()
    {
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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
    
    public function __toString(){
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
            $userSubService->addSubService($this);
        }

        return $this;
    }

    public function removeUserSubService(UserSubService $userSubService): self
    {
        if ($this->userSubServices->contains($userSubService)) {
            $this->userSubServices->removeElement($userSubService);
            $userSubService->removeSubService($this);
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
            $clientSubService->addSubService($this);
        }

        return $this;
    }

    public function removeClientSubService(ClientSubService $clientSubService): self
    {
        if ($this->clientSubServices->contains($clientSubService)) {
            $this->clientSubServices->removeElement($clientSubService);
            $clientSubService->removeSubService($this);
        }

        return $this;
    }

}
