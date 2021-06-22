<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$f = new Clases\PublicFunction();
$productos = new Clases\Productos();
$contenidos = new Clases\Contenidos();

$otras = array("sesion", "productos", "empresa", "novedades", "contacto");

$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($productos->list("") as $productoItem) {
    $cod = $productoItem["data"]["cod"];
    $titulo = $f->normalizar_link($productoItem["data"]["titulo"]);
    $xml .= '<url><loc>' . URL . '/producto/' . $titulo . '/' . $cod . '</loc><lastmod>' . $productoItem["data"]["fecha"] . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach ($contenidos->list($data) as $contenidoItem) {
    $titulo = $f->normalizar_link($contenidoItem["data"]["cod"]);
    $xml .=  '<url><loc>' . URL . '/c/' . $titulo . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach ($otras as $otro) {
    $xml .=  '<url><loc>' . URL . '/' . $otro . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>1</priority></url>';
}

$xml .= '</urlset>';

header("Content-Type: text/xml;");
echo $xml;
