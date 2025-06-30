<?php


class MedicoController
{
    public function index()
    {
        global $lista;

        $lista = Medico::all();

        require_once '../view/medico/listar.php';
    }

    public function create()
    {
        require_once '../view/medico/editar.php';
    }

    public function store()
    {
        $id = $_REQUEST['id'] ?? null; 
        $nome = $_REQUEST['nome'] ?? "";
        $crm = $_REQUEST['crm'] ?? "";
        $especialidade = $_REQUEST['especialidade'] ?? "";
        $telefone = $_REQUEST['telefone'] ?? "";
        $email = $_REQUEST['email'] ?? "";
        $observacao = $_REQUEST['observacao'] ?? "";
        $criado_em = $_REQUEST['criado_em'] ?? date('Y-m-d H:i:s');

        // Validação de campos obrigatórios
        if (empty($nome) || empty($crm) || empty($especialidade) || empty($telefone) || empty($email) || empty($criado_em)) {
            global $mensagem;
            $mensagem = "Todos os campos são obrigatórios";

            global $dados;
            $medico = new Medico();
            $medico->id = $id;
            $medico->nome = $nome;
            $medico->crm = $crm;
            $medico->especialidade = $especialidade;
            $medico->telefone = $telefone;
            $medico->email = $email;
            $medico->observacao = $observacao;
            $medico->criado_em = $criado_em;
            $dados = $medico;

            require_once '../view/medico/editar.php';
            return;
        }

        $medico = new Medico();
        $medico->id = $id;
        $medico->nome = $nome;
        $medico->crm = $crm;
        $medico->especialidade = $especialidade;
        $medico->telefone = $telefone;
        $medico->email = $email;
        $medico->observacao = $observacao;
        $medico->criado_em = $criado_em;

        $medico->save();

        // Redireciona para listagem
        $this->index();
    }

    public function edit()
    {
        $id = $_REQUEST['id'];

        global $dados;

        $dados = Medico::find($id);

        require_once '../view/medico/editar.php';
    }

        public function delete()
    {
        $id = $_REQUEST['id'] ?? null;

        if ($id === null) {
            global $mensagem;
            $mensagem = "Médico não encontrado";
            $this->index();
            return;
        }

        Medico::delete($id);

        $this->index();
    }
}

