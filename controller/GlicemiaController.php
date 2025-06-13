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

    /*public function store()
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
    }*/

   /* public function store()
{
    $id = $_REQUEST['id'] ?? null;
    $data = $_REQUEST['data'] ?? "";
    $valor = $_REQUEST['valor'] ?? "";
    $hora = $_REQUEST['hora'] ?? "";

    // Formata data se estiver no formato "ddmmyyyy"
    if (preg_match('/^\d{8}$/', $data)) {
        $data = substr($data, 0, 2) . '/' . substr($data, 2, 2) . '/' . substr($data, 4, 4);
    }

    // Formata hora se estiver no formato "hhmm"
    $hora = preg_replace('/\D/', '', $hora);
    if (preg_match('/^\d{4}$/', $hora)) {
        $hora = substr($hora, 0, 2) . ':' . substr($hora, 2, 2);
    }

    if (empty($data) || empty($valor) || empty($hora)) {
        global $mensagem;
        $mensagem = "Todos os campos são obrigatórios";
        require_once '../view/editar.php';
        return;
    }

    $glicemia = [
        "data" => $data,
        "valor" => $valor,
        "hora" => $hora
    ];

    if ($id === null || $id === "") {
        $_SESSION['glicemias'][] = $glicemia;
    } else {
        $_SESSION['glicemias'][$id] = $glicemia;
    }

    $this->index();
}*/

public function store()
{
    $id = $_REQUEST['id'] ?? null; 
    $data = $_REQUEST['data'] ?? "";
    $valor = $_REQUEST['valor'] ?? "";
    $hora = $_REQUEST['hora'] ?? "";


    // Limpa e formata a data: remove tudo que não for número
    $data = preg_replace('/\D/', '', trim($data));
    if (strlen($data) === 8) {
        $data = substr($data, 0, 2) . '/' . substr($data, 2, 2) . '/' . substr($data, 4, 4);
    }

    // Limpa e formata a hora: remove tudo que não for número
    $hora = preg_replace('/\D/', '', trim($hora)); //
    if (strlen($hora) === 4) { 
        $hora = substr($hora, 0, 2) . ':' . substr($hora, 2, 2); //
    }

    // Validação de campos obrigatórios
    if (empty($data) || empty($valor) || empty($hora)) {
        global $mensagem;
        $mensagem = "Todos os campos são obrigatórios";
        require_once '../view/editar.php';
        return;
    }

    // Monta o array da glicemia
    $glicemia = [
        "data" => $data,
        "valor" => $valor,
        "hora" => $hora
    ];

    // Salva na sessão
    if ($id === null || $id === "") {
        $_SESSION['glicemias'][] = $glicemia;
    } else {
        $_SESSION['glicemias'][$id] = $glicemia;
    }

    // Redireciona para listagem
    $this->index();
}

        public function delete()
    {
        $id = $_REQUEST['id'] ?? null;
        if ($id === null || !isset($_SESSION['glicemias'][$id])) {
            global $mensagem;
            $mensagem = "Glicemia não encontrada";
            $this->index();
            return;
        }

        unset($_SESSION['glicemias'][$id]);

        $this->index();
    }    
}

