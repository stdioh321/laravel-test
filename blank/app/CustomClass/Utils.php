<?php

namespace App\CustomClass;

use PDO;
use PDOException;

/*
* Constantes de parâmetros para configuração da conexão
*/

class Utils
{

    /*
* Atributo estático para instância do PDO
*/
    private static $instance = null;

    /*
* Escondendo o construtor da classe
*/
    private function __construct()
    {
        error_log('UTILS CONSTRUCT');
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
        if (empty(self::$instance)) {
            self::$instance = new Utils();
        }
        return self::$instance;
    }
}
