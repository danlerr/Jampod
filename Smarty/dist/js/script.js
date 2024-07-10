

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
// COMMENTS
document.addEventListener("DOMContentLoaded", function() {
  let commentContainer = document.getElementById("comment-container"); // riferimento al comment container

  commentContainer.addEventListener("click", function(e) {
      e.preventDefault();
      
      // Gestisci il click sul pulsante "Reply"
      if (e.target.classList.contains("reply")) {
          let closestCard = e.target.closest(".card");  // Gestisce il click solo se l'elemento cliccato ha la classe "reply"
          if (closestCard) {
              let replyFormContainer = closestCard.querySelector(".replyFormContainer"); // riferimento al reply container della card più vicina trovata. 
              // Nascondi tutti i form di risposta attivi
              let allReplyForms = document.querySelectorAll(".replyFormContainer"); // seleziona tutti gli elementi che hanno la classe "replyFormContainer" (nodelist)
              allReplyForms.forEach(formContainer => {
                  formContainer.style.display = "none";
              });

              // Mostra solo il form di risposta del commento corrente
              replyFormContainer.style.display = "block";
              replyFormContainer.style.marginTop = "10px";

              let replyForm = replyFormContainer.querySelector("form"); // riferimento al form che si trova nel reply container
              let parentCommentId = closestCard.getAttribute("data-comment-id"); // id del commento a cui si risponde
              let episodeId = commentContainer.getAttribute("data-episode-id"); // id dell'episodio
              replyForm.querySelector("textarea").focus(); // sposta il cursore dell'utente nella form

              // Gestore di eventi al pulsante "Post Reply"
              let postReplyButton = replyForm.querySelector('.btn[type="button"]');
              postReplyButton.addEventListener("click", function(event) {
                  event.preventDefault(); // Previeni il submit predefinito

                  // Submit del form manualmente
                  let formData = new FormData(replyForm);
                  fetch(`/Jampod/Comment/createComment/${episodeId}/${parentCommentId}`, {
                      method: 'POST',
                      body: formData
                  })
                  .then(response => {
                      if (!response.ok) {
                          throw new Error('Network response was not ok');
                      }
                      // Esegui il redirect dopo il successo della richiesta
                      window.location.href = `/Jampod/Episode/visitEpisode/${episodeId}`;
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      // Gestisci l'errore in qualche modo, ad esempio mostrando un messaggio all'utente
                  });
              });
          }
      }

      // Gestisci il click sull'immagine SVG per eliminare il commento
      if (e.target.closest('.svg-trigger')) {
          // Impedisci l'azione di default
          e.preventDefault();

          let closestCard = e.target.closest(".card");
          if (closestCard) {
              let commentId = closestCard.getAttribute("data-comment-id");

              // Esegui qui la chiamata al backend per eliminare il commento
              fetch(`/Jampod/Comment/deleteComment/${commentId}`, {
                  method: 'GET' // Puoi usare 'GET' o 'DELETE' a seconda di come il backend gestisce la richiesta
              })
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  // Esegui il redirect o aggiorna l'interfaccia utente come necessario
                  window.location.href = `/Jampod/Episode/visitEpisode/${commentContainer.getAttribute("data-episode-id")}`;
              })
              .catch(error => {
                  console.error('Error:', error);
                  // Gestisci l'errore in qualche modo, ad esempio mostrando un messaggio all'utente
              });
          }
      }
  });
});
