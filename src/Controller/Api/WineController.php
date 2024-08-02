<?php


namespace App\Controller\Api;

use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Wine;
use App\Form\Model\WineDto;
use App\Form\Type\WineFormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api")
 */
class WineController extends AbstractFOSRestController
{

    /**
    * @Rest\Get(path="/wines")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWines(WineRepository $wineRepository)
    {
        return $wineRepository->findAll();
    }


    /**
    * @Rest\Get(path="/wines/{id}")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWineById(WineRepository $wineRepository, $id)
    {
        return $wineRepository->find($id);
    }


    /** 
    * @Rest\Post(path="/wines")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function postWine(EntityManagerInterface $em, Request $request)
    {
        $wineDto = new WineDto();
        $form = $this->createForm(WineFormType::class, $wineDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $wine = new Wine();
            $wine->setName($wineDto->name);
            $wine->setYear($wineDto->year);
            $em->persist($wine);
            $em->flush();
            return $wine;
        }
        return $form;
    }


}

