Instalar banco de dados:
------------------------
sudo apt install mysql


Criar banco de dados:
---------------------
CREATE DATABASE health_care;


Criar tabela:
-------------
CREATE TABLE glicemia (
	`id` INT NOT NULL AUTO_INCREMENT,
	`data` DATETIME NOT NULL,
	`valor` INT NOT NULL,
	PRIMARY KEY (`id`)
);
