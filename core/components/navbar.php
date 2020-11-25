<?php  
$url = $_SERVER['REQUEST_URI'];
$url = explode('/',$url);
$url = end($url);
?>


<section class="menu" id="navbar-app">
    <div class="space">
        <h2><?php echo APP_NAME; ?></h2>
    </div>
    <div class="info-user">
        <img src="<?php echo $_SESSION['urs']->Img; ?>" width="49">
        <h3 id="user-name"><?php echo $_SESSION['urs']->Name . ' ' . $_SESSION['urs']->Lastname; ?></h4>
            <p id="user-nick"><?php echo $_SESSION['urs']->Username; ?></p>
    </div>
    <div class="menu-items">
        <div class="menu-item">
            <a href="<?php echo APP_URL; ?>/explore" class="menu-title <?php echo ($url == 'explore') ? 'menu-title-actived' : ''; ?>">Explorar</a>
        </div>
        <div class="menu-item">
            <a href="<?php echo APP_URL; ?>/upload" class="menu-title <?php echo ($url == 'upload') ? 'menu-title-actived' : ''; ?>">Subir</a>
        </div>
        <div class="menu-item">
            <a href="<?php echo APP_URL; ?>/update" class="menu-title <?php echo ($url == 'update') ? 'menu-title-actived' : ''; ?>">Editar</a>
        </div>
        <div class="menu-item">
            <a href="<?php echo APP_URL; ?>/delete" class="menu-title <?php echo ($url == 'delete') ? 'menu-title-actived' : ''; ?>">Eliminar</a>
        </div>
        <div class="menu-item">
            <a href="<?php echo APP_URL; ?>/account" class="menu-title <?php echo ($url == 'account') ? 'menu-title-actived' : ''; ?>">Cuenta</a>
        </div>
        <div class="menu-item pb-1">
            <a href="<?php echo APP_URL; ?>/sign-off" class="menu-title">Cerrar Sesión</a>
        </div>
    </div>
    <p class="credit"><?php echo  APP_AUTOR; ?></p>
</section>