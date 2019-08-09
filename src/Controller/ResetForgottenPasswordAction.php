<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.08.2019
 * Time: 11:20
 */

namespace App\Controller;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\PasswordResetModel;
use App\Entity\PasswordResetTokenEntity;
use App\Entity\User;
use App\Exception\InvalidUserException;
use App\Repository\PasswordResetTokenEntityRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\UserNotFoundException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetForgottenPasswordAction
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var JWTTokenManagerInterface
     */
    private $tokenManager;

    /**
     * @var PasswordResetTokenEntity
     */
    private $passwordResetTokenRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $userPasswordEncoder,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $tokenManager,
        PasswordResetTokenEntityRepository $passwordResetTokenEntityRepository,
        UserRepository $userRepository)
    {
        $this->validator = $validator;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
        $this->tokenManager = $tokenManager;
        $this->passwordResetTokenRepository = $passwordResetTokenEntityRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(PasswordResetModel $data)
    {
        $this->validator->validate($data);

        /** @var PasswordResetTokenEntity $passwordResetToken */
        $passwordResetToken = $this->passwordResetTokenRepository->findOneBy(['token' => $data->getToken()]);


        if($passwordResetToken === null)
            throw new UserNotFoundException("This is not a valid token", 401);

        $userId = $passwordResetToken->getUser()->getId();

        $user = $this->userRepository->findOneBy(['id' => $userId]);


        $user->setPassword(
            $this->userPasswordEncoder->encodePassword(
                $user, $data->getNewPassword()
            )
        );

        $user->setPasswordChangeDate(time());

        $this->entityManager->remove($passwordResetToken);

        $this->entityManager->flush();
        return new JsonResponse(['success' => "Password was changed succesfully"]);
    }
}