<?php if (isset($_SESSION["admin"])) {
    //MercadoLibre LINK
    $config = new Clases\Config();
    $tokenML = new Clases\TokenML();
    $f = new Clases\PublicFunction();
    $token = $tokenML->view();
    $meli = new Meli($config->meli["data"]["app_id"], $config->meli["data"]["app_secret"]);

    if (isset($_GET['code']) || isset($_SESSION['access_token'])) {
        if (isset($_GET['code']) && !isset($_SESSION['access_token'])) {
            try {
                $user = $meli->authorize($_GET["code"], URL_ADMIN);
                $_SESSION['user_id'] = $user['body']->user_id;
                $_SESSION['access_token'] = $user['body']->access_token;
                $_SESSION['expires_in'] = time() + $user['body']->expires_in;
                $_SESSION['refresh_token'] = $user['body']->refresh_token;
                $tokenML->set("accessToken", $_SESSION['access_token']);
                $tokenML->set("refreshToken", $_SESSION['refresh_token']);
                $tokenML->set("expireIn", $_SESSION['expires_in']);
                $tokenML->set("secretRequestId", '$2y$10$R6AtPT3VgGOUpeDcUGskI.c.G3vehd4MBq/9D38XwOJZbreF/m5BW');
                $tokenML->add();
            } catch (Exception $e) {
                echo "Exception: ", $e->getMessage(), "\n";
            }
        } else {
            if ($_SESSION['expires_in'] < time()) {
                try {
                    $refresh = $meli->refreshAccessToken();
                    $_SESSION['user_id'] = $refresh['body']->user_id;
                    $_SESSION['access_token'] = $refresh['body']->access_token;
                    $_SESSION['expires_in'] = time() + $refresh['body']->expires_in;
                    $_SESSION['refresh_token'] = $refresh['body']->refresh_token;
                } catch (Exception $e) {
                    echo "Exception: ", $e->getMessage(), "\n";
                }
            }
        }
    } else {
        $meliUrl = $meli->getAuthURL(URL_ADMIN, Meli::$AUTH_URL["MLA"]);
    }

?>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class=" nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block"><a class="" href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=ver" data-toggle="tooltip" data-placement="top" title="Pedidos"><i class="bx bxs-package"></i></a></li>
                            <li class="nav-item d-none d-lg-block ml-10"><a class="" href="<?= URL_ADMIN ?>/index.php?op=productos&accion=ver" data-toggle="tooltip" data-placement="top" title="Productos"><i class="bx bxs-store"></i></a></li>
                            <li class="nav-item d-none d-lg-block ml-10"><a class="" href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=estadisticas" data-toggle="tooltip" data-placement="top" title="Estadisticas"><i class="bx bx-trending-up"></i></a></li>
                            <li class="nav-item d-none d-lg-block ml-10"><a class="" href="<?= URL_ADMIN ?>/index.php?op=excel&accion=excel" data-toggle="tooltip" data-placement="top" title="Importar/Exportar"><i class="bx bx-export"></i></a></li>
                            <div class=" mt-25 bold text-uppercase pull-right">
                                <?= isset($meliUrl) ? "<a class='ml-15'style='position: absolute;right: 5%;' href='" . $meliUrl . "' target='_blank'><i class='fa fa-square'></i> ¿Vincular a MercadoLibre?</a>" : "<div class='ml-15'style='position: absolute;right: 5%;'><i class='fa fa-check-square'></i> VINCULADO A MERCADOLIBRE</div>" ?>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow text-capitalize" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="<?= URL_ADMIN ?>">
                        <div class="brand-logo"><img class="logo" src="<?= URL_ADMIN ?>/img/logo-blanco.png" /></div>
                        <h2 class="brand-text mb-0"><b class=" fs-23"> </b></h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class=" modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
                <li class="nav-item">
                    <a href="<?= URL_ADMIN ?>">
                        <i class="menu-livicon" data-icon="home"></i>
                        <span class="menu-title">Inicio</span>
                    </a>
                </li>
                <li class="nav-item <?php (!$pagesCustom['contenidos']) ? 'd-none' : '' ?>">
                    <a href="#">
                        <i class="menu-livicon" data-icon="plus-alt"></i>
                        <span class="menu-title">Contenidos</span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class=" <?php (!$pagesCustom['menu']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=menu&accion=ver">
                                Menu
                            </a>
                        </li>
                        <li>
                            <a class=" <?php (!$pagesCustom['banners']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=banners&accion=ver&idioma=<?= $_SESSION["defaultLang"] ?>">
                                Banners
                            </a>
                        </li>
                        <li><a href="#"><span class="menu-item" data-i18n="Second Level">Áreas</span></a>
                            <ul class="menu-content">
                        <?php
                        $area = new Clases\Area();
                        $areas = $area->list([], "titulo ASC", "", $_SESSION["defaultLang"]);
                        foreach ($areas as $areaData) { ?>
                            <li>
                                <a href="<?= URL_ADMIN ?>/index.php?op=contenidos&accion=ver&area=<?= $areaData['data']['cod'] ?>&idioma=<?= $_SESSION["defaultLang"] ?>">
                                    <span><?= mb_strtolower($areaData['data']['titulo']) ?></span>
                                </a>
                            </li>
                        <?php } ?>
                            </ul>
                        </li>
                        <li>
                            <a class=" <?php (!$pagesCustom['banners']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=area&accion=ver&idioma=<?= $_SESSION["defaultLang"] ?>">
                                Administrar Áreas
                            </a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="tag"></i><span class="menu-title">Productos</span></a>
                    <ul class="menu-content">
                        <li><a href="<?= URL_ADMIN ?>/index.php?op=productos&accion=ver&idioma=<?= $_SESSION["defaultLang"] ?>">
                                Ver Productos
                            </a>
                        </li>
                        <li><a href="#"><span class="menu-item" data-i18n="Second Level">MercadoLibre</span></a>
                            <ul class="menu-content">
                                <li>
                                    <a class=" <?php (!$pagesCustom['mercadolibre']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=mercadolibre&accion=importar">
                                        Importar / Actualizar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= URL_ADMIN ?>/index.php?op=productos&accion=productos-relacionado-meli">
                                        Relacionados
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#"><span class="menu-item" data-i18n="Second Level">+ Funciones</span></a>
                            <ul class="menu-content">
                                <li>
                                    <a class=" <?php (!$pagesCustom['productos-relacionados']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=productos-relacionados&accion=ver">
                                        Relacionar Productos
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= URL_ADMIN ?>/index.php?op=productos&accion=porcentaje-subcategoria">
                                        Descuentos por Categoria
                                    </a>
                                </li>
                                <li>
                                    <a class=" <?php (!$pagesCustom['subir-archivos']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=subir-archivos">
                                        Subir Imágenes por Código
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?php (!$pagesCustom['ecommerce']) ? 'd-none' : '' ?>">
                    <a href="#">
                        <i class="menu-livicon" data-icon="us-dollar"></i>
                        <span class="menu-title">Ecommerce</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class=" <?php (!$pagesCustom['pedidos']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=ver">
                                Pedidos
                            </a>
                        </li>
                        <li><a class=" <?php (!$pagesCustom['pedidos']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=estadisticas">
                                Estadisticas
                            </a>
                        </li>
                        <li>
                            <a href="#"><span class="menu-item" data-i18n="Second Level">Usuarios</span></a>
                            <ul class="menu-content">
                                <li>
                                    <a href="<?= URL_ADMIN ?>/index.php?op=usuarios">
                                        Ver Usuarios
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= URL_ADMIN ?>/index.php?op=usuarios&accion=agregar">
                                        Agregar Usuarios
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="menu-item" data-i18n="Second Level">Configuración</span></a>
                            <ul class="menu-content">
                                <li>
                                    <a class=" <?php (!$pagesCustom['estados-pedidos']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=estados-pedidos&accion=ver">
                                        Estados
                                    </a>
                                </li>
                                <li>
                                    <a class=" <?php (!$pagesCustom['envios']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=envios&accion=ver">
                                        Métodos de Envios
                                    </a>
                                </li>
                                <li>
                                    <a class=" <?php (!$pagesCustom['pagos']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=pagos&accion=ver">
                                        Métodos de Pagos
                                    </a>
                                </li>
                                <li>
                                    <a class=" <?php (!$pagesCustom['descuentos']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=descuentos&accion=ver">
                                        Descuentos
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>


                <li class="nav-item <?php (!$pagesCustom['marketing']) ? 'd-none' : '' ?>">
                    <a href="#">
                        <i class="menu-livicon" data-icon="pie-chart"></i>
                        <span class="menu-title">Marketing</span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class=" <?php (!$pagesCustom['seo']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=seo&accion=ver">
                                seo
                            </a>
                        </li>
                        <li>
                            <a class=" <?php (!$pagesCustom['landing']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=landing&accion=ver">
                                Landing Page
                            </a>
                        </li>
                        <li>
                            <a class=" <?php (!$pagesCustom['analitica']) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=analitica&accion=ver">
                                Analítica
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?php (!$pagesCustom['categorias']) ? 'd-none' : '' ?>">
                    <a href="#">
                        <i class="menu-livicon" data-icon="thumbnails-big"></i>
                        <span class="menu-title">Categorias</span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&idioma=<?= $_SESSION["defaultLang"] ?>">
                                Ver Categorias
                            </a>
                        </li>
                        <li>
                            <a href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=agregar&idioma=<?= $_SESSION["defaultLang"] ?>">
                                Agregar Categorias
                            </a>
                        </li>
                        <li>
                            <a href="<?= URL_ADMIN ?>/index.php?op=subcategorias&accion=agregar&idioma=<?= $_SESSION["defaultLang"] ?>">
                                Agregar Sub Categorias
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?php (!$pagesCustom['excel']) ? 'd-none' : '' ?>">
                    <a href="<?= URL_ADMIN ?>/index.php?op=excel&accion=excel">
                        <i class="menu-livicon" data-icon="file-export"></i>
                        <span class="menu-title">Importar / Exportar Excel</span>
                    </a>
                </li>
                <li class="nav-item <?php (!$pagesCustom['configuracion']) ? 'd-none' : '' ?>">
                    <a href="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar">
                        <i class="menu-livicon" data-icon="wrench"></i>
                        <span class="menu-title">Configuración</span>
                    </a>
                </li>
                <li class="nav-item <?php (!$pagesCustom['administradores']) ? 'd-none' : '' ?>">
                    <a href="<?= URL_ADMIN ?>/index.php?op=administradores">
                        <i class="menu-livicon" data-icon="users"></i>
                        <span class="menu-title">Administradores</span>
                    </a>
                </li>
                <li class="nav-item <?php (!$pagesCustom['idiomas']) ? 'd-none' : '' ?>">
                    <a href="<?= URL_ADMIN ?>/index.php?op=idiomas">
                        <i class="menu-livicon" data-icon="globe"></i>
                        <span class="menu-title">Idiomas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= URL_ADMIN ?>/index.php?op=salir">
                        <i class="menu-livicon" data-icon="close"></i>
                        Salir
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">

            <?php } ?>