<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.05.2019
 * Time: 14:35
 */

namespace App\Security;
use App\Entity\Commment;
use function in_array;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentsVoter extends Voter
{
    const CREATE = 'create_comment';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {

        if(!in_array($attribute, [self::CREATE])) {

            return false;
        }

        if(!$subject instanceof Commment){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        /** @var Commment $comment */
        $comment = $subject;

        switch($attribute) {
            case self::CREATE :
                if($this->decisionManager->decide($token, ['ROLE_CLIENT'])) {
                    if($comment->getClientSubService()->getUser() !== $user) {
                        return false;
                    }

                    return true;
                }
                break;
        }



        dump("3");die();
        return false;
    }

}