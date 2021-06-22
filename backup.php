<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$conexion = new Clases\Conexion();
$data = $conexion->returnConection();

use Coderatio\SimpleBackup\SimpleBackup;

$file_name = "backup-" . date("d-m-Y");
$rootPath = 'backup/';

// Set the database to backup
$simpleBackup = SimpleBackup::setDatabase([$data["db"], $data["user"], $data["pass"], $data["host"]])->storeAfterExportTo($rootPath, $file_name);

var_dump($simpleBackup->getResponse());