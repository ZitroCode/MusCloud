// var form = document.getElementById("form");

// form.addEventListener('submit', sendSong);

// function sendSong(e) {
//     var formData = new FormData();
//     var name = document.getElementById("name").value;
//     var artist = document.getElementById("artist").value;
//     var cover = document.getElementById("cover").files[0];
//     var song = document.getElementById("song").files[0];

//     formData.append('type', 'song');
//     formData.append('action', 'add');
//     formData.append('name', name);
//     formData.append('artist', artist);
//     formData.append('song', song);
//     formData.append('cover', cover);

//     // console.log(formData.get('song'));
//     var xhr = new XMLHttpRequest();
//     var urlRequest = 'http://localhost/reproductor/ajax.php';

//     xhr.onload = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             console.log((this.responseText));
//         }
//     }
//     xhr.open('POST', urlRequest, true);
//     xhr.send(formData);

//     e.preventDefault();
// }