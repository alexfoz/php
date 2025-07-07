<?php

class Model
{
    protected static function getConnection()
    {
        return new PDO(
            'mysql:host=127.0.0.1;dbname=health_care',
            'alex',
            '@1945Lucy@',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    // Torna o método acessível externamente (mudança opcional mas útil)
    public static function connect()
    {
        return static::getConnection();
    }
}
