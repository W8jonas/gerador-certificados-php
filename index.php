<?php require 'vendor/autoload.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><!-- UTF-8 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emitir certificado – Simpósio Internacional de Arritmias – Centro Internacional de Arritmias Instituto J. Brugada</title>

    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/components/font-awesome/css/all.css">
    <link rel="stylesheet" href="inc/custom.css">
</head>
<body class="text-center">
<main class="form-signin w-100 m-auto">
    <!-- usa POST para não expor o e-mail na URL -->
    <form action="inc/generate.php" method="post" novalidate>
        <?php
        if (isset($_GET['msg']) && $_GET['msg']==='notfound') {
            echo '<div class="alert alert-danger">E-mail não encontrado!</div>';
        } elseif (isset($_GET['msg']) && $_GET['msg']==='invalid') {
            echo '<div class="alert alert-warning">E-mail inválido.</div>';
        }
        ?>
        <h1 class="h3 mb-3 fw-normal">Baixar certificado</h1>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" required placeholder="nome@dominio.com">
            <label for="email">E-mail utilizado na inscrição</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">
            <span class="me-2"><i class="fas fa-file-pdf"></i></span> Baixar certificado
        </button>
    </form>
</main>

<script src="vendor/components/jquery/jquery.min.js"></script>
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- spinner simples -->
<script>
document.querySelector('form').addEventListener('submit', e => {
    const btn = e.target.querySelector('button[type="submit"]');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Gerando…';
    btn.disabled = true;
});
</script>
</body>
</html>
