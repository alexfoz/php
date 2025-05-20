<?php
function formatarTelefone($telefone) {
    // Remove caracteres não numéricos
    $telefone = preg_replace('/\D/', '', $telefone);

    // Verifica se o número tem 10 ou 11 dígitos
    if (strlen($telefone) == 10) {
        // Formato: (XX) XXXX-XXXX
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    } elseif (strlen($telefone) == 11) {
        // Formato: (XX) XXXXX-XXXX
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    } else {
        return $telefone; // Retorna o número original se não tiver o formato esperado
    }
}

// Pede para o usuário digitar o telefone
echo "Digite o número de telefone (somente números): ";
$telefone = trim(fgets(STDIN));

// Formata e exibe
$formatado = formatarTelefone($telefone);
echo "Telefone formatado: $formatado\n";
