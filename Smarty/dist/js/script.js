

//AUDIO PLAYER

// Selezione degli elementi nella pagina HTML e assegnazione a una variabile

let playpause_btn = document.querySelector(".playpause-track"); // riferimento al bottone playpause
let seek_slider = document.querySelector(".seek_slider"); // riferimento allo slider del minutaggio
let volume_slider = document.querySelector(".volume_slider"); // riferimento allo slider del volume
let curr_time = document.querySelector(".current-time"); // riferimento al minutaggio attuale
let total_duration = document.querySelector(".total-duration"); // riferimento alla durata effettiva


// Specifica valori globali
let isPlaying = false;
let updateTimer;

// Creazione dell'elemento audio nell'html per il player
let curr_track = document.createElement('audio');

// Funzione per caricare e riprodurre la traccia audio dal backend
function loadAudioTrack(episode_id) {
  fetch('/Jampod/Episode/listenEpisode/' + episode_id) 
      .then(response => { // gestione della risposta
          if (!response.ok) {
              throw new Error('Errore nel caricamento della traccia audio');
          }
          return response.blob();
      })
      .then(blobData => { // ricezione dei dati blob
          if (blobData.size === 0) {
              throw new Error('Nessun dato audio ricevuto');
          }
          // Carica la traccia audio nel player
          loadTrackFromBlob(blobData);
      })
      .catch(error => {
          console.error('Errore nel caricamento della traccia audio:', error);
      });
}


// Funzione per caricare una traccia audio dalla forma blob
function loadTrackFromBlob(blobData) {
  let blobUrl = URL.createObjectURL(blobData);

  curr_track.src = blobUrl;
  curr_track.load();
  
  curr_track.addEventListener('loadedmetadata', () => {
    playTrack(); 
    let durationMinutes = Math.floor(curr_track.duration / 60);
    let durationSeconds = Math.floor(curr_track.duration - durationMinutes * 60);
    if (durationSeconds < 10) { durationSeconds = "0" + durationSeconds; }
    if (durationMinutes < 10) { durationMinutes = "0" + durationMinutes; }
    total_duration.textContent = durationMinutes + ":" + durationSeconds;
  });
}


function playpauseTrack(element) {
  let episodeId = element.getAttribute('data-episode-id');

  if (!isPlaying) {
    if (!curr_track.src) {
      loadAudioTrack(episodeId);
      incrementEpisodeStreams(episodeId)
    }
    playTrack();

    // Mostra il minutaggio quando si clicca su play
    curr_time.classList.remove('hidden');
    total_duration.classList.remove('hidden');

    // Cambia l'icona del bottone a pausa
    element.innerHTML = '<i class="fa fa-pause-circle fa-5x"></i>';
  } else {
    pauseTrack();

    // Cambia l'icona del bottone a play
    element.innerHTML = '<i class="fa fa-play-circle fa-5x text-dark"></i>';
  }
}

function playTrack() {
  curr_track.play()
    .then(() => {
      isPlaying = true;
      updateTimer = setInterval(seekUpdate, 1000); // Avvia l'aggiornamento del seek slider e del tempo trascorso
    })
    .catch(error => {
      console.error('Errore durante la riproduzione:', error);
    });
}

function pauseTrack() {
  curr_track.pause();
  isPlaying = false;
  clearInterval(updateTimer); // Interrompe l'aggiornamento del seek slider e del tempo trascorso
}

function seekTo() {
  // Calculate the seek position by the percentage of the seek slider
  let seekto = curr_track.duration * (seek_slider.value / 100);
 
  // Set the current track position to the calculated seek position
  curr_track.currentTime = seekto;
}

function setVolume() {
  // Set the volume according to the percentage of the volume slider set
  curr_track.volume = volume_slider.value / 100;
}

function seekUpdate() {
  let seekPosition = 0;
  // Check if the current track duration is a legible number
  if (!isNaN(curr_track.duration)) {
      seekPosition = curr_track.currentTime * (100 / curr_track.duration);
      seek_slider.value = seekPosition;
 
      // Calculate the time left and the total duration
      let currentMinutes = Math.floor(curr_track.currentTime / 60);
      let currentSeconds = Math.floor(curr_track.currentTime - currentMinutes * 60);
      let durationMinutes = Math.floor(curr_track.duration / 60);
      let durationSeconds = Math.floor(curr_track.duration - durationMinutes * 60);
 
      // Add a zero to the single digit time values
      if (currentSeconds < 10) { currentSeconds = "0" + currentSeconds; }
      if (durationSeconds < 10) { durationSeconds = "0" + durationSeconds; }
      if (currentMinutes < 10) { currentMinutes = "0" + currentMinutes; }
      if (durationMinutes < 10) { durationMinutes = "0" + durationMinutes; }
 
      // Display the updated duration
      curr_time.textContent = currentMinutes + ":" + currentSeconds;
      total_duration.textContent = durationMinutes + ":" + durationSeconds;
  }
}
// Aggiorna continuamente il seek slider e il tempo trascorso durante la riproduzione
curr_track.addEventListener('timeupdate', seekUpdate);

// Funzione per incrementare gli ascolti dell'episodio
// Funzione per incrementare gli ascolti dell'episodio utilizzando fetch
function incrementEpisodeStreams(episodeId) {
  let url = '/Jampod/Episode/incrementEpisodeStreams/' + episodeId;

  fetch(url, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Errore durante l\'incremento degli ascolti');
    }
    console.log('Ascolti incrementati con successo per l\'episodio:', episodeId);
  })
  .catch(error => {
    console.error('Errore durante l\'incremento degli ascolti:', error);
  });
}





// COMMENTS
let commentContainer = document.getElementById("comment-container");

function createInputBox(commentUsername, commentText) {
    // Rimuove eventuali form di risposta già esistenti 
    let existingForm = document.querySelector(".comment-details"); 
    if (existingForm) {
        existingForm.remove();
    }

    let div = document.createElement("div");
    div.setAttribute("class", "comment-details mt-3"); // Imposta la classe della div

    let prefix = `In risposta a @${commentUsername}: ${commentText}\n`;

    div.innerHTML += `
        <form action="DA SELEZIONARE" method="post" class="comment-form">
            <div class="form-group">
                <div class="form-control-plaintext" style="white-space: pre-wrap;">${prefix}</div>
                <textarea class="form-control" style="resize: none;" name="replyComment" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-outline-success submit mt-2">Post Reply</button>
        </form>`;

    return div;
}

commentContainer.addEventListener("click", function (e) {
    e.preventDefault();  // Previene il comportamento predefinito

    let replyClicked = e.target.classList.contains("reply"); //verifica che abbia la classe reply, cioè che sia il bottone reply
    let closestCard = e.target.closest(".card"); //trova la card più vicina

    if (replyClicked) {
        let commentUsername = closestCard.querySelector('.text-primary').innerText;
        let commentText = closestCard.querySelector('.comment-text').innerText;

        let inputBox = createInputBox(commentUsername, commentText);
        closestCard.appendChild(inputBox);

        // Combina il prefisso e il commento dell'utente prima del submit
        let commentForm = inputBox.querySelector(".comment-form"); //seleziona il form di risposta appena creato
        commentForm.addEventListener("submit", function () {
            let userComment = commentForm.querySelector('textarea[name="replyComment"]').value;
            commentForm.querySelector('textarea[name="replyComment"]').value = `In risposta a @${commentUsername}: ${commentText}\n` + userComment;
            //Nel server accedo alla reply con  $_POST['replyComment'].
        });
    }
});

