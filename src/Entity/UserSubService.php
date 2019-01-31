<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSubServiceRepository")
 */
class UserSubService
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userSubServices")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SubService", inversedBy="userSubServices")
     */
    private $SubService;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="userSubServices")
     */
    private $service;

    public function __construct()
    {
        $this->SubService = new ArrayCollection();
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

    /**
     * @return Collection|SubService[]
     */
    public function getSubService(): Collection
    {
        return $this->SubService;
    }

    public function addSubService(SubService $subService): self
    {
        if (!$this->SubService->contains($subService)) {
            $this->SubService[] = $subService;
        }

        return $this;
    }

    public function removeSubService(SubService $subService): self
    {
        if ($this->SubService->contains($subService)) {
            $this->SubService->removeElement($subService);
        }

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
}
