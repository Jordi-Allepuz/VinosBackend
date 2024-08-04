<?php

namespace App\Serializer;

use App\Entity\Measuring;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class MeasuringNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        $data['id'] = $object->getId();
        $data['year'] = $object->getYear();
        $data['colour'] = $object->getColour();
        $data['temperature'] = $object->getTemperature();
        $data['ph'] = $object->getPh();
        $data['alcoholContent'] = $object->getAlcoholContent();
        $data['idSensor'] = [
            'id' => $object->getIdSensor()->getId(),
            'name' => $object->getIdSensor()->getName(),
        ];
        $data['idWine'] = [
            'id' => $object->getIdWine()->getId(),
            'name' => $object->getIdWine()->getName(),
            'year' => $object->getIdWine()->getYear(),
        ];


        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Measuring;
    }
}
