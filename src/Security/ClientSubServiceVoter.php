<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 10:32
 */

namespace App\Security;
use App\Entity\ClientSubService;
use function in_array;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientSubServiceVoter extends Voter
{
    const CREATE = 'create_for_client';
    const EDIT   = 'edit_for_client';

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



        if(!$subject instanceof ClientSubService) {
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

        /** @var ClientSubService $clientSubService */
        $clientSubService = $subject;


        switch ($attribute) {
            case self::CREATE :
                if($this->decisionManager->decide($token, ['ROLE_CLIENT'])) {
                    $bool = true;
                }
                break;
            case self::EDIT :
                if($this->decisionManager->decide($token, ['ROLE_CLIENT'])) {
                    $bool = true;
                }
                break;
        }

        //testing for each subservice in clientSubService to belong to it's correct service
        foreach($clientSubService->getSubServices() as $subService) {
            if($subService->getService() !== $clientSubService->getService()) {
                return false;
            }
        }

        return $bool;
    }

}