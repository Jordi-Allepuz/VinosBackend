<?php


namespace App\Controller\Api;

use App\Repository\MeasuringRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Measuring;
use App\Form\Model\MeasuringDto;
use App\Form\Type\MeasuringFormType;
use App\Service\MeasuringService;
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


    private $measuringService;

    public function __construct(MeasuringService $measuringService)
    {
        $this->measuringService = $measuringService;
    }


    /**
    * @Rest\Get(path="/measurings")
    * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
    */
    public function getMeasurings()
    {
        $measurings = $this->measuringService->getAllMeasurings();
        return $this->json($measurings, Response::HTTP_OK, [], ['groups' => ['measuring']]);
    }


    /**
    * @Rest\Get(path="/measurings/{id}", requirements={"id"="\d+"}) 
    * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
    */
    public function getMeasuringById(int $id)
    {
        $measuring = $this->measuringService->getMeasuringById($id);

        if (!$measuring) {
            throw $this->createNotFoundException('Measuring not found');
        }
    
        return $this->json($measuring, Response::HTTP_OK, [], ['groups' => ['measuring']]);
    }


    /** 
    * @Rest\Post(path="/measurings")
    * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
    */
    public function postmeasuring(Request $request)
    {
        return $this->measuringService->createMeasuring($request);
    }


    /**
     * @Rest\Put(path="/measurings/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
     */
    public function putMeasuring(Request $request, int $id)
   {
        return $this->measuringService->updateMeasuring($request, $id);
    }


    /**
     * @Rest\Patch(path="/measurings/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
     */
    public function patchMeasuring(Request $request, int $id)
    {
        return $this->measuringService->patchMeasuring($request, $id);
    }



    /**
     * @Rest\Delete(path="/measurings/{id}" , requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"measuring"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteMeasuring(int $id)
    {
        return $this->measuringService->deleteMeasuring($id);
    }



}

