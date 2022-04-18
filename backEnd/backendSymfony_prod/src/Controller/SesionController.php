<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\EntradaRepository;
use App\Repository\SesionRepository;
use App\Repository\UsuarioRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;
//QR 
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class SesionController extends AbstractController
{
    #[Route('/sesion', name: 'post_sesion', methods: ['POST'])]
    public function sesion(Request $request, SesionRepository $sesionRepository): JsonResponse
    {
        $dataSesion = $request->request->all();

        if ($sesionRepository->anadirSesion($dataSesion)) {
            return new JsonResponse(['status' => true, 'msg' => 'Sesion introducida!'], Response::HTTP_ACCEPTED);
        } else {
            return new JsonResponse(['status' => false, 'msg' => 'Sesion no introducida! Ya existe una sesion con esta fecha'], Response::HTTP_OK);
        }
    }

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

    #[Route('/entradas', name: 'post_entradas_usuario', methods: ['POST'])]
    public function guardarEntradas(Request $request, EntradaRepository $entradaRepository, SesionRepository $sesionRepository): JsonResponse
    {
        $dataEntradas = $request->request->all();
        if (!empty($dataEntradas) && !$dataEntradas['butacasReservadas'] == "" && !$dataEntradas['idUsuari'] == "" && !$dataEntradas['idSesion'] == "") {
            $butacasOcupadas = $sesionRepository->findBy(['id' => $dataEntradas['idSesion']])[0]->getButacasOcupadas();

            foreach (json_decode($dataEntradas['butacasReservadas']) as $butaca => $precio) {
                $butacasOcupadas .= ($butacasOcupadas == "") ? "$butaca" : ",$butaca";
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
        $butacas = array();
        $sesion = "";
        $usuario = "";

        $entradas = array_merge($entradas, [
            'pdf' => "http://cinema1back.alumnes.inspedralbes.cat/EntradasPDF/Entradas_" . $dades[0]->getUsuario()->__toString() . ".pdf",
            'qr' => "http://cinema1back.alumnes.inspedralbes.cat/QR/Entradas_" . $dades[0]->getUsuario()->__toString() . ".jpg"
        ]);
        foreach ($dades as $entrada) {
            $usuario = $entrada->getUsuario()->__toString();
            $sesion = $entrada->getSesion()->__toString();
            array_push($butacas, $entrada->getButaca() . " - " . $entrada->getPrecio() . "€");
            array_push($entradas['entradas'], [
                'idUsuario' => $entrada->getUsuario()->__toString(),
                'idSesion' => $entrada->getSesion()->__toString(),
                'butaca' => $entrada->getButaca(),
                'precio' => $entrada->getPrecio(),
            ]);
        }

        $this->pdf($sesion, $usuario, $butacas);

        return new JsonResponse($entradas, Response::HTTP_OK);
    }

    #[Route('/registrar', name: 'post_register', methods: ['POST'])]
    public function registrar(Request $request, UsuarioRepository $usuarioRepository): JsonResponse
    {
        $dataUsuario = $request->request->all();
        foreach ($dataUsuario as $usuario => $data) {
            $$usuario = htmlspecialchars(trim($data));
        }

        if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
            return new JsonResponse(['status' => false, 'msg' => 'Faltan campos por rellenar!'], Response::HTTP_OK);
        } else {
            $check = $this->comprovarData(0, $email, $password, $nombre, $apellidos);
            if (empty($check)) {
                if (empty($usuarioRepository->getUsuario($email))) {

                    $usuario = new Usuario();
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setEmail($email);
                    $usuario->setPassword(password_hash($password, PASSWORD_DEFAULT));
                    $usuarioRepository->add($usuario);
                    $usuario = $usuarioRepository->findBy(['email' => $email])[0];

                    // OK
                    return new JsonResponse(['status' => true, 'idUsuario' => $usuario->getId(), 'msg' => 'Usuario registrado! Ahora puedes comprar tus entradas haciendo click al boton de comprar!!'], Response::HTTP_ACCEPTED);
                } else {
                    // ERROR
                    return new JsonResponse(['status' => false, 'msg' => 'Este correo ya esta asociado a una cuenta... prueba con otro!'], Response::HTTP_OK);
                }
            } else {
                return new JsonResponse(['status' => false, 'chk' => true, 'msg' => $check], Response::HTTP_OK);
            }
        }
    }

    #[Route('/loginComprarEntradas', name: 'post_login_comprarEntradas', methods: ['POST'])]
    public function loginComprarEntradas(Request $request, UsuarioRepository $usuarioRepository, EntradaRepository $entradaRepository): JsonResponse
    {
        $dataPOSTUsuario = $request->request->all();
        foreach ($dataPOSTUsuario as $usuario => $data) {
            $$usuario = htmlspecialchars(trim($data));
        }

        if (!empty($email) || !empty($password)) {
            $check = $this->comprovarData(1, $email, $password);
            if (empty($check)) {
                $resultado = $usuarioRepository->getUsuario($email);
                if (empty($resultado)) {
                    // ERROR 1
                    return new JsonResponse(['status' => false, 'msg' => 'No existe un usuario con este correo y contraseña...'], Response::HTTP_OK);
                } else {
                    if ($resultado[0]->getEmail() == $email && password_verify($password, $resultado[0]->getPassword())) {
                        if (empty($entradaRepository->usuarioTieneEntradas($resultado[0]->getId()))) {
                            // OK
                            return new JsonResponse(['status' => true, 'idUsuario' => $resultado[0]->getId(), 'msg' => 'Usuario validado, ahora puedes comprar tus entradas haciendo click al boton de comprar!'], Response::HTTP_ACCEPTED);
                        } else {
                            return new JsonResponse(['status' => false, 'idUsuario' => $resultado[0]->getId(), 'msg' => 'No puedes comprar entradas porque ya tienes unas para alguna proxima sesion. Para saber cuales son, accede al apartado consultar entradas'], Response::HTTP_OK);
                        }
                    } else {
                        // ERROR
                        return new JsonResponse(['status' => false, 'msg' => 'Contraseña o correo incorrectos...'], Response::HTTP_OK);
                    }
                }
            } else {
                return new JsonResponse(['status' => false, 'chk' => true, 'msg' => $check], Response::HTTP_OK);
            }
        } else {
            // ERROR
            return new JsonResponse(['status' => false, 'msg' => 'Faltan campos por rellenar!'], Response::HTTP_OK);
        }
    }

    #[Route('/loginAdmin', name: 'post_login_admin', methods: ['POST'])]
    public function loginAdmin(Request $request, UsuarioRepository $usuarioRepository): JsonResponse
    {
        $dataPOSTUsuario = $request->request->all();
        foreach ($dataPOSTUsuario as $usuario => $data) {
            $$usuario = htmlspecialchars(trim($data));
        }

        if (!empty($email) || !empty($password)) {
            $check = $this->comprovarData(2, $email, $password);
            if (empty($check)) {
                $resultado = $usuarioRepository->getUsuario('ausias@ausias.com');
                if ($resultado[0]->getEmail() == $email && password_verify($password, $resultado[0]->getPassword())) {
                    return new JsonResponse(['status' => true, 'msg' => '¡Hola administrador!'], Response::HTTP_OK);
                } else {
                    return new JsonResponse(['status' => false, 'msg' => 'Error! Correo o contraseña incorrectos'], Response::HTTP_OK);
                }
            } else {
                return new JsonResponse(['status' => false, 'msg' => $check], Response::HTTP_OK);
            }
        } else {
            return new JsonResponse(['status' => false, 'msg' => 'Faltan campos por rellenar!'], Response::HTTP_OK);
        }
    }


    #[Route('/loginConsultar', name: 'post_login_consultar', methods: ['POST'])]
    public function loginConsultar(Request $request, EntradaRepository $entradaRepository, UsuarioRepository $usuarioRepository): JsonResponse
    {
        $dataPOSTUsuario = $request->request->all();
        foreach ($dataPOSTUsuario as $usuario => $data) {
            $$usuario = htmlspecialchars(trim($data));
        }

        if (!empty($email) || !empty($password)) {
            $check = $this->comprovarData(2, $email, $password);
            if (empty($check)) {
                $resultado = $usuarioRepository->getUsuario($email);
                if (empty($resultado)) {
                    return new JsonResponse(['status' => false, 'msg' => 'Error! Este correo no esta registrado'], Response::HTTP_OK);
                } else {
                    $entradas = $entradaRepository->buscarEntradas($resultado[0]->getId());
                    if (empty($entradas)) {
                        return new JsonResponse(['status' => true, 'msg' => 'Nunca has comprado una entrada'], Response::HTTP_OK);
                    } else {
                        $r = array('entradas' => [], 'sesion' => []);
                        foreach ($entradas as $entrada) {
                            array_push($r['entradas'], [
                                'butaca' => $entrada['butaca'],
                                'precio' => $entrada['precio'],
                            ]);
                        }

                        array_push($r['sesion'], [
                            'fecha' => $entrada['fecha'],
                            'hora' => $entrada['hora'],
                            'nombre_peli' => $entrada['nombre_peli'],
                            'ano_peli' => $entrada['ano_peli'],
                            'img_peli' => $entrada['img_peli']
                        ]);

                        return new JsonResponse(['status' => true, 'msg' => $r], Response::HTTP_OK);
                    }
                }
            } else {
                return new JsonResponse(['status' => false, 'msg' => $check], Response::HTTP_OK);
            }
        } else {
            return new JsonResponse(['status' => false, 'msg' => 'Faltan campos por rellenar!'], Response::HTTP_OK);
        }
    }







    public function comprovarData($loginORsign, $email, $password, $nombre = "", $apellidos = "")
    {
        $errores = [];
        preg_match_all('/^[\w\.]+@([\w]+\.)+[\w]{2,4}$/', $email) ? null : array_push($errores, ['Email mal']);
        if ($loginORsign != 2) {
            preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password) ? null : array_push($errores, ['Password mal']);
        }

        if (!$loginORsign) {
            preg_match_all("/\b([a-zA-ZÀ-ÿ][-,a-z. ']+[ ]*)+/m", $nombre) ? null : array_push($errores, ['Nombre mal']);
            preg_match_all("/\b([a-zA-ZÀ-ÿ][-,a-z. ']+[ ]*)+/m", $apellidos) ? null : array_push($errores, ['Apellidos mal']);
        }

        return $errores;
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
                    'anoPeli' => $sesion->getAnoPeli(),
                    'imgPeli' => $sesion->getImgPeli(),
                ],
                'butacasOcupadas' => $sesion->getbutacasOcupadas()
            ]);
        }

        return $sesiones;
    }

    public function pdf($sesion, $usuario, $butacas)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Calibri');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf.html.twig', [
            'sesion' => $sesion,
            'usuario' => $usuario,
            'butaca' => $butacas
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();
        $pdfFilepath =  "../public/EntradasPDF/Entradas_" . $usuario . ".pdf";

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);

        $this->qr("http://cinema1back.alumnes.inspedralbes.cat/EntradasPDF/Entradas_$usuario.pdf", $usuario);
    }

    public function qr($PDFpath = "", $user)
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data("$PDFpath")
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(400)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->build();

        $result->saveToFile('../public/QR/Entradas_' . $user . '.png');
    }
}
