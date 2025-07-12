<?php require 'vendor/autoload.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="ISO-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpósio Internacional de Arritmias – Centro Internacional de Arritmias Instituto J. Brugada</title>

    <!--CSS Styles-->
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/components/font-awesome/css/all.css">
    <link rel="stylesheet" href="inc/custom.css">
</head>
<body class="text-center">
<main class="form-signin w-100 m-auto">
    <form action="inc/generate.php">
        <?php if (isset($_GET['msg'])) : ?>
            <div class="alert alert-danger" role="alert">
                Nome não encontrado!
            </div>
        <?php endif ?>
        <h1 class="h3 mb-3 fw-normal">Certificado</h1>
        <div class="form-floating mb-3">
            <input required class="form-control" id="nome" name="nome">
            <label for="nome">Email</label>
        </div>
        <button id="openPageButton" class="w-100 btn btn-lg btn-primary" type="submit">Gerar</button>
    </form>
</main>
</body>
<footer>
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        document.getElementById("openPageButton").addEventListener("click", function() {
            var novaPagina = "https://simposiojbrugada.com.br/certificados/certificado.png";
            window.open(novaPagina, "_blank");
        });
        //$(document).ready(function (){
        //    $('button[type="submit"]').click(function () {
        //         if (!($('input[type="email"]').val() === '')) {
        //            $(this).html('<i class="fas fa-spinner"></i>').addClass('disabled');
        //        }else{
        //            window.open("https://simposiojbrugada.com.br/certificados/certificado.png", "_blank");
        //        }
        //    });
        //});
    </script>
</footer>
</html>