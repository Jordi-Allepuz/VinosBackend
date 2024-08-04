<?php


namespace App\Controller\Api;

use App\Repository\MeasuringRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Measuring;
use App\Form\Model\MeasuringDto;
use App\Form\Type\MeasuringFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

/**
 * @Rest\Route("/api")
 * @Nelmio\Areas({"internal"})
 */
class MeasuringController extends AbstractFOSRestController
{

    /**
    * @Rest\Get(path="/measurings")
    * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
    */
    public function getMeasurings(MeasuringRepository $measuringRepository)
    {
        return $measuringRepository->findAll();
    }


    /**
    * @Rest\Get(path="/measurings/{id}", requirements={"id"="\d+"}) 
    * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
    */
    public function getMeasuringById(MeasuringRepository $measuringRepository, int $id)
    {
        return $measuringRepository->find($id);
    }


    /** 
    * @Rest\Post(path="/measurings")
    * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
    */
    public function postmeasuring(EntityManagerInterface $em, Request $request, SensorRepository $sensorRepository, WineRepository $wineRepository)
    {
        $measuringDto = new MeasuringDto();
        $form = $this->createForm(MeasuringFormType::class, $measuringDto);
        $form->handleRequest($request);
        
        if(!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $measuring = new Measuring();

            $sensor = $sensorRepository->find($measuringDto->idSensor);
            if (!$sensor) {
                return new Response('Sensor not found', Response::HTTP_NOT_FOUND);
            }
            $measuring->setIdSensor($sensor);

            
            $wine = $wineRepository->find($measuringDto->idWine);
            if (!$wine) {
                return new Response('Wine not found', Response::HTTP_NOT_FOUND);
            }
            $measuring->setIdWine($wine);


            $measuring->setTemperature($measuringDto->temperature);
            $measuring->setPh($measuringDto->ph);
            $measuring->setColour($measuringDto->colour);
            $measuring->setAlcoholContent($measuringDto->alcoholContent);
            $measuring->setYear($measuringDto->year);

            $em->persist($measuring);
            $em->flush();
            return $measuring;
        }
        return $form;
    }


    /**
     * @Rest\Put(path="/measurings/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
     */
    public function putMeasuring(EntityManagerInterface $em, MeasuringRepository $measuringRepository,WineRepository $wineRepository, SensorRepository $sensorRepository  ,Request $request, int $id)
   {
    $measuring = $measuringRepository->find($id);
    if (!$measuring) {
        throw $this->createNotFoundException('Measuring not found');
    }

    $content = json_decode($request->getContent(), true);
    $measuringDto = new MeasuringDto();

    $measuringDto = new MeasuringDto();
    $measuringDto->idSensor = $measuring->getIdSensor();
    $measuringDto->idWine = $measuring->getYear();
    $measuringDto->temperature = $measuring->getTemperature();
    $measuringDto->ph = $measuring->getPh();
    $measuringDto->colour = $measuring->getColour();
    $measuringDto->alcoholContent = $measuring->getAlcoholContent();
    $measuringDto->year = $measuring->getYear();
    
    $form = $this->createForm(MeasuringFormType::class, $measuringDto);
    $form->submit($request->request->all(), false);

    if(!$form->isSubmitted()) {
        return new Response('Bad request', Response::HTTP_BAD_REQUEST);
    }
    if ($form->isValid()) {
        if ($measuringDto->idWine !== null) {
            $wine = $wineRepository->find($measuringDto->idWine);
            if (!$wine) {
                throw $this->createNotFoundException('Wine not found');
            }
            $measuring->setIdWine($wine);
        }
        if ($measuringDto->idSensor !== null) {
            $measuring->setIdSensor($measuringDto->idSensor);
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
        $em->persist($measuring);
        $em->flush();
        return $measuring;
    }
    return $form;
    }


    /**
     * @Rest\Patch(path="/measurings/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
     */
    public function patchMeasuring(EntityManagerInterface $em, MeasuringRepository $measuringRepository, Request $request, int $id)
    {
        $measuring = $measuringRepository->find($id);
        if (!$measuring) {
            throw $this->createNotFoundException('Measuring not found');
        }

        $content = json_decode($request->getContent(), true);
        $measuring->patch($content);

        $em->persist($measuring);
        $em->flush();
        return $measuring;

    }



    /**
     * @Rest\Delete(path="/measurings/{id}" , requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteMeasuring(EntityManagerInterface $em, MeasuringRepository $measuringRepository, int $id)
    {
        $measuring = $measuringRepository->find($id);
        if ($measuring) {
            $em->remove($measuring);
            $em->flush();
        }
        return $measuring;
    }



}

