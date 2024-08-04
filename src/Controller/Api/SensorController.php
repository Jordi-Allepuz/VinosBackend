<?php


namespace App\Controller\Api;

use App\Repository\SensorRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Sensor;
use App\Form\Model\SensorDto;
use App\Form\Type\SensorFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

/**
 * @Rest\Route("/api")
 * @Nelmio\Areas({"internal"})
 */
class SensorController extends AbstractFOSRestController
{

    /**
    * @Rest\Get(path="/sensors")
    * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
    */
    public function getSensors(SensorRepository $sensorRepository)
    {
        return $sensorRepository->findAllOrderedByName();
    }


    /**
    * @Rest\Get(path="/sensors/{id}", requirements={"id"="\d+"}) 
    * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
    */
    public function getSensorById(SensorRepository $sensorRepository, int $id)
    {
        return $sensorRepository->find($id);
    }


    /** 
    * @Rest\Post(path="/sensors")
    * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
    */
    public function postSensor(EntityManagerInterface $em, Request $request)
    {
        $sensorDto = new SensorDto();
        $form = $this->createForm(SensorFormType::class, $sensorDto);
        $form->handleRequest($request);
        
        if(!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $sensor = new Sensor();
            $sensor->setName($sensorDto->name);
            $em->persist($sensor);
            $em->flush();
            return $sensor;
        }
        return $form;
    }


    /**
     * @Rest\Put(path="/sensors/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
     */
    public function putSensor(EntityManagerInterface $em, SensorRepository $sensorRepository, Request $request, int $id)
   {
        $sensor = $sensorRepository->find($id);
        if (!$sensor) {
            throw $this->createNotFoundException('Sensor not found');
        }

        $content = json_decode($request->getContent(), true);
        $sensorDto = new SensorDto();

        $sensorDto->name = $sensor->getName();

        $form = $this->createForm(SensorFormType::class, $sensorDto);
        $form->submit($content, false);

        if(!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }

        if ($form->isValid()) {
            if ($sensorDto->name !== null) {
                $sensor->setName($sensorDto->name);
            }
            $em->persist($sensor);
            $em->flush();
            return $sensor;
        }
        return $form;
    }


    /**
     * @Rest\Patch(path="/sensors/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
     */
    public function pathSensor (int $id, Request $request, EntityManagerInterface $em, SensorRepository $sensorRepository)
    {
        $sensor = $sensorRepository->find($id);
        if (!$sensor) {
            throw $this->createNotFoundException('Sensor not found');
        }

        $content = json_decode($request->getContent(), true);
        $sensor->patch($content);

        $em->persist($sensor);
        $em->flush();
        return $sensor;
    }


    /**
     * @Rest\Delete(path="/sensors/{id}" , requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteSensor(EntityManagerInterface $em, SensorRepository $sensorRepository, int $id)
    {
        $sensor = $sensorRepository->find($id);
        if ($sensor) {
            $em->remove($sensor);
            $em->flush();
        }
        return $sensor;
    }



}

