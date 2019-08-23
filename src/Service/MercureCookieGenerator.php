<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.08.2019
 * Time: 15:02
 */

namespace App\Service;
use App\Entity\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha384;

class MercureCookieGenerator
{
    /**
     * @var string
     */
    private $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function generate(User $user)
    {
        $token = (new Builder())
            ->set('mercure', ['subscribe' => ['http://localhost:8000/user/{$user->getId()}']])
            ->sign(new Sha384(), $this->secret)
            ->getToken();
        return "mercureAuthorization={$token}; Path=/hub; HttpOnly;";
    }
}