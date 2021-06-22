<?php

namespace Clases;

class Conexion
{
    private $datos = array("host" => "localhost", "user" => "root", "pass" => "", "db" => "estudio_rocha_tarde");

    private $con;

    public function con()
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        return $conexion;
    }

    public function conPDO()
    {
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=" . $this->datos["host"] . ";dbname=" . $this->datos["db"] . ";charset=utf8";
        try {
            $pdo = new \PDO($dsn, $this->datos["user"], $this->datos["pass"], $options);
            return $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function sql($query)
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        $conexion->query($query);
        $conexion->close();
    }

    public function sqlReturn($query)
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        $dato = $conexion->query($query);
        $conexion->close();
        return $dato;
    }

    public function returnConection()
    {
        return $this->datos;
    }
}
