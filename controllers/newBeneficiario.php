<?php
require_once '../config/Planium.php';

$beneficiarios = [];
$beneficiario = $_POST['beneficiario'];
if (isset($_POST['beneficiarios'])) {
    foreach ($_POST['beneficiarios'] as $aux) {
        $aux = json_decode($aux);
        array_push($beneficiarios, $aux);
    }
}

$planium = new Planium();
$prices = $planium->prices;
$plans = $planium->plans;

$nome = $beneficiario['nome'];
$idade = $beneficiario['idade'];
$plano = intval($beneficiario['plano']);
if ($idade < 17) {
    $faixa = 'faixa1';
} elseif ($idade >= 18 && $idade <= 40) {
    $faixa = 'faixa2';
} else {
    $faixa = 'faixa3';
}

foreach ($plans as $plan) {
    if ($plan['codigo'] == $plano) {
        $current_plan = $plan;
        foreach (array_reverse($prices) as $price) {
            if ($price['codigo'] == $current_plan['codigo']) {
                if (isset($beneficiarios)) {
                    $a = Verify($beneficiarios, $price['codigo']);
                    if ($a < $price['minimo_vidas']) {
                        $valor = $price[$faixa];
                        $b = (object)array('nome' => $nome, 'idade' => $idade, 'plano' => $current_plan, 'valor' => $valor);
                        $b = json_encode($b);
                        print_r($b);
                        break;
                    } else if ($price['minimo_vidas'] == 1) {
                        $valor = $price[$faixa];
                        $b = (object)array('nome' => $nome, 'idade' => $idade, 'plano' => $current_plan, 'valor' => $valor);
                        $b = json_encode($b);
                        print_r($b);
                        break;
                    }
                } else {
                    $valor = $price[$faixa];
                    $b = (object)array('nome' => $nome, 'idade' => $idade, 'plano' => $current_plan, 'valor' => $valor);
                    $b = json_encode($b);
                    print_r($b);
                    break;
                }
            }else{
                print_r('Não existe plano com esse código');
            }
        }
    }
    else {
        print_r('Não existe plano com esse código');
        exit();
    }
}

function Verify($beneficiarios_list, $plan_code)
{
    $count = 0;
    foreach ($beneficiarios_list as $b) {
        if (isset($b->plano)) {
            if ($b->plano->codigo == $plan_code) {
                $count++;
            }
        }
    }
    return $count;
}


?>
