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
        <h3 class="title-extra">Subir Musica</h3>
        <div id="alert"></div>
        <form id="formAddSong" enctype="multipart/form-data">
            <label for="name" class="label-one">Nombre de la canción</label>
            <input type="text" class="control-form" placeholder="Ingresa el nombre" id="name">

            <label for="artist" class="label-one">Nombre del artista</label>
            <input type="text" class="control-form" placeholder="Ingresa el nombre" id="artist">

            <label for="cover" class="label-one">Seleciona la portada</label>
            <input type="file" class="control-form-upload"  id="cover"> 

            <label for="song" class="label-one">Seleciona la cación</label>
            <input type="file" class="control-form-upload" id="song">

            <button type="submit" class="btnPrimary mb-1">Guardar</button>
            <a href="<?php echo APP_URL; ?>" class="btn btn-info db">Volver</a>
        </form>
    </div>
</div>
<?php include 'core/components/footer.php'; ?>