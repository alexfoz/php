<?php

class Model
{
    protected static function getConnection()
    {
        return new PDO('mysql:host=127.0.0.1;dbname=health_care', 'root', '');

        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    }
}