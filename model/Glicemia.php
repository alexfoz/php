<?php

class Glicemia
{
    var $id;
    var $data;
    var $valor;

    public function save()
    {
        $connection = self::getConnection();

        if ($this->id == null) {

            $statement = $connection->prepare("INSERT INTO glicemia (data, valor) VALUES (:data, :valor)");
            $statement->bindParam(':data', $this->data);
            $statement->bindParam(':valor', $this->valor);
            $statement->execute();

        } else {

            $statement = $connection->prepare("UPDATE glicemia SET data = :data, valor = :valor WHERE id = :id");
            $statement->bindParam(':data', $this->data);
            $statement->bindParam(':valor', $this->valor);
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
            $glicemia->data = $row['data'];
            $glicemia->valor = $row['valor'];

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
        
//        return $statement->fetchObject(__CLASS__);

        foreach ($statement as $row) {

            $glicemia = new Glicemia(); 
            $glicemia->id = $row['id'];
            $glicemia->data = $row['data'];
            $glicemia->valor = $row['valor'];

            return $glicemia;
        }

        return null;
    }

    private static function getConnection()
    {
        return new PDO('mysql:host=127.0.0.1;dbname=health_care', 'root', '');
    }
}
