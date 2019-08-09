<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ResetForgottenPasswordAction;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "post-reset-forgotten-password"={
 *              "method"="POST",
 *              "path"="/reset_forgotten_passwords",
 *              "controller"=ResetForgottenPasswordAction::class,
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PasswordResetModelRepository")
 */
class PasswordResetModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column()
     * @Assert\NotNull()
     */
    private $token;

    /**
     * @ORM\Column()
     * @Assert\NotNull()
     */
    private $newPassword;

    /**
     * @Assert\Expression(
     *     "this.getNewPassword() === this.getNewRetypedPassword()",
     *     message="Passwords do not match"
     * )
     */
    private $newRetypedPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }

    public function getNewRetypedPassword()
    {
        return $this->newRetypedPassword;
    }

    public function setNewRetypedPassword($newRetypedPassword)
    {
        $this->newRetypedPassword = $newRetypedPassword;
    }
}
