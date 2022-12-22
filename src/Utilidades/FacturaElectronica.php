<?php


namespace App\Utilidades;
use App\Entity\Empresa;
use App\Entity\RespuestaFacturaElectronica;
use App\Entity\Movimiento;
use Doctrine\ORM\EntityManagerInterface;
use PhpZip\ZipFile;


class FacturaElectronica
{
    private $em;
    /*
    */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function validarDatos($arrFactura) {
        if($arrFactura['dat_suscriptor']) {
            if($arrFactura['dat_nitFacturador']) {
                if($arrFactura['ad_tipoPersona']) {
                    if($arrFactura['doc_codigoDocumento'] =='NC' || ($arrFactura['res_numero'] && $arrFactura['res_prefijo'] && $arrFactura['res_fechaDesde'] && $arrFactura['res_fechaHasta'] && $arrFactura['res_desde'] && $arrFactura['res_hasta'])) {
                        if(strlen($arrFactura['ad_codigoPostal']) == 6) {
                            if($arrFactura['ad_correo']) {
                                $arrRespuesta = ['estado' => 'ok', 'mensaje' => null];
                            } else {
                                $arrRespuesta = ['estado' => 'error', 'mensaje' => 'El adquiriente debe tener un correo electronico'];
                            }

                        } else {
                            $arrRespuesta = ['estado' => 'error', 'mensaje' => 'El codigo postal del adquiriente debe tener 6 caracteres'];
                        }
                    } else {
                        $arrRespuesta = ['estado' => 'error', 'mensaje' => 'Faltan datos de la resolucion o el documento no tiene resolucion asignada'];
                    }
                } else {
                    $arrRespuesta = ['estado' => 'error', 'mensaje' => 'El adquiriente no tiene tipo de persona'];
                }
            } else {
                $arrRespuesta = ['estado' => 'error', 'mensaje' => 'Debe seleccionar en configuracion el nit del facturador'];
            }
        } else {
            $arrRespuesta = ['estado' => 'error', 'mensaje' => 'No esta especificado el suscriptor'];
        }
        return $arrRespuesta;
    }

    public function enviarSoftwareEstrategico($arrFactura){
        $em = $this->em;
        $procesoFacturaElectronica = [
            'estado' => 'NO',
            'codigoExterno' => '',
            'cue' => '',
            'cadenaCodigoQr' => ''
        ];
        if ($arrFactura['dat_tipoAmbiente'] == 1) {
            $url = "https://apps.kiai.co/api/ConValidacionPrevia/EmitirDocumento";
        } else {
            $url = "https://apps.kiai.co/api/ConValidacionPrevia/CrearSetPrueba";
        }
        $arrSoftwareEstrategico = $this->arrSoftwareEstrategico($arrFactura);
        $json = json_encode($arrSoftwareEstrategico);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );

        $resp = json_decode(curl_exec($ch), true);
        if($resp) {
            if(isset($resp['Message'])) {
                if(isset($resp['ExceptionMessage'])) {
                    $arRespuesta = new RespuestaFacturaElectronica();
                    $arRespuesta->setFecha(new \DateTime('now'));
                    $arRespuesta->setCodigoDocumento($arrFactura['doc_codigo']);
                    $arRespuesta->setErrorMessage($resp['ExceptionMessage']);
                    $em->persist($arRespuesta);
                    $em->flush();
                }
                $procesoFacturaElectronica['estado'] = 'ER';
            }

            if (isset($resp['Validaciones'])) {
                $validaciones = $resp['Validaciones'];
                if ($validaciones['Valido']) {
                    $procesoFacturaElectronica['estado'] = 'EX';
                    $procesoFacturaElectronica['codigoExterno'] = $validaciones['DoceId'];
                    $control = $resp['Control'];
                    if ($control) {
                        $procesoFacturaElectronica['cue'] = $control['CufeCude'];
                        $procesoFacturaElectronica['cadenaCodigoQr'] = $control['CadenaCodigoQr'];
                    }
                } else {
                    $procesoFacturaElectronica['estado'] = 'ER';
                    $procesoFacturaElectronica['codigoExterno'] = $validaciones['DoceId'];
                    $detalles = $validaciones['Detalle'];
                    $datos = [];
                    foreach ($detalles as $detalle) {
                        $datos[] = $detalle['Validacion'];
                    }
                    if($detalles) {
                        $codigo = substr($detalles[0]['Validacion'], 0, 9);
                        if($codigo == "Regla: 90") {
                            $cue =  $validaciones['Documento'];
                            $resp = $this->consultarDocumento($arrFactura['dat_suscriptor'], $cue);
                            if ($resp) {
                                $validaciones = $resp['Validaciones'];
                                $carga  = $resp['Carga'];
                                $procesoFacturaElectronica['estado'] = 'EX';
                                $procesoFacturaElectronica['codigoExterno'] = $carga['DoceId'];
                                $control = $resp['Control'];
                                if ($control) {
                                    $procesoFacturaElectronica['cue'] = $control['CufeCude'];
                                    $procesoFacturaElectronica['cadenaCodigoQr'] = $control['CadenaCodigoQr'];
                                }
                            }
                        }
                    }
                    $arRespuesta = new RespuestaFacturaElectronica();
                    $arRespuesta->setFecha(new \DateTime('now'));
                    $arRespuesta->setCodigoDocumento($arrFactura['doc_codigo']);
                    $arRespuesta->setErrorReason(json_encode($datos));
                    $mensaje = "";
                    if (isset($validaciones['Descripcion'])) {
                        $mensaje .= $validaciones['Descripcion'];
                    }
                    if (isset($validaciones['mensaje'])) {
                        $mensaje .= $validaciones['mensaje'];
                    }
                    $arRespuesta->setErrorMessage($mensaje);
                    $em->persist($arRespuesta);
                    $em->flush();
                }
            }
        }
        curl_close($ch);
        return $procesoFacturaElectronica;
    }

    private function arrSoftwareEstrategico($arrFactura)
    {
        $numero = $arrFactura['res_prefijo'] . $arrFactura['doc_numero'];
        $tipo = '01';
        $tipoCodigo = "05";
        if ($arrFactura['doc_tipo'] == 'NC') {
            /* Poner prefijo cuando da este error: Error al parsear xml. startIndex cannot be larger than length of string. Parameter name: startIndex */
            //$numero = "NC".$arrFactura['doc_numero'];
            $numero = $arrFactura['doc_numero'];
            $tipo = '91';
            if(!$arrFactura['ref_codigoExterno']) {
                $tipoCodigo = "22";
            }
        }
        if ($arrFactura['doc_tipo'] == 'ND') {
            /* Poner prefijo cuando da este error: Error al parsear xml. startIndex cannot be larger than length of string. Parameter name: startIndex */
            //$numero = "ND".$arrFactura['doc_numero'];
            $numero = $arrFactura['doc_numero'];
            $tipo = '92';
            if(!$arrFactura['ref_codigoExterno']) {
                $tipoCodigo = "22";
            }
        }
        $arrImpuestos = [];
        foreach ($arrFactura['doc_itemes'] as $item) {
            $arrImpuestos[] = [
                "DediBase" => $item['item_baseIva'],
                "DediValor" => $item['item_iva'],
                "DediFactor" => $item['item_porcentaje_iva'],
                "UnimCodigo" => "1",
            ];
        }
        $arrDatos = [
            "Solicitud" => [
                "Nonce" => "af4c65a3-0a18-4b09-8ca7-475c95b45894",
                "Suscriptor" => $arrFactura['dat_suscriptor']
            ],
            "FacturaVenta" => [
                "Cabecera" => [
                    "DoceManejaPeriodos" => 0,
                    "DoceConsecutivo" => $numero,
                    "DoceCantidadItems" => $arrFactura['doc_cantidad_item'],
                    "AmbdCodigo" => $arrFactura['dat_tipoAmbiente'],
                    "TipoCodigo" => $tipoCodigo,
                    "DoetCodigo" => $tipo,
                    "MoneCodigo" => "COP",
                    "RefvNumero" => $arrFactura['res_numero']
                ],
                "PagosFactura" => [
                    "ForpCodigo" => 2,
                    "DoepFechaVencimiento" => $arrFactura['doc_fecha_vence'] . 'T' . $arrFactura['doc_hora2'],
                    "Medios" => [
                        [
                            "DempCodigo" => "31",
                            "DempDescripcion" => " "
                        ]
                    ]
                ],
                "Observaciones" => [],
                "Referencias" => [],
                "AdquirienteFactura" => [
                    "DoeaEsResponsable" => 1,
                    "DoeaEsnacional" => 1,
                    "TidtCodigo" => $arrFactura['ad_tipoIdentificacion'],
                    "DoeaDocumento" => $arrFactura['ad_numeroIdentificacion'],
                    "DoeaDiv" => $arrFactura['ad_digitoVerificacion'],
                    "DoeaRazonSocial" => $arrFactura['ad_nombreCompleto'],
                    "DoeaNombreCiudad" => $arrFactura['ad_nombreCiudad'],
                    "DoeaNombreDepartamento" => $arrFactura['ad_nombreDepartamento'],
                    "DoeaPais" => "CO",
                    "DoeaDireccion" => $arrFactura['ad_direccion'],
                    "DoeaObligaciones" => "O-99",
                    "DoeaNombres" => "",
                    "DoeaApellidos" => "",
                    "DoeaOtrosNombres" => "",
                    "DoeaCorreo" => $arrFactura['ad_correo'],
                    "DoeaTelefono" => $arrFactura['ad_telefono'],
                    "TiotCodigo" => $arrFactura['ad_tipoPersona'],
                    "RegCodigo" => '0' . $arrFactura['ad_regimen'],
                    "CopcCodigo" => $arrFactura['ad_codigoPostal'],
                    "DoeaManejoAdjuntos" => 1
                ],
                "ImpuestosFactura" => [
                    [
                        "DoeiTotal" => $arrFactura['doc_iva'],
                        "DoeiEsPorcentual" => 1,
                        "ImpuCodigo" => "01",
                        "Detalle" =>  $arrImpuestos
//                            [
//                                "DediBase" => $arrFactura['doc_baseIva'],
//                                "DediValor" => $arrFactura['doc_iva'],
//                                "DediFactor" => $arrFactura['doc_porcentaje_iva'],
//                                "UnimCodigo" => "1"
//                            ]

                    ]
                ],
                "PeriodoFactura" => [
                    "DoepFechaInicial" => $arrFactura['doc_fecha'] . 'T' . $arrFactura['doc_hora2'],
                    "DoepFechaFinal" => $arrFactura['doc_fecha_vence'] . 'T' . $arrFactura['doc_hora2']
                ],
                "ResumenImpuestosFactura" => [
                    "DeriTotalIva" => $arrFactura['doc_iva'],
                    "DeriTotalConsumo" => 0,
                    "DeriTotalIca" => 0
                ],
                "TotalesFactura" => [
                    "DoetSubtotal" => $arrFactura['doc_subtotal'],
                    "DoetBase" => $arrFactura['doc_baseIva'],
                    "DoetTotalImpuestos" => $arrFactura['doc_iva'],
                    "DoetSubtotalMasImpuestos" => $arrFactura['doc_total'],
                    "DoetTotalDescuentos" => 0,
                    "DoetTotalcargos" => 0,
                    "DoetTotalAnticipos" => 0,
                    "DoetTotalDocumento" => $arrFactura['doc_total']
                ]
            ]
        ];
        foreach ($arrFactura['doc_itemes'] as $item) {
            $arrDatos['FacturaVenta']['DetalleFactura'][] =
                [
                    "DoeiItem" => $item['item_id'],
                    "DoeiCodigo" => $item['item_codigo'],
                    "DoeiDescripcion" => $item['item_nombre'],
                    "DoeiMarca" => "",
                    "DoeiModelo" => "",
                    "DoeiObservacion" => "",
                    "DoeiDatosVendedor" => "",
                    "DoeiCantidad" => $item['item_cantidad'],
                    "DoeiCantidadEmpaque" => $item['item_cantidad'],
                    "DoeiEsObsequio" => 0,
                    "DoeiPrecioUnitario" => $item['item_precio'],
                    "DoeiPrecioReferencia" => $item['item_precio'],
                    "DoeiValor" => $item['item_precio'],
                    "DoeiTotalDescuentos" => 0,
                    "DoeiTotalCargos" => 0,
                    "DoeiTotalImpuestos" => $item['item_iva'],
                    "DoeiBase" => $item['item_baseIva'],
                    "DoeiSubtotal" => $item['item_subtotal'],
                    "TicpCodigo" => "999",
                    "UnimCodigo" => "94",
                    "CtprCodigo" => "02",
                    "ImpuestosLinea" => [
                        [
                            "DoeiTotal" => $item['item_iva'],
                            "DoeiEsPorcentual" => 1,
                            "ImpuCodigo" => "01",
                            "Detalle" => [
                                [
                                    "DediBase" => $item['item_baseIva'],
                                    "DediValor" => $item['item_iva'],
                                    "DediFactor" => $item['item_porcentaje_iva'],
                                    "UnimCodigo" => "1"
                                ]
                            ]
                        ]
                    ],
                    "ImpuestosRetenidosLinea" => [],
                    "CargosDescuentosLinea" => []
                ];
        }
        if ($tipo == '91' || $tipo == '92') {
            if($arrFactura['ref_codigoExterno']) {
                $arrDatos['FacturaVenta']['DocumentoReferencia'] = [
                    "DedrDocumentoReferencia" => $arrFactura['ref_codigoExterno'],
                    "CodigoConcepto" => "2"
                ];
            } else {
                $arrDatos['FacturaVenta']['DocumentoReferencia'] = [
                    "DedrDocumentoReferencia" => null,
                    "DedrFecha"=> null,
                    "CodigoConcepto" => "4"
                ];
            }
        }
        return $arrDatos;
    }

    public function correo($codigoMovimiento, $codigoEmpresa)
    {
        $em = $this->em;
        $arrConfiguracion = $em->getRepository(Empresa::class)->facturaElectronica($codigoEmpresa);
        $arrMovimiento = $em->getRepository(Movimiento::class)->movimientoCorreoElectronica($codigoMovimiento);
        $archivoFactura = $em->getRepository(Movimiento::class)->generarFormato([
            'codigoMovimientoPk' => $arrMovimiento['codigoMovimientoPk'],
            'codigoMovimientoTipoFk' => $arrMovimiento['doc_tipo']],
            $codigoEmpresa,true);
        $arrArchivos[] = [
            'nombre' => 'factura.pdf',
            'ruta' => $archivoFactura['ruta']
        ];

        $nombreZip = "ad.zip";
        $arDocumento = $this->consultarDocumento($arrConfiguracion['suscriptor'], $arrMovimiento['cue']);
        if($arDocumento) {
            $control = $arDocumento['Control'];
            if($control['AttachedDocumentNombre']) {
                $file = fopen('/var/www/html/temporal/' . $control['AttachedDocumentNombre'], "wb");
                fwrite($file, base64_decode($control['AttachedDocument']));
                fclose($file);
                $arrNombreCompuesto = explode('.', $control['AttachedDocumentNombre']);
                $nombreZip = $arrNombreCompuesto[0] . ".zip";
                $arrArchivos[] = [
                    'nombre' => $control['AttachedDocumentNombre'],
                    'ruta' => '/var/www/html/temporal/' . $control['AttachedDocumentNombre']
                ];
            }
        }

        $zipFile = new ZipFile();
        $outputFilename = "/var/www/html/temporal/{$nombreZip}";
        try{
            foreach ($arrArchivos as $arrArchivo) {
                $zipFile->addFile($arrArchivo['ruta'], $arrArchivo['nombre'])->saveAsFile($outputFilename);
            }
        }
        catch(\PhpZip\Exception\ZipException $e){
            // handle exception
        }
        finally{
            $zipFile->close();
        }
        $b64Doc = chunk_split(base64_encode(file_get_contents($outputFilename)));
        $numero = $arrMovimiento['res_prefijo'] . $arrMovimiento['doc_numero'];
        if ($arrMovimiento['doc_tipo'] == 'NC' || $arrMovimiento['doc_tipo'] == 'ND') {
            $numero = $arrMovimiento['doc_numero'];
        }
        $asunto = $arrConfiguracion['nit'] . ";" . $arrConfiguracion['nombre'] . ";" . $numero . ";01;" . $arrConfiguracion['nombre'];
        $arrDatos = [
            'asunto' => $asunto,
            'correo' => $arrMovimiento['correoFacturaElectronica'],
            'correoCopia' => $arrConfiguracion['correoFacturaElectronica'],
            'archivos' => [['B64' => $b64Doc, 'NombreArchivo' => $nombreZip]],
            'doc_numero' => $numero,
            'doc_fecha' => $arrMovimiento['fecha']?$arrMovimiento['fecha']->format('Y-m-d'):null,
            'doc_valor' => $arrMovimiento['vrTotalNeto'],
            'doc_emisor' => $arrConfiguracion['nombre'],
            'doc_adquiriente' => $arrMovimiento['adquiriente'],
            'doc_cue' => $arrMovimiento['cue'],
            'oxi_empresa' => $arrConfiguracion['codigoEmpresaOxigeno'],
            'oxi_modelo' => "Movimiento",
            'oxi_codigo' => $codigoMovimiento,
        ];
        $datosJson = json_encode($arrDatos);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://104.248.81.122/dubnio/public/index.php/api/correo/correoFacturaElectronica');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datosJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($datosJson))
        );
        $respuesta = curl_exec($ch);
        curl_close($ch);
        $respuesta = json_decode($respuesta);
        return $respuesta;

    }

    private function consultarDocumento($suscriptor, $cue)
    {
        $em = $this->em;
        $url = "https://tufactura.co/habilitacion/api/ConValidacionPrevia/RecuperarDocumentoDian/{$suscriptor}/{$cue}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "900395252:tufactura.co@softwareestrategico.com");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: text/plain',
            )
        );

        $resp = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $resp;
    }
}