<?php

// Verificador de idade para votação

// Solicita ao usuário que insira a idade
echo "Digite sua idade: ";
$idade = intval(trim(fgets(STDIN))); // Lê a entrada do usuário e converte para inteiro

// Verifica a faixa etária e exibe a mensagem correspondente
if ($idade >= 70) {
    echo "O voto é facultativo.\n";
} elseif ($idade >= 16 && $idade <= 69) {
    echo "O voto é obrigatório.\n";
} else {
    echo "Você ainda não tem idade para votar.\n";
    
}

sleep(60); // Pausa a execução por 60 segundos
?>