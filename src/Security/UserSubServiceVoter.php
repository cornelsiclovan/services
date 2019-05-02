<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 11:37
 */

namespace App\Security;
use App\Entity\UserSubService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserSubServiceVoter extends Voter
{
    const CREATE = 'create_for_provider';
    const EDIT   = 'edit_for_provider';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if(!in_array($attribute, [self::CREATE, self::EDIT])) {
            return false;
        }

        if(!$subject instanceof UserSubService) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        $bool = false;

        if(!$user instanceof UserInterface) {
            return false;
        }

        /** @var UserSubService $userSubService */
        $userSubService = $subject;

        switch ($attribute) {
            case self::CREATE :
                if($this->decisionManager->decide($token, ['ROLE_SERVICE_PROVIDER'])) {
                    $bool = true;
                }
                break;
            case self::EDIT :
                if($this->decisionManager->decide($token, ['ROLE_SERVICE_PROVIDER'])) {
                    $bool = true;
                }
                break;
        }

        //testing for each subservice in clientSubService to belong to it's correct service
        foreach($userSubService->getSubServices() as $subService) {
            if($subService->getService() !== $userSubService->getService()) {
                return false;
            }
        }

        return $bool;

    }

}