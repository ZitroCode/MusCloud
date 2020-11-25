var btnToggler =  document.getElementById("menuToggler");
var menuStatus =  false;

var appAudio = document.getElementById("songRe"); 

btnToggler.addEventListener('click', () =>{
    let menuContent = document.querySelector(btnToggler.dataset.content);
    if (menuStatus) {
        menuStatus =  false;
        menuContent.style.width = '0px';
        btnToggler.style.right = '50px';
    } else {
        menuStatus = true;
        menuContent.style.width = '400px';
        btnToggler.style.right = '20px';
    }
    // console.log(menuStatus);
});

var iconPlay = document.getElementById('play');
// var audioStatus =  false;
function playSong() {
    // console.log(listSongs);
    if (appAudio.src != null) {
        if (!appAudio.paused && !appAudio.ended) {
            appAudio.pause();
            // audioStatus = false;
            mensaje = 'Canción pausada';
            iconPlay.innerHTML = '<i class="fas fa-play"></i>';
        } else {
            appAudio.play();
            // audioStatus = true;
            mensaje = 'Reproduciendo';
            iconPlay.innerHTML = '<i class="fas fa-pause"></i>';
        }
    } else {
        appAudio.play();
        mensaje = 'Canción cargada y lista';
    }
    console.log('Estado: ' + mensaje);
}