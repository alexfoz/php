<?php

class Glicemia extends Model
{
    var $id;
    var $data;
    var $valor;
    var $observacao;
    var $paciente_id;

    public function save()
    {
        $connection = self::getConnection();

        if ($this->id == null) {
            $statement = $connection->prepare("INSERT INTO glicemia (data_hora, valor, observacao, paciente_id) VALUES (:data, :valor, :observacao, :paciente_id)");
            $statement->bindParam(':data', $this->data);
            $statement->bindParam(':valor', $this->valor);
            $statement->bindParam(':observacao', $this->observacao);
            $statement->bindParam(':paciente_id', $this->paciente_id);
            $statement->execute();
        } else {
            $statement = $connection->prepare("UPDATE glicemia SET data_hora = :data, valor = :valor, observacao = :observacao, paciente_id = :paciente_id WHERE id = :id");
            $statement->bindParam(':data', $this->data);
            $statement->bindParam(':valor', $this->valor);
            $statement->bindParam(':observacao', $this->observacao);
            $statement->bindParam(':paciente_id', $this->paciente_id);
            $statement->bindParam(':id', $this->id);
            $statement->execute();
        }
    }

    public static function delete($id)
    {
        $connection = self::getConnection();
        $statement = $connection->prepare("DELETE FROM glicemia WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public static function all()
    {
        $connection = self::getConnection();
        $statement = $connection->prepare("SELECT * FROM glicemia");
        $statement->execute();

        $lista = [];

        foreach ($statement as $row) {
            $glicemia = new Glicemia(); 
            $glicemia->id = $row['id'];
            $glicemia->data = $row['data_hora'];
            $glicemia->valor = $row['valor'];
            $glicemia->observacao = $row['observacao'] ?? '';
            $glicemia->paciente_id = $row['paciente_id'];
            $lista[] = $glicemia;
        }

        return $lista;
    }

    public static function find($id)
    {
        $connection = self::getConnection();
        $statement = $connection->prepare("SELECT * FROM glicemia WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        foreach ($statement as $row) {
            $glicemia = new Glicemia(); 
            $glicemia->id = $row['id'];
            $glicemia->data = $row['data_hora'];
            $glicemia->valor = $row['valor'];
            $glicemia->observacao = $row['observacao'] ?? '';
            $glicemia->paciente_id = $row['paciente_id'];
            return $glicemia;
        }

        return null;
    }

    public static function porPeriodo($pacienteId, $de, $ate)
    {
        $connection = self::getConnection();
        $de .= " 00:00:00";
        $ate .= " 23:59:59";

        $sql = "SELECT * FROM glicemia WHERE paciente_id = :paciente_id AND data_hora BETWEEN :de AND :ate ORDER BY data_hora";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':paciente_id', $pacienteId);
        $stmt->bindParam(':de', $de);
        $stmt->bindParam(':ate', $ate);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function porPacienteEPeriodo($pacienteId, $de, $ate)
    {
        return self::porPeriodo($pacienteId, $de, $ate);
    }

    public static function getConnection()
    {
        return new PDO('mysql:host=localhost;dbname=health_care', 'alex', '@1945Lucy@');
    }
}
