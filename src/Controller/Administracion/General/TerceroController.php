<?php

namespace App\Controller\Administracion\General;

use App\Entity\Movimiento;
use App\Entity\Tercero;
use App\Form\Type\TerceroType;
use App\Utilidades\Mensajes;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class TerceroController extends Controller
{
    /**
     * @Route("/administracion/general/tercero/lista", name="administracion_general_tercero_lista")
     */
    public function lista(Request $request)
    {
        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoTercero', TextType::class, ['required' => false, 'data' => $session->get('filtroTerceroCodigo')])
            ->add('nombreCorto', TextType::class, ['required' => false, 'data' => $session->get('filtroTerceroNombreCorto')])
            ->add('cliente', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTerceroCliente'), 'required' => false])
            ->add('proveedor', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroTerceroProveedor'), 'required' => false])
            ->add('btnExcel', SubmitType::class, ['label' => 'Excel', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroTerceroCodigo', $form->get('codigoTercero')->getData());
                $session->set('filtroTerceroNombreCorto', $form->get('nombreCorto')->getData());
                $session->set('filtroTerceroCliente', $form->get('cliente')->getData());
                $session->set('filtroTerceroProveedor', $form->get('proveedor')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(Tercero::class, $arItems);
                return $this->redirect($this->generateUrl('tercero_lista'));
            }
            if ($form->get('btnExcel')->isClicked()) {
                $arTerceros = $em->getRepository(Tercero::class)->lista($empresa)->getQuery()->getResult();
                $this->exportarExcel($arTerceros);
            }
        }
        $arTerceros = $paginator->paginate($em->getRepository(Tercero::class)->lista($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('administracion/general/tercero/lista.html.twig', [
            'arTerceros' => $arTerceros,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administracion/general/tercero/nuevo/{id}", name="administracion_general_tercero_nuevo")
     */
    public function nuevo(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTercero = new Tercero();
        if ($id != 0) {
            $arTercero = $em->getRepository(Tercero::class)->find($id);
        }
        $form = $this->createForm(TerceroType::class, $arTercero);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('guardar')->isClicked()) {
                if ($arTercero->getCliente() == true || $arTercero->getProveedor() == true) {

                    $arTercero = $form->getData();
                    $arTercero->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFk());
                    $em->persist($arTercero);
                    $em->flush();
                    return $this->redirect($this->generateUrl('administracion_general_tercero_lista', array('id' => $arTercero->getCodigoTerceroPk())));
                } else {
                    $respuesta = "Debe seleccionar un campo: cliente, proveedor o ambos";
                    Mensajes::error($respuesta);
                }
            }
        }
        return $this->render('administracion/general/tercero/nuevo.html.twig', [
            'arTercero' => $arTercero,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administracion/general/tercero/detalle/{id}", name="administracion_general_tercero_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arTercero = $em->getRepository(Tercero::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

        }
        return $this->render('administracion/general/tercero/detalle.html.twig', [
            'form' => $form->createView(),
            'arTercero' => $arTercero,
        ]);
    }

    public function exportarExcel($arTerceros)
    {
        ob_clean();
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $libro = new Spreadsheet();
        $hoja = $libro->getActiveSheet();
        $hoja->setTitle('movimiento');
        $j = 0;
        $arrColumnas = ['ID', 'TIPO', 'IDENTIFICACIÓN', 'DIGITO', 'NOMBRE CORTO', 'CIUDAD', 'DIRECCIÓN', 'TELEFONO', 'CELULAR','EMAIL', 'CLIENTE', 'PROVEEDOR'];
        for ($i = 'A'; $j <= sizeof($arrColumnas) - 1; $i++) {
            $hoja->getColumnDimension($i)->setAutoSize(true);
            $hoja->getStyle(1)->getFont()->setName('Arial')->setSize(8);
            $hoja->getStyle(1)->getFont()->setBold(true);
            $hoja->setCellValue($i . '1', strtoupper($arrColumnas[$j]));
            $j++;
        }
        $j = 2;
        foreach ($arTerceros as $arTercero) {
            $hoja->getStyle($j)->getFont()->setName('Arial')->setSize(8);
            $hoja->setCellValue('A' . $j, $arTercero['codigoTerceroPk']);
            $hoja->setCellValue('B' . $j, $arTercero['codigoIdentificacionFk']);
            $hoja->setCellValue('C' . $j, $arTercero['numeroIdentificacion']);
            $hoja->setCellValue('D' . $j, $arTercero['digitoVerificacion']);
            $hoja->setCellValue('E' . $j, $arTercero['nombreCorto']);
            $hoja->setCellValue('F' . $j, $arTercero['ciudad']);
            $hoja->setCellValue('G' . $j, $arTercero['direccion']);
            $hoja->setCellValue('H' . $j, $arTercero['telefono']);
            $hoja->setCellValue('I' . $j, $arTercero['celular']);
            $hoja->setCellValue('J' . $j, $arTercero['email']);
            $hoja->setCellValue('K' . $j, $arTercero['cliente'] ? "SI" :  "NO");
            $hoja->setCellValue('L' . $j, $arTercero['proveedor'] ? "SI" : "NO");
            $j++;
        }

        $libro->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="terceros.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = new Xlsx($libro);
        $writer->save('php://output');
        exit;

    }
}