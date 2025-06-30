<?php

class Paciente extends Model
{
    var $id;
    var $nome;
    var $dataNascimento;
    var $telefone;
    var $email;
    var $observacao;

    public function save()
    {
        $connection = self::getConnection();

        if ($this->id == null) {

            $statement = $connection->prepare("INSERT INTO paciente (nome, dataNascimento, telefone, email, observacao) VALUES (:nome, :dataNascimento, :telefone, :email, :observacao)");
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':dataNascimento', $this->dataNascimento);
            $statement->bindParam(':telefone', $this->telefone);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':observacao', $this->observacao);
            $statement->execute();

        } else {

            $statement = $connection->prepare("UPDATE paciente SET nome = :nome, dataNascimento = :dataNascimento, telefone = :telefone, email = :email, observacao = :observacao WHERE id = :id");
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':dataNascimento', $this->dataNascimento);
            $statement->bindParam(':telefone', $this->telefone);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':observacao', $this->observacao);
            $statement->bindParam(':id', $this->id);
            $statement->execute();

        }
    }

    public static function delete($id)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare("DELETE FROM paciente WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

    }

    public static function all($nome)
    {
        $connection = self::getConnection();

        $sql = "SELECT * FROM paciente";

        if (!empty($nome)) {
            $sql = $sql . " WHERE nome LIKE :nome";
        }

        $statement = $connection->prepare($sql);

        if (!empty($nome)) {
            $nome = "%" . $nome . "%";
            $statement->bindParam(':nome', $nome);
        }

        $statement->execute();

        $lista = [];

        foreach ($statement as $row) {

            $paciente = new Paciente(); 
            $paciente->id = $row['id'];
            $paciente->nome = $row['nome'];
            $paciente->dataNascimento = $row['dataNascimento'];
            $paciente->telefone = $row['telefone'];
            $paciente->email = $row['email'];
            $paciente->observacao = $row['observacao'] ?? null;
            
            $lista[] = $paciente;
        }

        return $lista;
    }

    public static function find($id)
    {
        $connection = self::getConnection();

        $statement = $connection->prepare("SELECT * FROM paciente WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
        

        foreach ($statement as $row) {

            $paciente = new Paciente(); 
            $paciente->id = $row['id'];
            $paciente->nome = $row['nome'];
            $paciente->dataNascimento = $row['dataNascimento'];
            $paciente->telefone = $row['telefone'];
            $paciente->email = $row['email'];
            $paciente->observacao = $row['observacao'] ?? null;
            return $paciente;
        }

        return null;
    }
}
