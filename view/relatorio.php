<?php 
    //Aqui eu recebo o id da OS que eu cliquei (via url). 
    $id_os = $_GET['id'];

    use Dompdf\Dompdf;

    //Include autoloader dompdf.
    require_once '../tools/lib/dompdf/autoload.inc.php';

    //Criação de um novo PDF.
    $dompdf = new Dompdf();

    ob_start();
    require "modeloRelatorio.php";
    $dompdf->loadHtml(ob_get_clean());
    
    //Aqui eu seto o tipo de papel do pdf.
    //A5 é metade de uma papel A4.
    $dompdf->setPaper('A4');

    //Render do pdf.
    $dompdf->render();

    //Aqui eu configuro o name default para download e seto o download automático como false.
    $dompdf->stream("file.pdf", array("Attachment" => false));
?>