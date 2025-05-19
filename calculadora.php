<?php

// Solicita o primeiro número
$num1 = readline("Digite o primeiro número: ");

// Solicita o operador
$operador = readline("Digite a operação (+, -, *, /): ");

// Solicita o segundo número
$num2 = readline("Digite o segundo número: ");

// Converte os valores para número (float)
$num1 = (float)$num1;
$num2 = (float)$num2;

switch ($operador) {
    case '+':
        $resultado = $num1 + $num2;
        break;
    case '-':
        $resultado = $num1 - $num2;
        break;
    case '*':
        $resultado = $num1 * $num2;
        break;
    case '/':
        if ($num2 != 0) {
            $resultado = $num1 / $num2;
        } else {
            echo "Erro: divisão por zero não permitida.\n";
            exit;
        }
        break;
    default:
        echo "Operador inválido.\n";
        exit;
}

echo "Resultado: $num1 $operador $num2 = $resultado\n";
