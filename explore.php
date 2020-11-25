<!-- header and navbar for application -->
<?php 
    include 'core/components/header.php';
    include 'core/components/navbar.php';

    if (!isset($_SESSION['urs'])) {
        header("Location: http://localhost/reproductor");
    }
?>
<!-- Content for application -->
<div class="container">
    <button id="menuToggler" data-content="#navbar-app"><i class="fas fa-bars"></i></button>
    <div class="col-1">
        <img src="public/img/cover.jpg" id="musicCover">
    </div>
    <div class="col-2">
        <div class="music-container">
            <h3 class="appName"><?php echo APP_NAME; ?></h3>
            <h1 class="namePrimary">
                <span id="musicName">No Disponible</span>,
                <br>
                <span id="artistName">No Disponible</span>
            </h1>
            <div class="containerSearch">
                <span class="fas fa-search icon-search"></span>
                <input type="text" id="searchSong" class="control-search" placeholder="Search Song">
            </div>
            <div class="playlist-items" id="playlist"></div>
            <div class="player-items">
                <img src="public/img/cover.jpg" id="musicCover-small" width="65">
                <div class="songActual">
                    <h3 id="actualMusic">Sin reproducir</h3>
                    <p id="actualArtist">Desconocido</p>
                </div>
                <div class="player-controls">
                    <span id="previous" onclick="previous()"><i class="fas fa-step-backward"></i></span>
                    <span id="play" onclick="playSong()"><i class="fas fa-play"></i></span>
                    <span id="next" onclick="next()"><i class="fas fa-step-forward"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<audio id="songRe"></audio>
<?php include 'core/components/footer.php'; ?>