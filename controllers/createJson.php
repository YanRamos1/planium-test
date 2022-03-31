<?php
require_once '../config/Planium.php';

$planium = new Planium();
$prices = $planium->prices;
$plans = $planium->plans;
$all = [];
$montante = 0;
try {
    //for to transform on json format
    if(isset($_POST['beneficiarios'])){
        $b = $_POST['beneficiarios'];
        for ($i = 0; $i < count($b); $i++) {
            $b[$i] = json_decode($b[$i]);
            $b[$i]->valor = str_replace(',', '.', $b[$i]->valor);
            $montante += $b[$i]->valor;
        }
    }
    else{
        $b = [];
    }


    //join all data
    foreach ($plans as $plan) {
        foreach ($prices as $price) {
            if ($plan['codigo'] == $price['codigo']) {
                $all[] = array_merge($plan, $price);
            }
        }
    }

    $montante = number_format($montante, 2, ',', '.');
    $amout = intval($_POST['amount']);
    $date = date('d-m-Y');
    $date = str_replace(':', '', $date);

    //join $amount with $b
    $beneficiarios = array(
        'qtdBeneficiarios' => $amout,
        'beneficiarios_list' => $b
    );


    $proposta = array(
        'data' => date('Y-m-d'),
        'valor' => $montante,
        'beneficiarios' => $beneficiarios,
        'planos' => $all,
    );


    $beneficiariosFile = fopen("../logs/" . $date . "beneficiarios.json", "w+");
    $prostaFile = fopen("../logs/" . $date . "proposta.json", "w+");
    fwrite($beneficiariosFile, json_encode($beneficiarios));
    fwrite($prostaFile, json_encode($proposta));
    fclose($beneficiariosFile);
    fclose($prostaFile);

    print_r("../logs/" . $date . "proposta.json");
} catch (Exception $e) {
    echo $e->getMessage();
}

?>

