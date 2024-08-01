<?php


namespace App\Controller\Api;

use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Wine;



class WineController extends AbstractFOSRestController
{

    /*
    * @Rest\Get("/wines")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWines(WineRepository $wineRepository)
    {
        return $wineRepository->findAll();
    }


    /*
    * @Rest\Get("/wines/{id}")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWineById(WineRepository $wineRepository, $id)
    {
        return $wineRepository->find($id);
    }


    /*
    * @Rest\Post("/wines")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function postWine(EntityManagerInterface $em)
    {
        $wine = new Wine();
        $wine->setName('Château Margaux');
        $wine->setYear(2015);
        $em->persist($wine);
        $em->flush();
        return $wine;
    }


}

