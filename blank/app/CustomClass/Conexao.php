<?php

namespace App\CustomClass;

use PDO;
use PDOException;

/*
* Constantes de parâmetros para configuração da conexão
*/

define('HOSTDB', env('DB_HOST'));
define('DBNAME', env('DB_DATABASE'));
define('CHARSET', 'utf8');
define('USER', env('DB_USERNAME'));
define('PASSWORD', env('DB_PASSWORD'));



class Conexao
{

    /*
* Atributo estático para instância do PDO
*/
    private static $pdo;

    /*
* Escondendo o construtor da classe
*/
    private function __construct()
    {
        //
    }

    public function doSomething()
    {
        return 'doSomething';
    }
    /*
* Método estático para retornar uma conexão válida
* Verifica se já existe uma instância da conexão, caso não, configura uma nova conexão
*/
    public static function getInstance()
    {
        if (!isset(self::$pdo)) {
            try {
                $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', PDO::ATTR_PERSISTENT => TRUE);
                self::$pdo = new PDO("mysql:host=" . HOSTDB . "; dbname=" . DBNAME . "; charset=" . CHARSET . ";", USER, PASSWORD, $opcoes);
            } catch (PDOException $e) {
                print "Erro: " . $e->getMessage();
            }
        }
        return self::$pdo;
    }
}
