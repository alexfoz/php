<?php


class PacienteController
{
    public function index()
    {
        global $lista, $nome;

        $nome = $_REQUEST['nome'] ?? "";

        $lista = Paciente::all($nome);

        require_once '../view/paciente/listar.php';
    }

    public function create()
    {
        require_once '../view/paciente/editar.php';
    }

    public function store()
    {
        $id = $_REQUEST['id'] ?? null; 
        $nome = $_REQUEST['nome'] ?? "";
        $dataNascimento = $_REQUEST['dataNascimento'] ?? "";
        $telefone = $_REQUEST['telefone'] ?? "";
        $email = $_REQUEST['email'] ?? "";
        $observacao = $_REQUEST['observacao'] ?? "";

        // Validação de campos obrigatórios
        if (empty($nome) || empty($dataNascimento) || empty($telefone) || empty($email)) {
            global $mensagem;
            $mensagem = "Todos os campos são obrigatórios";

            global $dados;
            $paciente = new Paciente();
            $paciente->id = $id;
            $paciente->nome = $nome;
            $paciente->dataNascimento = $dataNascimento;
            $paciente->telefone = $telefone;
            $paciente->email = $email;
            $paciente->observacao = $observacao;
            $dados = $paciente;
            
            require_once '../view/paciente/editar.php';
            return;
        }

        $paciente = new Paciente();
        $paciente->id = $id;
        $paciente->nome = $nome;
        $paciente->dataNascimento = $dataNascimento;
        $paciente->telefone = $telefone;
        $paciente->email = $email;
        $paciente->observacao = $observacao;
       
        $paciente->save();

        // Redireciona para listagem
        $this->index();
    }

    public function edit()
    {
        $id = $_REQUEST['id'];

        global $dados;

        $dados = Paciente::find($id);

        require_once '../view/paciente/editar.php';
    }

        public function delete()
    {
        $id = $_REQUEST['id'] ?? null;

        if ($id === null) {
            global $mensagem;
            $mensagem = "Paciente não encontrado";
            $this->index();
            return;
        }

        Paciente::delete($id);

        $this->index();
    }
}

