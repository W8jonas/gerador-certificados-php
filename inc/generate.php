<?php
isset($_GET['email']) ? $email = $_GET['email'] : header('Location: /certificados');
if ($_GET['email'] == "") { header('Location: /certificados'); }
$data = array_map('str_getcsv', file('../participantes.csv'));
if (!array_search($email, array_column($data, 1))) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '?msg=error');
}
$participantId = array_search($email, array_column($data, 1));

require '../vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// Set Dompdf Options
$options = new Options();
$options->set('defaultPaperSize', 'a4');
$options->set('defaultPaperOrientation', 'landscape');
$options->set('isRemoteEnabled', 'true');
//$options->set('defaultFont', 'Montserrat');
$options->set('dpi', 300);

$html = '

<style>
    * {
        font-family: "Segoe UI",serif;
    }

    @page {
        margin: 0;
    }

    @font-face {
        font-family: "Segoe UI";
        font-style: normal;
        font-weight: 400;
        src: url("https://simposiojbrugada.com.br/certificados/inc/fonts/segoeui.ttf") format("truetype");
    }
    
        @font-face {
        font-family: "Segoe UI";
        font-style: normal;
        font-weight: bold;
        src: url("https://simposiojbrugada.com.br/certificados/inc/fonts/segoeuib.ttf") format("truetype");
    }
    
    img {
        width: 100%;
    }

    .cert {
        background-image: url("https://simposiojbrugada.com.br/certificados/inc/images/background.png");
        background-size: contain;
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
    }
    
    .text {
        position:absolute;
        top: 40.5%;
        left: 0;
        right: 0;
        margin: auto;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 90px;
        color: #000;
    }
</style>
<div class="cert">
    <p class="text">'. $data[$participantId][0] .'</p>
</div>';

// instantiate and use the dompdf class
$dompdf = new Dompdf($options);

// Load the default html file
$dompdf->loadHtml($html);

// Render the HTML as PDF
$dompdf->render();

// Save the file in server
$file = $dompdf->output();
//file_put_contents('docs/' . slugify($data[0]) . '.pdf', $file);

// Output the generated PDF to Browser
$options = ['compress' => '1', 'Attachment' => '0'];
$dompdf->stream('certificado.pdf', $options);
