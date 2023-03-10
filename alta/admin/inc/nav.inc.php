<?php if (isset($_SESSION["admin"])) { ?>
    <header class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <img height="40" src="<?= URLADMIN ?>/img/logo-blanco.png" style="display: inline-block">
                    <h1 class="fs-16 pt-22 mt-2 pb-20 ml-10" style="display: inline-block"><?= TITULO_ADMIN ?></h1>
                </div>
                <div class="col-md-6 text-right mt-20 text-uppercase">
                    <?php
                    if (isset($_GET['code']) || isset($_SESSION['access_token'])) {
                        if (isset($_GET['code']) && !isset($_SESSION['access_token'])) {
                            try {
                                $user = $meli->authorize($_GET["code"], URL);
                                $_SESSION['user_id'] = $user['body']->user_id;
                                $_SESSION['access_token'] = $user['body']->access_token;
                                $_SESSION['expires_in'] = time() + $user['body']->expires_in;
                                $_SESSION['refresh_token'] = $user['body']->refresh_token;
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
                        echo '<span class="nav-link"><img src="' . URLADMIN . '/img/meli.png" width="30" /> Vinculaci??n a Mercadolibre <i class="fa fa-check-square green"></i></span>';
                    } else {
                        echo '<a class="nav-link" id="mercadolibre-nav" target="_blank" href="' . $meli->getAuthUrl(URL, Meli::$AUTH_URL["MLA"]) . '"><img src="' . URLADMIN . '/img/meli.png" width="30" /> ??Vincularme a Mercadolibre <i class="fa fa-square green">?</i></a>';
                    }

                    ?>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-30">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
            </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['contenidos'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Contenidos
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=contenidos&accion=ver">
                                Ver Contenidos
                            </a>
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=contenidos&accion=agregar">
                                Agregar Contenidos
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['multimedia'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Multimedia
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item <?php if ($pagesCustom['novedades'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=novedades&accion=ver">
                                Novedades
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['videos'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=videos&accion=ver">
                                Videos
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['sliders'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=sliders&accion=ver">
                                Sliders
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['galerias'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=galerias&accion=ver">
                                Galerias
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['banners'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=banners&accion=ver">
                                Banners
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['productos'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Productos
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=productos&accion=ver">
                                Ver Productos
                            </a>
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=productos&accion=agregar">
                                Agregar Productos
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['importar'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=productos&accion=importar">
                                Importar Productos
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['exportar'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=productos&accion=importar_meli">
                                Exportar Productos a MercadoLibre
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['exportar'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=productos&accion=exportar">
                                Exportar Listado de Productos
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['exportar'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=subir-archivos" >
                                Subir Im??genes por C??digo
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['importar'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=productos&accion=importar-imagenes" >
                                Importar Excel con Im??genes
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['servicios'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Servicios
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=servicios">
                                Ver Servicios
                            </a>
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=servicios&accion=agregar">
                                Agregar Servicios
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['portfolio'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Portfolio
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=portfolio">
                                Ver Portfolio
                            </a>
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=portfolio&accion=agregar">
                                Agregar Portfolio
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['ecommerce'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Ecommerce
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item <?php if ($pagesCustom['pedidos'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=pedidos&accion=ver">
                                Pedidos
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['envios'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=envios&accion=ver">
                                M??todos de Envios
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['pagos'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=pagos&accion=ver">
                                M??todos de Pagos
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['descuentos'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=descuentos&accion=ver">
                                Descuentos
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['marketing'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Marketing
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item <?php if ($pagesCustom['landing'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=landing&accion=ver">
                                Landing Page
                            </a>
                            <a class="dropdown-item <?php if ($pagesCustom['analitica'] != true) {
                                echo 'd-none';
                            } ?>" href="<?= URLADMIN ?>/index.php?op=analitica&accion=ver">
                                Anal??tica
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['usuarios'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Usuarios
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=usuarios">
                                Ver Usuarios
                            </a>
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=usuarios&accion=agregar">
                                Agregar Usuarios
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if ($pagesCustom['categorias'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Categorias
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=categorias">
                                Ver Categorias
                            </a>
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=categorias&accion=agregar">
                                Agregar Categorias
                            </a>
                            <a class="dropdown-item" href="<?= URLADMIN ?>/index.php?op=subcategorias&accion=agregar">
                                Agregar Sub Categorias
                            </a>
                        </div>
                    </li>
                    <li class="nav-item <?php if ($pagesCustom['configuracion'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link" href="<?= URLADMIN ?>/index.php?op=configuracion&accion=modificar">
                            Configuraci??n
                        </a>
                    </li>
                    <li class="nav-item <?php if ($pagesCustom['configuracion'] != true) {
                        echo 'd-none';
                    } ?>">
                        <a class="nav-link" href="<?= URLADMIN ?>/index.php?op=administradores">
                            Administradores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLADMIN ?>/index.php?op=salir">
                            Salir
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<?php } ?>