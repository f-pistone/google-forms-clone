<?php
include_once("../database/conn.php");

require "../vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$id_result = (int)$_GET['id_result'];
$name_pdf = date("YmdHis") . "_result.pdf";
$html = "";

$html .= 'Result';


$dompdf->loadHtml($html);

$dompdf->render();

$dompdf->stream($name_pdf);
