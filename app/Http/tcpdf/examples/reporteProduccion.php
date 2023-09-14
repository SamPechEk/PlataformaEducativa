<?php

header('Content-type: text/html; charset=utf-8');

ini_set("session.gc_maxlifetime","3600");
session_start();

if (!$_SESSION['LogeoValido5846RS']) {
	header ("Location: ../../../login.php");
	exit;
}

include("../../../scripts/conn.php");

$usuario = $_SESSION['Nombre_Usuario'];
$result = mysql_query("select * from usuarios_new where usuario = '$usuario'");

while ($rows = mysql_fetch_array($result))
{
	$lote_insert = $rows ['lote_insert'];
}

if ($lote_insert == 0 ) {
	header("Location: ../noaccess.php");
	exit;
}

$nolote 	= $_GET['nolote'];

//Datos del lotef
$re_lotesf = mysql_query("select tipo_lote, empresa, homog, vaciado, envasado, destino, fechasal, sobrante from lotesf where lote ='$nolote' group by 1,2,3,4,5,6,7,8");
while ($row_lotesf = mysql_fetch_array($re_lotesf))
{
	$tipo_lote = $row_lotesf ['tipo_lote'];
	$empresa = $row_lotesf ['empresa'];
	$homog = $row_lotesf ['homog'];
	$vaciado = $row_lotesf ['vaciado'];
	$envasado = $row_lotesf ['envasado'];
	$destino = $row_lotesf ['destino'];
	$fechasal = $row_lotesf ['fechasal'];
	$sobrante = $row_lotesf ['sobrante'];
}

//fecha del embarque
$fecha_embarque = "2018-01-01";

//calculamos la merma
$diferencia   = $vaciado - $envasado;
$merma 		  = $diferencia - $sobrante;

//datos de ordenProduccion
$re_op = mysql_query("select * from ordenproduccion where lote = '$nolote'");
while ($row_op = mysql_fetch_array($re_op))
{
	$tamborNuevo = $row_op['TamborNuevo'];
}

//******** tcpdf *************************
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');




// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

$html = "<h1>REPORTE DE PRODUCCION DE MIEL</h1>
<h2>".$nolote."</h2>
<table>
<tr><td>Vaciado</td><td></td><td>Fecha</td><td>".$fecha_embarque."</td></tr>
<tr><td>".$vaciado."</td><td></td><td>Tipo</td><td>".$tipo_lote."</td></tr>
<tr><td></td><td></td><td>Homogenizado</td><td>".$homog."</td></tr>
</table>
<h3>TAMBORES DE MIEL VACIADA</h3>
<table cellpadding='1' cellspacing='1' border='1' style='text-align:center;'>
<tr>
	<th>#</th>
	<th>Codigo</th>
	<th>Fecha</th>
	<th>Documento</th>
	<th>Miel</th>
	<th>FacturadoPor</th>
	<th>Productor</th>
	<th>Neto</th>
</tr>";

//VACIADO
$index = 1;
$sql = "select a.codigo as Codigo, a.fecha_compra as FechaCompra, a.documento as Documento, c.tipo as Miel,
e.nombre_completo as FacturadoPor, d.nombre_completo as Productor, a.neto as Neto
from muestras as a
left join tmiel as c on a.miel = c.idmiel
left join productores as d on a.proveedor = d.id_productor
left join productores as e on a.facturar_a = e.id_productor
where a.lotef = '$nolote'";

$re_vaciado = mysql_query($sql);
while ($row_vaciado = mysql_fetch_array($re_vaciado))
{
	$html .= "<tr>";
	$html .= "<td>".$index."</td>";
	$html .= "<td>".$row_vaciado['Codigo']."</td>";
	$html .= "<td>".$row_vaciado['FechaCompra']."</td>";
	$html .= "<td>".$row_vaciado['Documento']."</td>";
	$html .= "<td>".$row_vaciado['Miel']."</td>";
	$html .= "<td>".$row_vaciado['FacturadoPor']."</td>";
	$html .= "<td>".$row_vaciado['Productor']."</td>";
	$html .= "<td>".$row_vaciado['Neto']."</td>";
	$html .= "</tr>";
	$index += 1;
}
$html .= "</table>";

//echo $html;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();



/*
-- MIEL ENVASADA
select a.codigo as Codigo, b.tipo as Miel, a.peso as Peso, a.tara as Tara, a.neto as Neto
from muestras as a
inner join tmiel as b on a.miel = b.idmiel
where a.lote_origen = 'A-853' and proveedor = 4351;

-- MIEL RECUPERADA
select a.codigo as Codigo, b.tipo as Miel, a.peso as Peso, a.tara as Tara, a.neto as Neto
from muestras as a
inner join tmiel as b on a.miel = b.idmiel
where a.lote_origen = 'A-853' and proveedor = 4081;

*/

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');




