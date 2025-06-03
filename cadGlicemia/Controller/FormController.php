<?php
require_once 'models/FormModel.php';

class FormController {
    public function handleRequest() {
        $data = $_REQUEST['data'] ?? "";
        $valor = $_REQUEST['valor'] ?? "";
        $hora = $_REQUEST['hora'] ?? "";
        $mensagem = "";

        if (!empty($_REQUEST['limpar'])) {
            unset($_SESSION['dados']);
            $mensagem = "Dados limpos.";
        }

        if (!empty($data) && !empty($valor) && !empty($hora)) {
            $model = new FormModel();
            $mensagem = $model->processForm($data, $valor, $hora);
        }

        $dados = $_SESSION['dados'] ?? [];
        require 'views/formView.php';
    }
}
?>