<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ResetPasswordAction;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *     itemOperations={
 *          "get"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY')",
 *              "access_control_message"="You do not have permission for this resource",
 *              "normalization_context"={
 *                  "groups"={"get"}
 *               }
 *          },
 *          "put"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *              "access_control_message"="You do not have permission for this resource",
 *              "denormalization_context"={
 *                  "groups"={"put"}
 *              },
 *              "normalization_context"={
 *                  "groups"={"get"}
 *               }
 *          },
 *           "put-reset-password"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *              "access_control_message"="You do not have permission for this resource",
 *              "method"="PUT",
 *              "path"="/users/{id}/reset-password",
 *              "controller"=ResetPasswordAction::class,
 *              "denormalization_context"={
 *                  "groups"={"put-reset-password"}
 *              },
 *              "validation_groups"={"put-reset-password"}
 *          }
 *      },
 *     collectionOperations={
 *          "post"={
 *             "denormalization_context"={
 *                  "groups"={"post"}
 *              },
 *              "normalization_context"={
 *                  "groups"={"get"}
 *              },
 *               "validation_groups"={"post"}
 *          }
 *     }
 * )
 * @UniqueEntity("email", groups={"post", "put"})
 */
class User implements UserInterface
{
    const ROLE_ADMIN = "ROLE_ADMIN";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"post", "put"})
     * @Groups({"get", "put", "post", "get-comment-with-author", "get-client-sub-service-with-author"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(groups={"post", "put"})
     * @Groups({"get", "post", "put", "get-comment-with-author", "get-client-sub-service-with-author"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(groups={"post"})
     * @Assert\Email(groups={"post"})
     * @Groups({"post", "get-admin", "get-owner"})
     * @Assert\Length(min=6, max=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image")
     * @Groups({"get", "post", "put"})
     * @ApiSubresource()
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"post"})
     * @Groups({"get", "post", "put"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"post"})
     * @Groups({"get", "post", "put"})
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"post"})
     * @Groups({"get", "post", "put"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"post"})
     * @Groups({"get", "post", "put"})
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $building;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $staircase;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $apartment;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"post"})
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Passwords must be seven characters long and contain at least one digit, one uppercase letter and one lowecase letter",
     *     groups={"post"}
     * )
     * @Groups({"post"})
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"post"})
     * @Assert\Expression(
     *     "this.getPassword() === this.getPlainPassword()",
     *     message="Passwords do not match",
     *     groups={"post"}
     * )
     * @Groups({"post"})
     */
    private $plainPassword;

    /**
     * @Groups({"put-reset-password"})
     * @Assert\NotBlank(groups={"put-reset-password"})
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Passwords must be seven characters long and contain at least one digit, one uppercase letter and one lowecase letter",
     *     groups={"put-reset-password"}
     * )
     */
    private $newPassword;

    /**
     * @Groups({"put-reset-password"})
     * @Assert\NotBlank(groups={"put-reset-password"})
     * @Assert\Expression(
     *     "this.getNewPassword() === this.getNewRetypedPassword()",
     *     message="Passwords do not match",
     *     groups={"put-reset-password"}
     * )
     */
    private $newRetypedPassword;

    /**
     * @Groups({"put-reset-password"})
     * @Assert\NotBlank(groups={"put-reset-password"})
     * @UserPassword(groups={"put-reset-password"})
     */
    private $oldPassword;

    /**
     * @ORM\Column(type="json_array")
     * @Groups({"get-admin", "get-owner", "put", "post"})
     * @Assert\NotNull(groups={"post"})
     */
    private $roles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $passwordChangeDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSubService", mappedBy="user")
     * @Groups({"get"})
     * @ApiSubresource()
     */
    private $userSubServices;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Expression(
     *     "!this.getIsServiceProvider()==false || !this.getIsClient()==false",
     *     message="Please select one of the two options(client or service provider)"
     * )
     * @Groups({"get", "put", "post"})
     * @Assert\NotNull(groups={"post"})
     */
    private $isServiceProvider;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get", "put", "post"})
     * @Assert\NotNull(groups={"post"})
     */
    private $isClient;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientSubService", mappedBy="user")
     * @Groups({"get"})
     * @ApiSubresource()
     */
    private $clientSubServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commment", mappedBy="author")
     * @Groups({"get", "put", "post"})

     */
    private $commments;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get", "put", "post"})
     */
    private $enabled;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $confirmationToken;

    public function __construct()
    {
        $this->userSubServices = new ArrayCollection();
        $this->clientSubServices = new ArrayCollection();
        $this->commments = new ArrayCollection();
        $this->enabled = false;
        $this->confirmationToken = null;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function setBuilding(?string $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getStaircase(): ?string
    {
        return $this->staircase;
    }

    public function setStaircase(?string $staircase): self
    {
        $this->staircase = $staircase;

        return $this;
    }

    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    public function setApartment(?string $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        if(!in_array('ROLE_USER', $roles)){
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles($roles): self
    {
        $this->setIsServiceProvider(false);
        $this->setIsClient(false);

        foreach($roles as $role){
            if($role === 'ROLE_CLIENT'){
                $this->setIsClient(true);
            }else if($role === 'ROLE_SERVICE_PROVIDER'){
                $this->setIsServiceProvider(true);
            }
        }

        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword(){
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword){
        $this->plainPassword = $plainPassword;
        //$this->password = null;
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
            $userSubService->setUser($this);
        }

        return $this;
    }

    public function removeUserSubService(UserSubService $userSubService): self
    {
        if ($this->userSubServices->contains($userSubService)) {
            $this->userSubServices->removeElement($userSubService);
            // set the owning side to null (unless algety changed)
            if ($userSubService->getUser() === $this) {
                $userSubService->setUser(null);
            }
        }

        return $this;
    }

    public function getIsServiceProvider(): ?bool
    {
        return $this->isServiceProvider;
    }

    public function setIsServiceProvider(bool $isServiceProvider): self
    {
        $this->isServiceProvider = $isServiceProvider;

        return $this;
    }

    public function getIsClient(): ?bool
    {
        return $this->isClient;
    }

    public function setIsClient(bool $isClient): self
    {
        $this->isClient = $isClient;

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
            $clientSubService->setUser($this);
        }

        return $this;
    }

    public function removeClientSubService(ClientSubService $clientSubService): self
    {
        if ($this->clientSubServices->contains($clientSubService)) {
            $this->clientSubServices->removeElement($clientSubService);
            // set the owning side to null (unless algety changed)
            if ($clientSubService->getUser() === $this) {
                $clientSubService->setUser(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
       return $this->getFirstName().' '.$this->getName();
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
            $commment->setAuthor($this);
        }

        return $this;
    }

    public function removeCommment(Commment $commment): self
    {
        if ($this->commments->contains($commment)) {
            $this->commments->removeElement($commment);
            // set the owning side to null (unless algety changed)
            if ($commment->getAuthor() === $this) {
                $commment->setAuthor(null);
            }
        }

        return $this;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }

    public function getNewRetypedPassword(): ?string
    {
        return $this->newRetypedPassword;
    }

    public function setNewRetypedPassword($newRetypedPassword)
    {
        $this->newRetypedPassword = $newRetypedPassword;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    public function getPasswordChangeDate()
    {
        return $this->passwordChangeDate;
    }

    public function setPasswordChangeDate($passwordChangeDate)
    {
        $this->passwordChangeDate = $passwordChangeDate;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
}
