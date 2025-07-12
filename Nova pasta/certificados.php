<?php
include 'class/classConexao.php';
$link = OpenCon();

if ($_REQUEST['nome'] != '') {
    $sql = "SELECT * FROM certificado_2024 WHERE nome = '" . $_REQUEST['nome'] . "'";
    $results = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($results);
    if ($row['nome'] == NULL) {
        header('Location: https://simposiojbrugada.com.br/certificados/index.php?erro=nome');
        die();
    }
    if ($row['funcao'] != NULL) {
        $funcao = $row['funcao'];
    }
} else if ($_REQUEST['cpf'] != '') {
    $cpf = preg_replace('#[^0-9]#', '', $_REQUEST['cpf']);
    $sql = "SELECT * FROM certificado_2024 WHERE cpf = '" . $cpf . "'";
    $results = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($results);
    if ($row['nome'] == NULL) {
        header('Location: https://simposiojbrugada.com.br/certificados/index.php?erro=cpf');
        die();
    }
    if ($row['funcao'] != NULL) {
        $funcao = $row['funcao'];
    }
}


$path = "certificados/";
$diretorio = dir($path);

//echo "Lista de Arquivos do diretório '<strong>" . $path . "</strong>':<br />";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simpósio Internacional de Arritmias - Centro Internacional de Arritmias Instituto J. Brugada</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,400,200,600' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            background-image: url(//simposiojbrugada.com.br/wp-content/uploads/2018/08/fundo-5.jpg);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            background-size: cover;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -ms-background-size: cover;
            -o-background-size: cover;
            color: #fff;
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .table {
            background: #fff;
        }

        @media(min-width:1140px) {
            .largura {
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <div class="container largura" style="margin:auto;">
        <img style="margin-bottom:20px;" class="mx-auto d-block" src="https://simposiojbrugada.com.br/wp-content/uploads/2018/08/simposio-1.png" alt="" width="246" height="140">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Atividade</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($arquivo = $diretorio->read()) {
                    if (mb_strpos($arquivo, $row['nome']) !== false) {
                        $url = $arquivo;
                        $arquivo = explode("-", $arquivo);
                        $arquivo = explode(".", $arquivo[1]);
                        $html = '<tr><th scope="row">' . $arquivo[0] . '</th><td><a class="btn btn-primary btn-sm" role="button" aria-pressed="true" download href="' . $path . $url . '">Download</a></td>';
                        echo $html;
                    }
                }
                $diretorio->close();
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap Core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript">
        /* Verificar o preenchimento dos campos */
        $(function() {
            $(document).on('click', '.btn-primary', function() {
                var cpf = $('#inputCpf').val();
                var email = $('#inputEmail').val();
                if (cpf == '' && email == '') {
                    alert("Você precisa informar algum dos dados, CPF ou EMAIL!");
                    return false;
                }
            });
        });
    </script>

</body>

</html>