<?php

namespace App\Controller;

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
    public function sesiones(SesionRepository $sesionRepository): JsonResponse
    {
        $dades = $sesionRepository->selectAllbyTodayTill7daysAfter();
        $sesiones = $this->crearArrayPelis($dades);
        return new JsonResponse($sesiones, Response::HTTP_OK);
    }

    #[Route('/sesionEspecifica', name: 'get_sesion_especifica', methods: ['GET'])]
    public function sesionEspecifica(Request $request, SesionRepository $sesionRepository): JsonResponse
    {
        $dades = $sesionRepository->selectOneSesion($request->query->get('idSesion'));
        $sesion = $this->crearArrayPelis($dades, 1);
        return new JsonResponse($sesion, Response::HTTP_OK);
    }

    public function crearArrayPelis($dades, $bool = 0)
    {
        $sesiones = array("sesiones" => []);
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

            if ($bool) {
                $sesiones['sesiones'] = array_merge($sesiones['sesiones'][0], ['butacasOcupadas' => $sesion->getbutacasOcupadas()]);
            }
        }

        return $sesiones;
    }


    #[Route('/entradas', name: 'post_entradas_usuario', methods: ['POST'])]
    public function guardarEntradas(Request $request, EntradaRepository $entradaRepository, SesionRepository $sesionRepository): JsonResponse
    {
        $dataEntradas = $request->request->all();
        if (!empty($dataEntradas) && !$dataEntradas['butacasReservadas'] == "" && !$dataEntradas['idUsuari'] == "" && !$dataEntradas['idSesion'] == "") {
            $butacasOcupadas = $sesionRepository->findBy(['id' => $dataEntradas['idSesion']])[0]->getButacasOcupadas();

            foreach (json_decode($dataEntradas['butacasReservadas']) as $butaca => $precio) {
                $butacasOcupadas .= ",$butaca";
                $sesionRepository->guardarButacasOcupadas($butacasOcupadas, $dataEntradas['idSesion']);
                $entradaRepository->guardarEntradas($dataEntradas['idUsuari'], $dataEntradas['idSesion'], $butaca, $precio);
            }
            return new JsonResponse(['status' => true, 'msg' => 'Compra realizada!'], Response::HTTP_OK);
        } else {
            return new JsonResponse(['status' => false, 'msg' => '¡Error! Compra no realizada!'], Response::HTTP_OK);
        }
    }

    #[Route('/entradasUsuario', name: 'get_entradas_usuario', methods: ['GET'])]
    public function devolverEntradas(Request $request, EntradaRepository $entradaRepository): JsonResponse
    {
        $dades = $entradaRepository->seleccionarEntradasUsuario($request->query->get('idSesion'), $request->query->get('idUsuario'));
        $entradas = array("entradas" => []); 

        foreach ($dades as $entrada) {
            array_push($entradas['entradas'], [
                'idUsuario' => $entrada->getUsuario()->__toString(),
                'idSesion' => $entrada->getSesion()->__toString(),
                'butaca' => $entrada->getButaca(),
                'precio' => $entrada->getPrecio(),
                'pdf' => "",
                'qr' => ""
            ]);
        }

        return new JsonResponse($entradas, Response::HTTP_OK);
    }
}
