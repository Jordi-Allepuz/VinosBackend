<?php


namespace App\Controller\Api;

use App\Repository\SensorRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Sensor;
use App\Form\Model\SensorDto;
use App\Form\Type\SensorFormType;
use App\Service\SensorService;
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


    private $sensorService;

    public function __construct(SensorService $sensorService)
    {
        $this->sensorService = $sensorService;
    }

    /**
    * @Rest\Get(path="/sensors")
    * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
    */
    public function getSensors()
    {
        $sensors = $this->sensorService->getAllSensors();
        return $this->json($sensors, Response::HTTP_OK, [], ['groups' => ['sensor']]);
    }


    /**
    * @Rest\Get(path="/sensors/{id}", requirements={"id"="\d+"}) 
    * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
    */
    public function getSensorById(int $id)
    {
        $sensor = $this->sensorService->getSensorById($id);

        if (!$sensor) {
            throw $this->createNotFoundException('Sensor not found');
        }
    
        return $this->json($sensor, Response::HTTP_OK, [], ['groups' => ['sensor']]);
    }


    /** 
    * @Rest\Post(path="/sensors")
    * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
    */
    public function postSensor( Request $request)
    {
        return $this->sensorService->createSensor($request);
    }


    /**
     * @Rest\Put(path="/sensors/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
     */
    public function putSensor(Request $request, int $id)
   {
        return $this->sensorService->updateSensor($request, $id);
    }


    /**
     * @Rest\Patch(path="/sensors/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
     */
    public function pathSensor (int $id, Request $request)
    {
        return $this->sensorService->patchSensor($request, $id);
    }


    /**
     * @Rest\Delete(path="/sensors/{id}" , requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"sensor"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteSensor(int $id)
    {
        return $this->sensorService->deleteSensor($id);
    }



}

