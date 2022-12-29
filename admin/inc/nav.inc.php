<?php if (isset($_SESSION["admin"])) { ?>
    <header class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <img height="40" src="<?= URL_ADMIN ?>/img/logo-blanco.png" style="display: inline-block">
                    <h1 class="fs-16 pt-22 mt-2 pb-20 ml-10" style="display: inline-block"><?= TITULO_ADMIN ?></h1>
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
                    <li class="nav-item dropdown <?= ($pagesCustom['contenidos'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Contenidos
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=contenidos&accion=ver">
                                Ver Contenidos
                            </a>
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=contenidos&accion=agregar">
                                Agregar Contenidos
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= ($pagesCustom['multimedia'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Multimedia
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item <?= ($pagesCustom['novedades'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=novedades&accion=ver">
                                Novedades
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['videos'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=videos&accion=ver">
                                Videos
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['sliders'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=sliders&accion=ver">
                                Sliders
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['galerias'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=galerias&accion=ver">
                                Galerias
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['banners'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=banners&accion=ver">
                                Banners
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class=" nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Productos
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=productos&accion=ver">
                                Ver Productos
                            </a>
                            <!-- <a class="dropdown-item <?= ($pagesCustom['importar'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=productos&accion=importar">
                                Importar Productos
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['exportar'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=productos&accion=importar_meli">
                                Exportar Productos a MercadoLibre
                            </a> -->
                            <!--                            <a class="dropdown-item --><?php //if ($pagesCustom['exportar'] != true) {
                                                                                        //                                echo 'd-none';
                                                                                        //                            } 
                                                                                        ?>
                            <!--" href="-->
                            <? //= URL 
                                            ?>
                            <!--/index.php?op=productos&accion=exportar">-->
                            <!--                                Exportar Listado de Productos-->
                            <!--                            </a>-->
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= ($pagesCustom['servicios'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Servicios
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=servicios">
                                Ver Servicios
                            </a>
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=servicios&accion=agregar">
                                Agregar Servicios
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= ($pagesCustom['portfolio'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Portfolio
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=portfolio">
                                Ver Portfolio
                            </a>
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=portfolio&accion=agregar">
                                Agregar Portfolio
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= ($pagesCustom['ecommerce'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Ecommerce
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item <?= ($pagesCustom['pedidos'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=ver">
                                Pedidos
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['envios'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=envios&accion=ver">
                                Métodos de Envios
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['pagos'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=pagos&accion=ver">
                                Métodos de Pagos
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['descuentos'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=descuentos&accion=ver">
                                Descuentos
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= ($pagesCustom['marketing'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Marketing
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item  <?php ($pagesCustom['seo'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=seo&accion=ver">
                                SEO
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['landing'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=landing&accion=ver">
                                Landing Page
                            </a>
                            <a class="dropdown-item <?= ($pagesCustom['analitica'] != true) ? 'd-none' : '' ?>" href="<?= URL_ADMIN ?>/index.php?op=analitica&accion=ver">
                                Analítica
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= ($pagesCustom['usuarios'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Usuarios
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=usuarios">
                                Ver Usuarios
                            </a>
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=usuarios&accion=agregar">
                                Agregar Usuarios
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?= ($pagesCustom['categorias'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            Categorias
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=categorias">
                                Ver Categorias
                            </a>
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=agregar">
                                Agregar Categorias
                            </a>
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=subcategorias&accion=agregar">
                                Agregar Subcategorias
                            </a>
                            <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=tercercategorias&accion=agregar">
                                Agregar Tercer Categorias
                            </a>
                        </div>
                    </li>
                    <li class="nav-item <?= ($pagesCustom['configuracion'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link" href="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar">
                            Configuración
                        </a>
                    </li>
                    <li class="nav-item <?= ($pagesCustom['administradores'] != true) ? 'd-none' : '' ?>">
                        <a class="nav-link" href="<?= URL_ADMIN ?>/index.php?op=administradores">
                            Administradores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL_ADMIN ?>/index.php?op=salir">
                            Salir
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
<?php } ?>