<?php
$rol = $_SESSION["admin"]["rol"];

$pages = [
    "area" => true,
    "contenidos" => false,
    "menu" => true,
    "multimedia" => false,
    "banners" => false,
    "productos" => false,
    "importar" => false,
    "exportar" => false,
    "ecommerce" => false,
    "pedidos" => false,
    "pagos" => false,
    "descuentos" => false,
    "envios" => false,
    "marketing" => false,
    "landing" => false,
    "analitica" => false,
    "comentariosfb" => false,
    "usuarios" => false,
    "categorias" => false,
    "subcategorias" => false,
    "configuracion" => false,
    "idiomas" => false,
    "administradores" => false,
    "mercadolibre" => false,
    "productos-relacionados" => false,
    "seo" => false,
    "excel" => false,
    "estados-pedidos" => false,
];

foreach ($rol as $value) {
    switch ($value) {
            //desarrollador
        case 1:
            $pages["contenidos"] = true;
            $pages["idiomas"] = true;
            $pages["multimedia"] = true;
            $pages["banners"] = true;
            $pages["productos"] = true;
            $pages["importar"] = true;
            $pages["exportar"] = true;
            $pages["ecommerce"] = true;
            $pages["pedidos"] = true;
            $pages["pagos"] = true;
            $pages["descuentos"] = true;
            $pages["envios"] = true;
            $pages["marketing"] = true;
            $pages["landing"] = true;
            $pages["analitica"] = true;
            $pages["comentariosfb"] = true;
            $pages["usuarios"] = true;
            $pages["categorias"] = true;
            $pages["subcategorias"] = true;
            $pages["configuracion"] = true;
            $pages["administradores"] = true;
            $pages["subir-archivos"] = true;
            $pages["mercadolibre"] = true;
            $pages["productos-relacionados"] = true;
            $pages["seo"] = true;
            $pages["excel"] = true;
            $pages["estados-pedidos"] = true;
            break;
            //superadmin
        case 2:
            $pages["contenidos"] = true;
            $pages["idiomas"] = true;
            $pages["multimedia"] = true;
            $pages["banners"] = true;
            $pages["productos"] = true;
            $pages["importar"] = true;
            $pages["exportar"] = true;
            $pages["ecommerce"] = true;
            $pages["pedidos"] = true;
            $pages["pagos"] = true;
            $pages["descuentos"] = true;
            $pages["envios"] = true;
            $pages["marketing"] = true;
            $pages["landing"] = true;
            $pages["analitica"] = true;
            $pages["comentariosfb"] = true;
            $pages["usuarios"] = true;
            $pages["categorias"] = true;
            $pages["subcategorias"] = true;
            $pages["configuracion"] = true;
            $pages["administradores"] = true;
            $pages["subir-archivos"] = true;
            $pages["mercadolibre"] = true;
            $pages["productos-relacionados"] = true;
            $pages["seo"] = true;
            $pages["excel"] = true;
            $pages["estados-pedidos"] = true;
            break;
            //marketing
        case 3:
            $pages["marketing"] = true;
            $pages["landing"] = true;
            $pages["analitica"] = true;
            $pages["comentariosfb"] = true;
            $pages["mercadolibre"] = true;
            $pages["seo"] = true;
            $pages["excel"] = true;
            break;
            //ecommerce
        case 4:
            $pages["ecommerce"] = true;
            $pages["pedidos"] = true;
            $pages["pagos"] = true;
            $pages["envios"] = true;
            $pages["descuentos"] = true;
            $pages["productos"] = true;
            $pages["subir-archivos"] = true;
            $pages["importar"] = true;
            $pages["exportar"] = true;
            $pages["mercadolibre"] = true;
            $pages["productos-relacionados"] = true;
            $pages["excel"] = true;
            $pages["estados-pedidos"] = true;
            break;
            //generador contenidos
        case 5:
            $pages["contenidos"] = true;
            $pages["idiomas"] = true;
            $pages["multimedia"] = true;
            $pages["banners"] = true;
            break;
    }
}
