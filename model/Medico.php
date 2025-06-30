<?php

class Medico
{
    var $id;
    var $nome;
    var $crm;
    var $especialidade;
    var $telefone;
    var $email;
    var $observacao;
    var $criado_em;

    public function save()
    {
        $connection = self::getConnection();

        if ($this->id == null) {

            $statement = $connection->prepare("INSERT INTO medico (nome, crm, especialidade, telefone, email, observacao, criado_em) VALUES (:nome, :crm, :especialidade, :telefone, :email, :observacao, :criado_em)");
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':crm', $this->crm);
            $statement->bindParam(':especialidade', $this->especialidade);
            $statement->bindParam(':telefone', $this->telefone);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':observacao', $this->observacao);
            $statement->bindValue(':criado_em', date('Y-m-d H:i:s'));
            $statement->execute();

        } else {

            $statement = $connection->prepare("UPDATE medico SET nome = :nome, crm = :crm, especialidade = :especialidade, telefone = :telefone, email = :email, observacao = :observacao, criado_em = :criado_em WHERE id = :id");
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':crm', $this->crm);
            $statement->bindParam(':especialidade', $this->especialidade);
            $statement->bindParam(':telefone', $this->telefone);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':observacao', $this->observacao);
            $statement->bindParam(':id', $this->id);
            $statement->bindValue(':criado_em', $this->criado_em ?? date('Y-m-d H:i:s'));
            $statement->execute();

        }
    }

    public static function delete($id)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare("DELETE FROM medico WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

    }

    public static function all()
    {
        $connection = self::getConnection();

        $statement = $connection->prepare("SELECT * FROM medico");
        $statement->execute();

        $lista = [];

        foreach ($statement as $row) {

            $medico = new Medico(); 
            $medico->id = $row['id'];
            $medico->nome = $row['nome'];
            $medico->crm = $row['crm'];
            $medico->especialidade = $row['especialidade'];
            $medico->telefone = $row['telefone'];
            $medico->email = $row['email'];
            $medico->criado_em = $row['criado_em'] ?? date('Y-m-d H:i:s');
            $medico->observacao = $row['observacao'] ?? null;

            $lista[] = $medico;
        }

        return $lista;
    }

    public static function find($id)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare("SELECT * FROM medico WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
        

        foreach ($statement as $row) {

            $medico = new Medico(); 
            $medico->id = $row['id'];
            $medico->nome = $row['nome'];
            $medico->crm = $row['crm'];
            $medico->especialidade = $row['especialidade'];
            $medico->telefone = $row['telefone'];
            $medico->email = $row['email'];
            $medico->criado_em = $row['criado_em'] ?? date('Y-m-d H:i:s');
            $medico->observacao = $row['observacao'] ?? null;
            return $medico;
        }

        return null;
    }

    private static function getConnection()
    {
        return new PDO('mysql:host=127.0.0.1;dbname=health_care', 'alex', '@1945Lucy@');

        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    }
}
