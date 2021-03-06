<?php

namespace App\Controller\Administracion\General;

use App\Entity\Empresa;
use App\Entity\Configuracion;
use App\Entity\Item;
use App\Form\Type\ItemType;
use App\General\General;
use App\Utilidades\Mensajes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends Controller
{
    /**
     * @Route("/administracion/general/item/lista", name="administracion_general_item_lista")
     */
    public function lista(Request $request)
    {

        $session = new Session();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigoItem', TextType::class, ['required' => false, 'data' => $session->get('filtroItemCodigo')])
            ->add('nombre', TextType::class, ['required' => false, 'data' => $session->get('filtroItemNombre')])
            ->add('referencia', TextType::class, ['required' => false, 'data' => $session->get('filtroItemReferencia')])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-danger']])
            ->add('btnExcel', SubmitType::class, array('label' => 'Excel'))
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroItemCodigo', $form->get('codigoItem')->getData());
                $session->set('filtroItemNombre', $form->get('nombre')->getData());
                $session->set('filtroItemReferencia', $form->get('referencia')->getData());
            }
            if ($form->get('btnEliminar')->isClicked()) {
                $arItems = $request->request->get('ChkSeleccionar');
                $this->get("UtilidadesModelo")->eliminar(Item::class, $arItems);
                return $this->redirect($this->generateUrl('administracion_general_item_lista'));
            }
            if ($form->get('btnExcel')->isClicked()) {
                General::get()->setExportar($em->createQuery($em->getRepository(Item::class)->lista($empresa))->execute(), "Items");
            }
        }
        $arItems = $paginator->paginate($em->getRepository(Item::class)->lista($empresa), $request->query->getInt('page', 1), 30);
        return $this->render('administracion/general/item/lista.html.twig', [
            'arItems' => $arItems,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administracion/general/item/nuevo/{id}", name="administracion_general_item_nuevo")
     */
    public function nuevo(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $arItem = new Item();
        if ($id != 0) {
            $arItem = $em->getRepository(Item::class)->find($id);
        }
        $form = $this->createForm(ItemType::class, $arItem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('guardar')->isClicked()) {
                /** @var $arItem Item */
                $arItem = $form->getData();
                $arItem->setCodigoEmpresaFk($this->getUser()->getCodigoEmpresaFK());
                $arItem->setPorcentajeIva($arItem->getImpuestoIvaVentaRel()->getPorcentaje());
                $em->persist($arItem);
                $em->flush();
                return $this->redirect($this->generateUrl('administracion_general_item_lista', array('id' => $arItem->getCodigoItemPk())));
            }
        }
        return $this->render('administracion/general/item/nuevo.html.twig', [
            'arItem' => $arItem,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administracion/general/item/detalle/{id}", name="administracion_general_item_detalle")
     */
    public function detalle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $arItem = $em->getRepository(Item::class)->find($id);
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirect($this->generateUrl('administracion_general_item_detalle', ['id' => $id]));
        }
        return $this->render('administracion/general/item/detalle.html.twig', [
            'form' => $form->createView(),
            'arItem' => $arItem,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @Route("/administracion/general/item/importar", name="administracion_general_item_importar")
     */
    public function importar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->getUser()->getCodigoEmpresaFk();
        $form = $this->createFormBuilder()
            ->add('flArchivo', FileType::class)
            ->add('btnImportarItems', SubmitType::class, ['label' => 'Importar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnImportarItems')->isClicked()) {
                $ruta = $em->getRepository(Empresa::class)->parametro('rutaTemporal', $empresa);
//                $ruta = "/var/www/temporal/";
                if (!$ruta) {
                    Mensajes::error('Debe de ingresar una ruta temporal en la configuracion general del sistema');
                    echo "<script language='Javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                }
                $form['flArchivo']->getData()->move($ruta, "archivo.xls");
                $rutaArchivo = $ruta . "archivo.xls";
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($rutaArchivo);
                $arrCargas = [];
                $i = 0;
                if ($reader->getSheetCount() > 1) {
                    Mensajes::error('El documento debe contener solamente una hoja');
                    echo "<script language='Javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                } else {
                    foreach ($reader->getWorksheetIterator() as $worksheet) {
                        $highestRow = $worksheet->getHighestRow();
                        for ($row = 2; $row <= $highestRow; ++$row) {
                            $cell = $worksheet->getCellByColumnAndRow(1, $row);
                            if ($cell->getValue() != '') {
                                $arrCargas [$i]['descripcion'] = $cell->getValue();
                            }
                            $cell = $worksheet->getCellByColumnAndRow(2, $row);
                            if ($cell->getValue() != '') {
                                $arrCargas [$i]['referencia'] = $cell->getValue();
                            }
                            $cell = $worksheet->getCellByColumnAndRow(3, $row);
                            if ($cell->getValue() != '') {
                                $arrCargas [$i]['porcentajeIva'] = $cell->getValue();
                            }
                            $i++;
                        }
                    }
                    //leercargas
                    foreach ($arrCargas as $arrCarga) {
                        $item = New Item();
                        $item->setDescripcion($arrCarga['descripcion']);
                        $item->setReferencia($arrCarga['referencia']);
                        $item->setCodigoEmpresaFk($empresa);
                        $item->setPorcentajeIva($arrCarga['porcentajeIva']);
                        $em->persist($item);
                    }
                    $em->flush();
                    echo "<script language='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
                }
            }
        }
        return $this->render('administracion/general/item/importarItemsArchivo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}