<?php
require_once 'config/Planium.php';
$planium = new Planium();
$plans = $planium->plans;
$prices = $planium->prices;
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

    <main style="vertical-align: center" class="container shadow" id="main">

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center text-white">Planos Ativos</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-deck">
                    <?php
                    foreach ($plans as $plan) {
                        ?>
                        <div class="card mt-3 mb-3">
                            <h2 style="font-family: Raleway, sans-serif;"
                                class="text-center mt-2"><?php echo $plan['nome'] ?></h2>
                            <div class="card-body">
                                <div class="d-grid">
                                    <table class="table table-responsive table-borderless border-bottom">
                                        <tr class="d-flex justify-content-around">
                                            <th style="font-weight: bold" class="text-center text-wrap">Até 17 anos</th>
                                            <th style="font-weight: bold" class="text-center text-wrap">18 à 40 anos</th>
                                            <th style="font-weight: bold" class="text-center text-wrap">Mais de 40 anos</th>
                                        </tr>
                                    </table>
                                    <?php foreach ($prices as $price) {
                                        if ($price['codigo'] == $plan['codigo']) {
                                            ?>
                                            <div class="card mt-2 mb-2">
                                                <?php
                                                if ($price['minimo_vidas'] > 1) {
                                                    echo '<h3 style="font-family: Raleway, sans-serif; font-weight: bold" class="text-center">Plano com desconto!</h3>';
                                                }
                                                ?>

                                                <div class="d-flex justify-content-around mt-3">
                                                    <p>R$ <?php echo $price['faixa1'] ?>,00</p>
                                                    <p>R$ <?php echo $price['faixa2'] ?>,00</p>
                                                    <p>R$ <?php echo $price['faixa3'] ?>,00</p>
                                                </div>
                                                <?php if ($price['minimo_vidas'] > 1) { ?>

                                                    <div class="d-flex justify-content-around mt-3">
                                                        <div>Máximo de pessoas para o plano:
                                                            <strong><?php echo $price['minimo_vidas'] ?></strong></div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
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


</body>
</html>
