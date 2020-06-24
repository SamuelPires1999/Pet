<?php
require_once "Basic.class.php";

class Animal extends Basic {

    public $id;
    public $id_usuario;
    public $usuario = null;
    public $id_tipo;
    public $tipo;
    public $id_raca;
    public $raca = null;
    public $nome_atende;
    public $cor_pelos;
    public $porte;
    public $idade;
    public $doencas_cuidados;
    public $local_referencia;
    public $situacao = 'em_aberto';
    public $sexo;
    public $tipo_cadastro;
    public $foto;
    public $datahora_cadastro;
    public $datahora_modificado;

    public static function select($keyColumn, $value, $returnObject = null) {
        return parent::select($keyColumn, $value, new Animal());
    }

    public static function selectAll($filters, $orderBy = null, $orderDirection = "ASC", $limit = 100, $offset = 0, $returnObject = null) {
        return parent::selectAll($filters, $orderBy, $orderDirection, $limit, $offset, new Animal());
    }

    public static function update($object, $keyColumn = null) {
        return parent::update($object, "id");
    }

}

class Tipo extends Basic {
    public $id;
    public $nome;
    public $datahora_cadastro;
    public $datahora_modificado;

    public static function select($keyColumn, $value, $returnObject = null) {
        return parent::select($keyColumn, $value, new Tipo());
    }

    public static function selectAll($filters, $orderBy = null, $orderDirection = "ASC", $limit = 100, $offset = 0, $returnObject = null) {
        return parent::selectAll($filters, $orderBy, $orderDirection, $limit, $offset, new Tipo());
    }

    public static function update($object, $keyColumn = null) {
        return parent::update($object, "id");
    }
}

class Raca extends Basic {
    public $id;
    public $nome;
    public $datahora_cadastro;
    public $datahora_modificado;

    public static function select($keyColumn, $value, $returnObject = null) {
        return parent::select($keyColumn, $value, new Raca());
    }

    public static function selectAll($filters, $orderBy = null, $orderDirection = "ASC", $limit = 100, $offset = 0, $returnObject = null) {
        return parent::selectAll($filters, $orderBy, $orderDirection, $limit, $offset, new Raca());
    }

    public static function update($object, $keyColumn = null) {
        return parent::update($object, "id");
    }
}