<?php

namespace App\Service;

use App\Entity\Measuring;
use App\Form\Model\MeasuringDto;
use App\Form\Type\MeasuringFormType;
use App\Repository\MeasuringRepository;
use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MeasuringService
{
    private $em;
    private $measuringRepository;
    private $sensorRepository;
    private $wineRepository;
    private $formFactory;

    public function __construct(
        EntityManagerInterface $em,
        MeasuringRepository $measuringRepository,
        SensorRepository $sensorRepository,
        WineRepository $wineRepository,
        FormFactoryInterface $formFactory
    ) {
        $this->em = $em;
        $this->measuringRepository = $measuringRepository;
        $this->sensorRepository = $sensorRepository;
        $this->wineRepository = $wineRepository;
        $this->formFactory = $formFactory;
    }

    public function getAllMeasurings(): array
    {
        return $this->measuringRepository->findAll();
    }

    public function getMeasuringById(int $id): ?Measuring
    {
        return $this->measuringRepository->find($id);
    }

    public function createMeasuring(Request $request)
    {
        $measuringDto = new MeasuringDto();
        $form = $this->formFactory->create(MeasuringFormType::class, $measuringDto);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $measuring = new Measuring();

            $sensor = $this->sensorRepository->find($measuringDto->idSensor);
            if (!$sensor) {
                return new Response('Sensor not found', Response::HTTP_NOT_FOUND);
            }
            $measuring->setIdSensor($sensor);

            $wine = $this->wineRepository->find($measuringDto->idWine);
            if (!$wine) {
                return new Response('Wine not found', Response::HTTP_NOT_FOUND);
            }
            $measuring->setIdWine($wine);

            $measuring->setTemperature($measuringDto->temperature);
            $measuring->setPh($measuringDto->ph);
            $measuring->setColour($measuringDto->colour);
            $measuring->setAlcoholContent($measuringDto->alcoholContent);
            $measuring->setYear($measuringDto->year);

            $this->em->persist($measuring);
            $this->em->flush();
            return $measuring;
        }
        return $form;
    }

    public function updateMeasuring(Request $request, int $id)
    {
        $measuring = $this->measuringRepository->find($id);
        if (!$measuring) {
            throw new \Exception('Measuring not found');
        }

        $content = json_decode($request->getContent(), true);
        $measuringDto = new MeasuringDto();
        $measuringDto->idSensor = $measuring->getIdSensor();
        $measuringDto->idWine = $measuring->getIdWine();
        $measuringDto->temperature = $measuring->getTemperature();
        $measuringDto->ph = $measuring->getPh();
        $measuringDto->colour = $measuring->getColour();
        $measuringDto->alcoholContent = $measuring->getAlcoholContent();
        $measuringDto->year = $measuring->getYear();

        $form = $this->formFactory->create(MeasuringFormType::class, $measuringDto);
        $form->submit($request->request->all(), false);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            if ($measuringDto->idWine !== null) {
                $wine = $this->wineRepository->find($measuringDto->idWine);
                if (!$wine) {
                    throw new \Exception('Wine not found');
                }
                $measuring->setIdWine($wine);
            }
            if ($measuringDto->idSensor !== null) {
                $sensor = $this->sensorRepository->find($measuringDto->idSensor);
                if (!$sensor) {
                    throw new \Exception('Sensor not found');
                }
                $measuring->setIdSensor($sensor);
            }
            if ($measuringDto->temperature !== null) {
                $measuring->setTemperature($measuringDto->temperature);
            }
            if ($measuringDto->ph !== null) {
                $measuring->setPh($measuringDto->ph);
            }
            if ($measuringDto->colour !== null) {
                $measuring->setColour($measuringDto->colour);
            }
            if ($measuringDto->alcoholContent !== null) {
                $measuring->setAlcoholContent($measuringDto->alcoholContent);
            }
            if ($measuringDto->year !== null) {
                $measuring->setYear($measuringDto->year);
            }

            $this->em->persist($measuring);
            $this->em->flush();
            return $measuring;
        }
        return $form;
    }

    public function patchMeasuring(Request $request, int $id)
    {
        $measuring = $this->measuringRepository->find($id);
        if (!$measuring) {
            throw new \Exception('Measuring not found');
        }

        $content = json_decode($request->getContent(), true);
        $measuring->patch($content);

        $this->em->persist($measuring);
        $this->em->flush();
        return $measuring;
    }

    public function deleteMeasuring(int $id): ?Measuring
    {
        $measuring = $this->measuringRepository->find($id);
        if ($measuring) {
            $this->em->remove($measuring);
            $this->em->flush();
        }
        return $measuring;
    }
}