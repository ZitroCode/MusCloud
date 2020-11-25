<!-- header and navbar for application -->
<?php 
    include 'core/components/header.php';

    if (isset($_SESSION['urs'])) {
        header("Location: http://localhost/reproductor/explore");
    }

    include 'core/components/navbar.php';
?>
<!-- Content for application -->
<div class="wh-100">
    <img src="public/img/fondo.jpg" class="wallpaper-web">
    <div class="login">
        <h2><span><img src="public/img/logo.png"></span><?php echo APP_NAME; ?></h2>
        <h3 class="title-extra">Iniciar Sesión</h3>
        <div id="form-contents">
            <div id="alert"></div>
            <input type="text" class="control-form" id="email" placeholder="Correo Electronico">
            <input type="password" class="control-form" id="password" placeholder="Contraseña">
            <button id="btnLogin" class="btnPrimary" onclick="login();">Acceder</button>
        </div>
        <p class="link-extra">¿No tiene cuenta? <a href="<?php echo APP_URL; ?>/register">Crea una.</a></p>
    </div>
</div>
<?php include 'core/components/footer.php'; ?>