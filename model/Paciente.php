<?php

class Paciente extends Model
{
    var $id;
    var $nome;
    var $dataNascimento;
    var $telefone;
    var $email;
    var $medico_id; // Renomeado para evitar conflito com a coluna 'medico' que é um texto
    var $medico;
    var $observacao;

    public function save()
    {
        $connection = self::getConnection();

        if ($this->id == null) {

            $statement = $connection->prepare("INSERT INTO paciente (nome, dataNascimento, telefone, email, medico_id, observacao) VALUES (:nome, :dataNascimento, :telefone, :email, :medico_id, :observacao)");
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':dataNascimento', $this->dataNascimento);
            $statement->bindParam(':telefone', $this->telefone);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':medico_id', $this->medico_id);
            $statement->bindParam(':observacao', $this->observacao);
            $statement->execute();

        } else {

            $statement = $connection->prepare("UPDATE paciente SET nome = :nome, dataNascimento = :dataNascimento, telefone = :telefone, email = :email, medico_id = :medico_id, observacao = :observacao WHERE id = :id");
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':dataNascimento', $this->dataNascimento);
            $statement->bindParam(':telefone', $this->telefone);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':medico_id', $this->medico_id);
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

       $sql = "SELECT p.*, m.nome AS medico 
                FROM paciente p 
                LEFT JOIN medico m ON p.medico_id = m.id";

        if (!empty($nome)) {
            $sql = $sql . " WHERE p.nome LIKE :nome";
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
            $paciente->medico_id = $row['medico_id'];
            $paciente->medico = $row['medico'] ?? null;
            $paciente->observacao = $row['observacao'] ?? null;
            
            $lista[] = $paciente;
        }

        return $lista;
    }

    public static function find($id)
    {
        $connection = self::getConnection();

         $sql = "SELECT p.*, m.nome AS medico 
                FROM paciente p 
                LEFT JOIN medico m ON p.medico_id = m.id 
                WHERE p.id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();
        

        foreach ($statement as $row) {

            $paciente = new Paciente(); 
            $paciente->id = $row['id'];
            $paciente->nome = $row['nome'];
            $paciente->dataNascimento = $row['dataNascimento'];
            $paciente->telefone = $row['telefone'];
            $paciente->email = $row['email'];
            $paciente->medico_id = $row['medico_id'] ?? null;
            $paciente->medico = $row['medico'] ?? null;
            $paciente->observacao = $row['observacao'] ?? null;
            return $paciente;
        }

        return null;
    }
}
