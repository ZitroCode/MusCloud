<!-- header and navbar for application -->
<?php 
    include 'core/components/header.php';
    include 'core/components/navbar.php';
?>
<!-- Content for application -->
<div class="wh-100">
    <img src="public/img/fondo.jpg" class="wallpaper-web">
    <div class="login" id="login-form">
        <h2><span><img src="public/img/logo.png"></span><?php echo APP_NAME; ?></h2>
        <h3 class="title-extra">Registrate</h3>
        <div id="form-contents">
            <div id="alert"></div>
            <input type="text" class="control-form" id="name" placeholder="Nombre">
            <input type="text" class="control-form" id="lastname" placeholder="Apellidos">
            <input type="text" class="control-form" id="email" placeholder="Correo Electronico">
            <input type="password" class="control-form" id="password" placeholder="Contraseña">
            <input type="password" class="control-form" id="confirm_password" placeholder="Confirmar contraseña">
            <button id="btnLogin" onclick="register(event);">Crear Cuenta</button>
        </div>
        <p class="link-extra">¿Ya tiene cuenta? <a href="<?php echo APP_URL; ?>">Iniciar Sesión.</a></p>
    </div>
</div>
<?php include 'core/components/footer.php'; ?>