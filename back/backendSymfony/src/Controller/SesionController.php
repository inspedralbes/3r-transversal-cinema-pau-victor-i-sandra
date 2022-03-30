<?php

namespace App\Controller;

use App\Entity\Sesion;
use App\Form\SesionType;
use App\Repository\EntradaRepository;
use App\Repository\SesionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class SesionController extends AbstractController
{
    #[Route('/sesiones', name: 'get_sesiones', methods: ['GET'])]
    public function index(SesionRepository $sesionRepository): JsonResponse
    {
        $sesiones = array("sesiones" => []);
        $dades = $sesionRepository->findAll();

        foreach ($dades as $sesion) {
            array_push($sesiones['sesiones'], [
                'idSesion' => $sesion->getId(),
                'fecha' => $sesion->getFecha()->format('d-m-Y'),
                'hora' => $sesion->getHora()->format('H:i:s'),
                'vip' => $sesion->getVip(),
                'diaEspectador' => $sesion->getDiaEspectador(),
                'peli' => [
                    'idPeli' => $sesion->getIdPeli(),
                    'nombrePeli' => $sesion->getNombrePeli(),
                    'anoPeli' => $sesion->getAnoPeli()->format('Y'),
                    'imgPeli' => $sesion->getImgPeli(),
                ]
            ]);
        }

        return new JsonResponse($sesiones, Response::HTTP_OK);
    }

    // #[Route('/entradas', name: 'get_entrada_usuario', methods: ['GET'])]
    // public function index(EntradaRepository $entradaRepository): JsonResponse
    // {
    //     $sesiones = array("sesiones" => []);
    //     $dades = $sesionRepository->findAll();

    //     foreach ($dades as $sesion) {
    //         array_push($sesiones['sesiones'], [
    //             'idSesion' => $sesion->getId(),
    //             'fecha' => $sesion->getFecha()->format('d-m-Y'),
    //             'hora' => $sesion->getHora()->format('H:i:s'),
    //             'vip' => $sesion->getVip(),
    //             'diaEspectador' => $sesion->getDiaEspectador(),
    //             'peli' => [
    //                 'idPeli' => $sesion->getIdPeli(),
    //                 'nombrePeli' => $sesion->getNombrePeli(),
    //                 'anoPeli' => $sesion->getAnoPeli()->format('Y'),
    //                 'imgPeli' => $sesion->getImgPeli(),
    //             ]
    //         ]);
    //     }

    //     return new JsonResponse($sesiones, Response::HTTP_OK);
    // }

    
}
