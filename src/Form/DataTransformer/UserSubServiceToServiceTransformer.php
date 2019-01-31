<?php
namespace App\Form\DataTransformer;

use App\Entity\Service;
use App\Entity\UserSubService;
use App\Repository\UserRepository;
use App\Repository\UserSubServiceRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.01.2019
 * Time: 16:35
 */

class UserSubServiceToServiceTransformer implements DataTransformerInterface
{
    private $userSubServiceRepository;
    private $finderCallback;

    public function __construct(UserSubServiceRepository $userSubServiceRepository, callable $finderCallback)
    {
        $this->userSubServiceRepository = $userSubServiceRepository;
        $this->finderCallback = $finderCallback;
    }

    public function transform($value)
    {
        if(null === $value){
            return '';
        }

        if(!$value instanceof UserSubService){
            throw new \LogicException('The ServiceSelectTextType can only be used with Service objects!');
        }

        return $value->getService();
    }

    public function reverseTransform($value)
    {
        if(!$value){
            return '';
        }

        $callback = $this->finderCallback;
        $userSubService = $callback($this->userSubServiceRepository, $value);

        if(!$userSubService){
            throw new TransformationFailedException(sprintf(
                'Nu userSubService found with service "%s"',
                $value
            ));
        }

        return $userSubService;
    }

}