<?php

require_once '../model/FormModel.php';

class GlicemiaController
{
    public function index()
    {
        global $lista;

        $lista = $_SESSION['glicemias'] ?? [];

        require_once '../view/listar.php';
    }

    public function create()
    {
        require_once '../view/editar.php';
    }

    public function edit()
    {
        $id = $_REQUEST['id'];

        global $dados;
        $dados = $_SESSION['glicemias'][$id];

        require_once '../view/editar.php';
    }

    public function store()
    {
        $id = $_REQUEST['id'] ?? count($_SESSION['glicemias']);
        $data = $_REQUEST['data'] ?? "";
        $valor = $_REQUEST['valor'] ?? "";
        $hora = $_REQUEST['hora'] ?? "";

        if (empty($data) || empty($valor) || empty($hora)) {
        
            global $mensagem;
            $mensagem = "Todos os campos são obrigatórios";
            require_once '../view/editar.php';
        
        } else {

            $glicemia = [
                "data" => $data,
                "valor" => $valor,
                "hora" => $hora
            ];

            $_SESSION['glicemias'][$id] = $glicemia;

            $this->index();
        }
    }
}
