<?php


namespace App\Controller\Api;

use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\Wine;
use App\Form\Model\WineDto;
use App\Form\Type\WineFormType;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Rest\Route("/api")
 */
class WineController extends AbstractFOSRestController
{

    /**
    * @Rest\Get(path="/wines")
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWines(WineRepository $wineRepository, Request $request, SerializerInterface $serializer)
    {
        $wines= $wineRepository->findAllOrderedByName();

        $serializerWines= $serializer->serialize($wines, 'json', ['groups' => ['wine']]);

        return new Response($serializerWines, Response::HTTP_OK, [], true);
    }


    /**
    * @Rest\Get(path="/wines/{id}", requirements={"id"="\d+"}) 
    * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
    */
    public function getWineById(WineRepository $wineRepository, int $id, SerializerInterface $serializer)
    {
        $wine = $wineRepository->find($id);

        if (!$wine) {
            throw $this->createNotFoundException('Wine not found');
        }
    
        $serializedWine = $serializer->serialize($wine, 'json', ['groups' => ['wine']]);
    
        return new Response($serializedWine, Response::HTTP_OK, [], true); 
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
        
        if(!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $wine = new Wine();
            $wine->setName($wineDto->name);
            $wine->setYear($wineDto->year);
            $em->persist($wine);
            $em->flush();
            return $wine;
        }
        return $form;
    }


    /**
     * @Rest\Put(path="/wines/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
     */
    public function putWine(EntityManagerInterface $em, WineRepository $wineRepository, Request $request, int $id)
   {
        $wine = $wineRepository->find($id);
        if (!$wine) {
            throw $this->createNotFoundException('Wine not found');
        }

        $content = json_decode($request->getContent(), true);
        $wineDto = new WineDto();

        $wineDto->name = $wine->getName();
        $wineDto->year = $wine->getYear();

        $form = $this->createForm(WineFormType::class, $wineDto);
        $form->submit($content, false);

        if(!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            
            if ($wineDto->name !== null) {
                $wine->setName($wineDto->name);
            }
            if ($wineDto->year !== null) {
                $wine->setYear($wineDto->year);
            }

            $em->persist($wine);
            $em->flush();
            return $wine;
        }
        return $form;
    }


    /**
     * @Rest\Patch(path="/wines/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
     */
    public function patchWine(int $id, Request $request, EntityManagerInterface $em, WineRepository $wineRepository)
   {

        $wine = $wineRepository->find($id);
        if (!$wine) {
            throw $this->createNotFoundException('Wine not found');
        }

        $content = json_decode($request->getContent(), true);
        $wine->patch($content);

        $em->persist($wine);
        $em->flush();
        return $wine;
        
    }


    /**
     * @Rest\Delete(path="/wines/{id}" , requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"wine"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteWine(EntityManagerInterface $em, WineRepository $wineRepository, int $id)
    {
        $wine = $wineRepository->find($id);
        if ($wine) {
            $em->remove($wine);
            $em->flush();
        }
        return $wine;
    }



}

