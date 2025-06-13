<?php

class GlicemiaController
{
    public function index()
    {
        global $lista;

        $lista = Glicemia::all();

        require_once '../view/listar.php';
    }

    public function create()
    {
        require_once '../view/editar.php';
    }

    public function store()
    {
        $id = $_REQUEST['id'] ?? null; 
        $data = $_REQUEST['data'] ?? "";
        $valor = $_REQUEST['valor'] ?? "";
        $hora = $_REQUEST['hora'] ?? "";

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

        $glicemia = new Glicemia();
        $glicemia->id = $id;
        $glicemia->data = $data . " " . $hora . ":00";
        $glicemia->valor = $valor;
        $glicemia->save();

        // Redireciona para listagem
        $this->index();
    }

    public function edit()
    {
        $id = $_REQUEST['id'];

        global $dados;

        $dados = Glicemia::find($id);

        require_once '../view/editar.php';
    }

        public function delete()
    {
        $id = $_REQUEST['id'] ?? null;

        if ($id === null) {
            global $mensagem;
            $mensagem = "Glicemia não encontrada";
            $this->index();
            return;
        }

        Glicemia::delete($id);

        $this->index();
    }
}

