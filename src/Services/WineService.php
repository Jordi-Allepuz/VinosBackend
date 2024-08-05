<?php


namespace App\Service;

use App\Entity\Wine;
use App\Form\Model\WineDto;
use App\Repository\WineRepository;
use App\Form\Type\WineFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class WineService
{
    private $em;
    private $wineRepository;
    private $formFactory;
    private $serializer;


    public function __construct(EntityManagerInterface $em, WineRepository $wineRepository, FormFactoryInterface $formFactory, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->wineRepository = $wineRepository;
        $this->formFactory = $formFactory;
        $this->serializer = $serializer;
    }

    
    public function getAllWines(): array
    {
        return $this->wineRepository->findAllOrderedByName();
    }



    public function getWineById(int $id): ?Wine
    {
        return $this->wineRepository->find($id);
    }



    public function createWine(Request $request)
    {
        $wineDto = new WineDto();
        $form = $this->formFactory->create(WineFormType::class, $wineDto);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $wine = new Wine();
            $wine->setName($wineDto->name);
            $wine->setYear($wineDto->year);
            $this->em->persist($wine);
            $this->em->flush();
            return $wine;
        }
        return $form;
    }



    public function updateWine(Request $request, int $id)
    {
        $wine = $this->wineRepository->find($id);
        if (!$wine) {
            throw new \Exception('Wine not found');
        }

        $content = json_decode($request->getContent(), true);
        $wineDto = new WineDto();
        $wineDto->name = $wine->getName();
        $wineDto->year = $wine->getYear();

        $form = $this->formFactory->create(WineFormType::class, $wineDto);
        $form->submit($content, false);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            if ($wineDto->name !== null) {
                $wine->setName($wineDto->name);
            }
            if ($wineDto->year !== null) {
                $wine->setYear($wineDto->year);
            }

            $this->em->persist($wine);
            $this->em->flush();
            return $wine;
        }
        return $form;
    }


    
    public function patchWine(Request $request, int $id)
    {
        $wine = $this->wineRepository->find($id);
        if (!$wine) {
            throw new \Exception('Wine not found');
        }

        $content = json_decode($request->getContent(), true);
        $wine->patch($content);

        $this->em->persist($wine);
        $this->em->flush();
        return $wine;
    }



    public function deleteWine(int $id): ?Wine
    {
        $wine = $this->wineRepository->find($id);
        if ($wine) {
            $this->em->remove($wine);
            $this->em->flush();
        }
        return $wine;
    }
}