<?php

namespace App\Serializer;

use App\Entity\Wine;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class WineNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        $data = [];
        $data['id'] = $object->getId();
        $data['name'] = $object->getName();
        $data['year'] = $object->getYear();

        $data['measurings'] = [];
        foreach ($object->getMeasurings() as $measuring) {
            $data['measurings'][] = [
                'id' => $measuring->getId(),
                'year' => $measuring->getYear(),
                'colour' => $measuring->getColour(),
                'temperature' => $measuring->getTemperature(),
                'ph' => $measuring->getPh(),
                'alcoholContent' => $measuring->getAlcoholContent(),    
                'idSensor' => $measuring->getIdSensor()->getId()
            ];
        }
        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Wine;
    }
}