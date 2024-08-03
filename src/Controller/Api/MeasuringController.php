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

/**
 * @Rest\Route("/api")
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
    public function postmeasuring(EntityManagerInterface $em, Request $request)
    {
        $measuringDto = new MeasuringDto();
        $form = $this->createForm(MeasuringFormType::class, $measuringDto);
        $form->handleRequest($request);
        
        if(!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $measuring = new Measuring();
            $measuring->setIdSensor($measuringDto->idSensor);
            $measuring->setIdWine($measuringDto->idWine);
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


//     /**
//      * @Rest\Put(path="/measurings/{id}", requirements={"id"="\d+"})
//      * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
//      */
//     public function putMeasuring(EntityManagerInterface $em, MeasuringRepository $measuringRepository, Request $request, int $id)
//    {
//         $measuring = $measuringRepository->find($id);
//         if (!$measuring) {
//             throw $this->createNotFoundException('Measuring not found');
//         }

//         $measuringDto = new MeasuringDto();
//         $measuringDto->idSensor = $measuring->getIdSensor();
//         $measuringDto->idWine = $measuring->getYear();
//         $measuringDto->temperature = $measuring->getTemperature();
//         $measuringDto->ph = $measuring->getPh();
//         $measuringDto->colour = $measuring->getColour();
//         $measuringDto->alcoholContent = $measuring->getAlcoholContent();
//         $measuringDto->year = $measuring->getYear();
//         $form = $this->createForm(MeasuringFormType::class, $measuringDto);
//         $form->handleRequest($request);

//         if(!$form->isSubmitted()) {
//             return new Response('Bad request', Response::HTTP_BAD_REQUEST);
//         }
//         if ($form->isValid()) {
//             $measuring = new Measuring();
//             $measuring->setIdSensor($measuringDto->idSensor);
//             $measuring->setIdWine($measuringDto->idWine);
//             $measuring->setTemperature($measuringDto->temperature);
//             $measuring->setPh($measuringDto->ph);
//             $measuring->setColour($measuringDto->colour);
//             $measuring->setAlcoholContent($measuringDto->alcoholContent);
//             $measuring->setYear($measuringDto->year);
//             $em->persist($measuring);
//             $em->flush();
//             return $measuring;
//         }
//         return $form;
//     }


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

