<?php


namespace App\Controller\Api;

use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Wine;
use App\Form\Model\WineDto;
use App\Form\Type\WineFormType;
use App\Service\WineService;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use OpenApi\Attributes as OA;

/**
 * @Rest\Route("/api")
 * @Nelmio\Areas({"internal"})
 */
class WineController extends AbstractFOSRestController
{


    private $wineService;

    public function __construct(WineService $wineService)
    {
        $this->wineService = $wineService;
    }



    /**
    * @Rest\Get(path="/wines")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWines()
    {
        $wines = $this->wineService->getAllWines();
        return $this->json($wines, Response::HTTP_OK, [], ['groups' => ['wine']]);
    }


    /**
    * @Rest\Get(path="/wines/{id}", requirements={"id"="\d+"}) 
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWineById(int $id)
    {
        $wine = $this->wineService->getWineById($id);

        if (!$wine) {
            throw $this->createNotFoundException('Wine not found');
        }
    
        return $this->json($wine, Response::HTTP_OK, [], ['groups' => ['wine']]);
    }


    /** 
    * @Rest\Post(path="/wines")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function postWine(Request $request)
    {
        return $this->wineService->createWine($request);
    }


    /**
     * @Rest\Put(path="/wines/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
     */
    public function putWine( Request $request, int $id)
   {
        return $this->wineService->updateWine($request, $id);
    }


    /**
     * @Rest\Patch(path="/wines/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
     */
    public function patchWine(int $id, Request $request)
   {
        return $this->wineService->patchWine($request, $id); 
    }


    /**
     * @Rest\Delete(path="/wines/{id}" , requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteWine(int $id)
    {
        return $this->wineService->deleteWine($id);
    }



}

