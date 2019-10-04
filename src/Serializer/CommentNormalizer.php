<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2019
 * Time: 15:28
 */

namespace App\Serializer;

use App\Entity\Commment;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class CommentNormalizer implements ContextAwareNormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

        const COMMENT_NORMALIZER_ALREADY_CALLED = 'COMMENT_NORMALIZER_ALREADY_CALLED';

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        if(isset($context[self::COMMENT_NORMALIZER_ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof Commment;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $context['groups'][] = 'get-comment-with-author';

        return $this->passOn($object, $format, $context);
    }


    private function passOn($object, $format, $context)
    {
//        if(!$this->serializer instanceof NormalizableInterface) {
//            throw new \LogicException(sprintf('Cannot normalize object "%s" because the injected serializer is not a normalizer.', $object));
//        }

        $context[self::COMMENT_NORMALIZER_ALREADY_CALLED] = true;

        return $this->serializer->normalize($object, $format, $context);
    }
}