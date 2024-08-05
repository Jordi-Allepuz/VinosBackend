<?php


namespace App\Service;

use App\Entity\Sensor;
use App\Form\Model\SensorDto;
use App\Form\Type\SensorFormType;
use App\Repository\SensorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SensorService
{
    private $em;
    private $sensorRepository;
    private $formFactory;

    public function __construct(EntityManagerInterface $em, SensorRepository $sensorRepository, FormFactoryInterface $formFactory)
    {
        $this->em = $em;
        $this->sensorRepository = $sensorRepository;
        $this->formFactory = $formFactory;
    }


    public function getAllSensors(): array
    {
        return $this->sensorRepository->findAllOrderedByName();
    }


    
    public function getSensorById(int $id): ?Sensor
    {
        return $this->sensorRepository->find($id);
    }


    public function createSensor(Request $request)
    {
        $sensorDto = new SensorDto();
        $form = $this->formFactory->create(SensorFormType::class, $sensorDto);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $sensor = new Sensor();
            $sensor->setName($sensorDto->name);
            $this->em->persist($sensor);
            $this->em->flush();
            return $sensor;
        }
        return $form;
    }



    public function updateSensor(Request $request, int $id)
    {
        $sensor = $this->sensorRepository->find($id);
        if (!$sensor) {
            throw new \Exception('Sensor not found');
        }

        $content = json_decode($request->getContent(), true);
        $sensorDto = new SensorDto();
        $sensorDto->name = $sensor->getName();

        $form = $this->formFactory->create(SensorFormType::class, $sensorDto);
        $form->submit($content, false);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }

        if ($form->isValid()) {
            if ($sensorDto->name !== null) {
                $sensor->setName($sensorDto->name);
            }
            $this->em->persist($sensor);
            $this->em->flush();
            return $sensor;
        }
        return $form;
    }


    public function patchSensor(Request $request, int $id)
    {
        $sensor = $this->sensorRepository->find($id);
        if (!$sensor) {
            throw new \Exception('Sensor not found');
        }

        $content = json_decode($request->getContent(), true);
        $sensor->patch($content);

        $this->em->persist($sensor);
        $this->em->flush();
        return $sensor;
    }


    public function deleteSensor(int $id): ?Sensor
    {
        $sensor = $this->sensorRepository->find($id);
        if ($sensor) {
            $this->em->remove($sensor);
            $this->em->flush();
        }
        return $sensor;
    }
}