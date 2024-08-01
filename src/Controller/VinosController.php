<?php


namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class VinosController extends AbstractController
{


    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this -> logger = $logger;
        
    }

//    /**
//      * @Route("/vinos", name="vinos")
//      * 
//      */
//     public function list()
//     {
//         $response = new Response();
//         $response->setContent('Hola mundo');
//         return $response;
//     }

     /**
     * @Route("/vinos", name="vinos")
     * 
     */
    public function list(Request $request)
    {
        $nombre = $request->get('nombre', 'Vino sin request');
        $this->logger->info('List action called');
        $response = new JsonResponse();
        $response->setData([
            'success' => 'true',
            'data' => [
                [
                    'id' => 1,
                    'nombre' => 'Vino 1',
                ],
                [
                    'id' => 2,
                    'nombre' => 'Vino 2',
                ],
                [
                    'id' => 3,
                    'nombre' => $nombre,
                ]
            ]
        ]);
        return $response;
    }



}
