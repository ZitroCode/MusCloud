<?php 
    include 'core/components/header.php';

    if (!isset($_SESSION['urs'])) {
        header("Location: http://localhost/reproductor/explore");
    }

    include 'core/components/navbar.php';
?>
<!-- Content for application -->
<div class="wh-100">
    <button id="menuToggler" data-content="#navbar-app"><i class="fas fa-bars"></i></button>
    <img src="public/img/fondo_secundario.jpg" class="wallpaper-web">
    <div class="login">
        <h2><span><img src="public/img/logo.png"></span><?php echo APP_NAME; ?></h2>
        <h3 class="title-extra">Eliminar Musica</h3>
        <div id="alert"></div>
        <div id="formDeleteSong" enctype="multipart/form-data">
            <label for="song" class="label-one">Seleciona una canción</label>
            <select id="selectMusic" class="control-form-upload">
                <option value="">Selecciona una canción</option>
            </select>

            <button type="submit" onclick="deleteSongID()" class="btnPrimary mb-1">Eliminar</button>
            <a href="<?php echo APP_URL; ?>" class="btn btn-error db">Cancelar</a>
        </div>
    </div>
</div>
<?php include 'core/components/footer.php'; ?>