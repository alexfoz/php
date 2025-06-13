<?php
class FormModel {
    public function processForm($data, $valor, $hora) {
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $data)) {
            return "Data inválida. Use o formato dd/mm/aaaa.";
        }

        if (!is_numeric($valor) || $valor < 0) {
            return "Valor inválido. Deve ser um número positivo.";
        }

        if (!preg_match("/^\d{2}:\d{2}$/", $hora)) {
            return "Hora inválida. Use o formato hh:mm.";
        }

        if (!isset($_SESSION['dados']) || !is_array($_SESSION['dados'])) {
            $_SESSION['dados'] = [];
        }

        $_SESSION['dados'][] = [
            'data' => $data,
            'valor' => $valor,
            'hora' => $hora
        ];

        return "Cadastrado com sucesso!";
    }
}
?>