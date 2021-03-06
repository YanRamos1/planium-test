<?php
require_once 'config/Planium.php';

$planium = new Planium();
$plans = $planium->plans;

?>

<!doctype html>
<html lang="pt-BR">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!--meta favicon-->
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <title>Planium</title>
</head>
<body class="bg-dark">
<div class="container">
    <?php
    require_once __DIR__ . '/layout/header.php';
    ?>
    <!---Inicio do conteudo-->
    <main style="vertical-align: center" class="container shadow" id="main">
        <!--form to add new beneficiario on list-->
        <div class="d-flex justify-content-center">
            <h3 class="text-white">Beneficiários</h3>
        </div>
        <p class="text-white d-flex justify-content-center" id="qtd"></p>
        <form method="post" id="FormBeneficiario">
            <label class="text-white">Nome</label>
            <input type="text" id="bNome" name="nome" class="form-control" placeholder="Nome">
            <label class="text-white">Idade</label>
            <input type="text" id="bIdade" name="idade" class="form-control" placeholder="Idade">
            <label class="text-white">Plano</label>
            <select name="plano" id="bPlano" class="form-control">
                <?php
                foreach ($planium->plans as $plano) {
                    echo "<option value='" . $plano['codigo'] . "'>{$plano['nome']}</option>";
                }
                ?>
            </select>
            <div class="d-flex justify-content-start">
                <button type="submit" class="m-3 btn btn-silver justify-content-end">Adicionar</button>
                <button type="reset" id="btnReset" class="m-3 btn btn-iron justify-content-end">Limpar</button>
            </div>
        </form>


        <div class="container-fluid mt-3 ms-0">
            <div id="tblBeneficiarios">
                <table class="table rounded table-hover table-dark" style="max-height: 600px">
                    <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Plano</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="tbody" id="res">
                    </tbody>
                </table>
            </div>
        </div>
        <div id="mensagens" class="container">

        </div>
        <div class="container" id="btnJsonLink">
            <button type="button" class="mt-3 btn btn-gold">
                <a style="text-decoration: none; color: white" id="jsonlink" href="" target="_blank">Exportar para
                    JSON</a>
            </button>
        </div>
    </main>
    <!---Fim do conteudo-->


</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="js/script.js">
</script>
</body>
</html>
