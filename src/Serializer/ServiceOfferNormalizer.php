<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.04.2020
 * Time: 15:00
 */

namespace App\Serializer;
use App\Entity\ServiceOffer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class ServiceOfferNormalizer implements ContextAwareNormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;
    const SERVICE_OFFER_NORMALIZER_ALREADY_CALLED = 'SERVICE_OFFER_NORMALIZER_ALREADY_CALLED';

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        if(isset($context[self::SERVICE_OFFER_NORMALIZER_ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof ServiceOffer;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $context['groups'][] = 'get-service-offer-with-author';

        return $this->passOn($object, $format, $context);
    }

    private function passOn($object, $format, $context)
    {


        $context[self::SERVICE_OFFER_NORMALIZER_ALREADY_CALLED] = true;
        return $this->serializer->normalize($object, $format, $context);

    }
}