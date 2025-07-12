<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/** -----------------------------------------------------------------
 *  1) Valida e sanitiza a entrada
 * -----------------------------------------------------------------*/
if (empty($_POST['email'])) {
    header('Location: ../index.php?msg=invalid');
    exit;
}

$email = strtolower(trim($_POST['email']));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../index.php?msg=invalid');
    exit;
}

/** -----------------------------------------------------------------
 *  2) Procura o e-mail no CSV
 * -----------------------------------------------------------------*/
$csvPath = __DIR__ . '/../participantes.csv';
if (!file_exists($csvPath)) {
    http_response_code(500);
    exit('Arquivo de participantes não encontrado.');
}

$handle = fopen($csvPath, 'r');
if (!$handle) {
    http_response_code(500);
    exit('Não foi possível abrir a lista de participantes.');
}

$header = fgetcsv($handle); 
$nome = null;
while (($row = fgetcsv($handle)) !== false) {
    // Protege de cabeçalhos: pula linhas sem 2 colunas
    if (count($row) < 2) continue;

    // força UTF-8 caso o CSV esteja em ISO-8859-1
    $rowEmail = strtolower(trim($row[1]));  // coluna 1 = e-mail
    if ($rowEmail === $email) {
        $nome = trim($row[0]);              // coluna 0 = nome
        break;
    }
}
fclose($handle);

if (!$nome) {
    header('Location: ../index.php?msg=notfound' . '&email=' . urlencode($email) . '&nome=' . urlencode($nome));
    exit;
}

/** -----------------------------------------------------------------
 *  3) Gera o PDF com Dompdf
 * -----------------------------------------------------------------*/
$options = new Options([
    'defaultPaperSize'       => 'a4',
    'defaultPaperOrientation'=> 'landscape',
    'dpi'                    => 300,
    'isRemoteEnabled'        => true
]);
$dompdf = new Dompdf($options);

// usa caminho absoluto local para fontes (mais rápido e confiável)
$fontPath = __DIR__.'/fonts/';   // copie os .ttf para essa pasta

$html = <<<HTML
<style>
@page { margin:0; }

@font-face {
    font-family:"Segoe UI";
    src:url("{$fontPath}segoeui.ttf") format("truetype");
}
@font-face {
    font-family:"Segoe UI";
    font-weight:bold;
    src:url("{$fontPath}segoeuib.ttf") format("truetype");
}

body,html{margin:0;padding:0;font-family:"Segoe UI",sans-serif;}
.cert{
    background:url("https://simposiojbrugada.com.br/certificados/inc/images/background.png") no-repeat center/contain;
    width:100%;height:100%;
    position:relative;
}
.text{
    position:absolute;
    top:40.5%;
    left:0;right:0;
    text-align:center;
    font-size:90px;
    font-weight:bold;
    text-transform:uppercase;
}
</style>
<div class="cert">
    <div class="text">{$nome}</div>
</div>
HTML;

$dompdf->loadHtml($html);
$dompdf->render();

/** -----------------------------------------------------------------
 *  4) Entrega o PDF ao navegador
 * -----------------------------------------------------------------*/
$dompdf->stream(
    'certificado.pdf',
    ['Attachment' => false]  // abre no navegador
);
