var playlist = document.getElementById('playlist');
var selectSongDelete = document.getElementById('selectMusic');
var songAcually;
var previousSong = 0;
var cover = document.getElementById('musicCover');
var coverSmall = document.getElementById('musicCover-small');
var listSongs = new Array();
var appAudio = document.getElementById('songRe');

if (document.querySelectorAll('#playlist').length > 0) {
    getSongs();
}

if (document.querySelectorAll('#selectMusic').length > 0) {
    getSongID();
}

function getSongs() {
    var xhr = new XMLHttpRequest();
    var urlRequest = 'http://localhost/reproductor/ajax.php';
    var params = 'type=song&action=get';

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            // console.log(data);
            // listSongs = data;
            for(i=0; i < data.length; i++){
                // console.log(data[i]);
                listSongs.push({
                    Position: parseInt(i+1),
                    Id: data[i]['Id'],
                    Name: data[i]['Name'],
                    Artists: data[i]['Artists'],
                    Url: data[i]['Url'],
                    Cover: data[i]['Cover'],
                    Created_date: data[i]['Created_date'],
                });

                playlist.innerHTML += `
                <div class="playlist-item" onclick="selectMusic(${parseInt(i+1)})" id="song-${parseInt(i+1)}">
                    <h2 id="nameSong">${data[i]['Name']}</h2>
                    <p id="nameArtist">${data[i]['Artists']}</p>
                </div>
                `;
                // song-actived | <i class="fas fa-assistive-listening-systems icon-playlist"></i>   
            }
            songAcually = 1;
            previousSong = null;
            playMusic();        
        }
    }
    xhr.open('POST', urlRequest, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}

function selectMusic(music){
    previousSong = songAcually;

    songAcually = music;
    playMusic();
    appAudio.play();
}

function playMusic(){
    if (previousSong != null) {
        var previousSongHTML =  document.getElementById('song-'+previousSong);
        previousSongHTML.classList.toggle('song-actived');
    }
    var songHTML =  document.getElementById('song-'+songAcually);
    songHTML.classList.toggle('song-actived');

    let nameSmall = document.getElementById('actualMusic');
    let artistSmall = document.getElementById('actualArtist');
    let name = document.getElementById('musicName');
    let artist = document.getElementById('artistName');

    for(i=0; i < listSongs.length; i++){
        if (listSongs[i]['Position'] == songAcually){
            console.log('Esta es la canción actual: ' + listSongs[i]['Name'])
            cover.src = listSongs[i]['Cover'];
            coverSmall.src = listSongs[i]['Cover'];
            nameSmall.textContent = listSongs[i]['Name'];
            name.textContent = listSongs[i]['Name'];
            artistSmall.textContent = listSongs[i]['Artists'];
            artist.textContent = listSongs[i]['Artists'];

            appAudio.src = listSongs[i]['Url'];
            getDuration();
        }
    }
}

function next() {
    previousSong = songAcually;
    if (songAcually < listSongs.length) {
        songAcually++;
    } else {
        songAcually = 1;
    }
    playMusic();
    appAudio.play();
    iconPlay.innerHTML = '<i class="fas fa-pause"></i>';
}

function previous(){
    previousSong = songAcually;
    if (songAcually != 1) {
        songAcually--;
    } else {
        songAcually = listSongs.length;
    }
    playMusic();
    appAudio.play();
    iconPlay.innerHTML = '<i class="fas fa-pause"></i>';
}

var formAddSong = document.getElementById("formAddSong");
formAddSong.addEventListener('submit', sendSong);

function sendSong(e) {
    alert.classList = '';
    alert.innerHTML = '';

    var formData = new FormData();
    var name = document.getElementById("name").value;
    var artist = document.getElementById("artist").value;
    var cover = document.getElementById("cover").files[0];
    var song = document.getElementById("song").files[0];

    formData.append('type', 'song');
    formData.append('action', 'add');
    formData.append('name', name);
    formData.append('artist', artist);
    formData.append('song', song);
    formData.append('cover', cover);

    // console.log(formData.get('song'));
    var xhr = new XMLHttpRequest();
    var urlRequest = 'http://localhost/reproductor/ajax.php';

    xhr.onload = function () {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(JSON.parse(this.responseText));
            var data = JSON.parse(this.responseText);
            switch (data) {
                case 'empty_fields':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Llena todos los campos.';
                break;
                case 'error_cover':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Verifica tu portada esa JPG, JPEG o PNG.';
                break;
                case 'error_song':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Verifica que tu canción este en formato MP3.';
                break;
                case 'error_move_audio':
                    alertDiv.classList = 'alert alert-warning';
                    alertDiv.innerHTML = '<b>Advertencia: </b>Hemos tenia problemas al subir tu audio. Intenta más tarde.';
                break;
                case 'error_move_image':
                    alertDiv.classList = 'alert alert-warning';
                    alertDiv.innerHTML = '<b>Advertencia: </b>Hemos tenia problemas al subir tu imagen. Intenta más tarde.';
                break;
                case 'error_addSong':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Hemos detectado un error en nuestro servidor. Intenta más tarde.';
                break;
                case 'success_song':
                    alertDiv.classList = 'alert alert-success';
                    alertDiv.innerHTML = '<b>Tu canción esta prepara para ser escuchada.</b>';
                break;

            }
        }
    }
    xhr.open('POST', urlRequest, true);
    xhr.send(formData);

    e.preventDefault();
}

function getDuration(){
    setInterval(() => {
        if (appAudio.currentTime == appAudio.duration){
            next();
        }
    }, 1000);
}

function getSongID() {
    var xhr = new XMLHttpRequest();
    var urlRequest = 'http://localhost/reproductor/ajax.php';
    var params = 'type=song&action=get';
    selectSongDelete.innerHTML = '<option value="">Selecciona una canción</option>';
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            // console.log(data);
            // listSongs = data;
            for(i=0; i < data.length; i++){

                listSongs.push({
                    Position: parseInt(i+1),
                    Id: data[i]['Id'],
                    Name: data[i]['Name'],
                    Artists: data[i]['Artists'],
                    Url: data[i]['Url'],
                    Cover: data[i]['Cover'],
                    Created_date: data[i]['Created_date'],
                });

                selectSongDelete.innerHTML += `
                <option value="${data[i]['Id']}" id="song-${data[i]['Id']}" data-image="${data[i]['Cover']}" data-audio="${data[i]['Url']}">
                    ${data[i]['Artists'] + ' - ' + data[i]['Name']}
                </option>
                `; 
            }      
        }
    }
    xhr.open('POST', urlRequest, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}

function deleteSongID() {
    var idSong = document.getElementById('selectMusic').value;
    var option = document.getElementById('song-'+idSong)

    var xhr = new XMLHttpRequest();
    var urlRequest = 'http://localhost/reproductor/ajax.php';
    var params = 'type=song&action=delete';
    params += '&id=' + idSong + '&image=' + option.dataset.image + '&audio=' + option.dataset.audio;

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);  
            // console.log(data);
            switch (data) {
                case 'empty_fields':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Por favor, selecciona una canción de la lista.';
                break;
                case 'error_delete':
                    alertDiv.classList = 'alert alert-warning';
                    alertDiv.innerHTML = '<b>Error: </b>Hubo un problema al eliminar la cación, Intenta más tarde.';
                break;
                case 'success_deleteSong':
                    alertDiv.classList = 'alert alert-success';
                    alertDiv.innerHTML = '<b>La canción se elimino correctamente</b>';
                break;
            }
        }
    }
    xhr.open('POST', urlRequest, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);

    getSongID()
}

function updateSongHtml() {
    var selectMusic = document.getElementById('selectMusic');
    // console.log(selectMusic.value);
    var name = document.getElementById("name"); 
    var artists = document.getElementById("artist");
    // console.log(listSongs);
    for (let i=0; i < listSongs.length; i++) {
        if (listSongs[i]['Id'] == selectMusic.value) {
            // console.log(listSongs[i]);
            name.value = listSongs[i]['Name'];
            artists.value = listSongs[i]['Artists'];
        }
    }
}

function updateSong() {
    var idSong = document.getElementById('selectMusic').value;
    var name = document.getElementById("name").value; 
    var artists = document.getElementById("artist").value;

    var xhr = new XMLHttpRequest();
    var urlRequest = 'http://localhost/reproductor/ajax.php';
    var params = 'type=song&action=update';
    params += '&id=' + idSong + '&name=' + name + '&artist=' + artists;
    // console.log(params);
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);  
            console.log(data);
            switch (data) {
                case 'empty_fields':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Por favor, selecciona una canción de la lista y asegurate de no tener campos vacios.';
                break;
                case 'error_update':
                    alertDiv.classList = 'alert alert-warning';
                    alertDiv.innerHTML = '<b>Error: </b>Hubo un problema al actualizar la cación, Intenta más tarde.';
                break;
                case 'success_updateSong':
                    alertDiv.classList = 'alert alert-success';
                    alertDiv.innerHTML = '<b>La canción se actualizo correctamente</b>';
                break;
            }
        }
    }
    xhr.open('POST', urlRequest, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);

    getSongID();
}