

//PARTE PLAYER
// Select all the elements in the HTML page
// and assign them to a variable

let playpause_btn = document.querySelector(".playpause-track");
let seek_slider = document.querySelector(".seek_slider");
let volume_slider = document.querySelector(".volume_slider");
let curr_time = document.querySelector(".current-time");
let total_duration = document.querySelector(".total-duration");

// Specify globally used values
let isPlaying = false;
let updateTimer;

// Create the audio element for the player
let curr_track = document.createElement('audio');

// Funzione per caricare e riprodurre la traccia audio dal backend
function loadAndPlayAudioTrack(episodeId) {
  fetch('/api/listenAudio/' + episodeId)
      .then(response => {
          if (!response.ok) {
              throw new Error('Errore nel caricamento della traccia audio');
          }
          return response.blob();
      })
      .then(blobData => {
          // Carica la traccia audio nel player
          loadTrackFromBlob(blobData);
      })
      .catch(error => {
          console.error('Errore nel caricamento della traccia audio:', error);
      });
}

// Funzione per caricare la traccia audio dal blob
function loadTrackFromBlob(blobData) {
  // Crea un URL oggetto per il blob
  let blobUrl = URL.createObjectURL(blobData);

  // Imposta la traccia audio corrente nel player
  curr_track.src = blobUrl;
  curr_track.load();


}



// Function to reset all values to their default
function resetValues() {
  curr_time.textContent = "00:00";
  total_duration.textContent = "00:00";
  seek_slider.value = 0;
}

// Function to play or pause the track
function playpauseTrack() {
  if (!isPlaying) {
      playTrack();
  } else {
      pauseTrack();
  }
}

function playTrack() {
  // Play the loaded track
  curr_track.play();
  isPlaying = true;
 
  // Replace icon with the pause icon
  playpause_btn.innerHTML = '<i class="fa fa-pause-circle fa-5x"></i>';
}

function pauseTrack() {
  // Pause the loaded track
  curr_track.pause();
  isPlaying = false;
 
  // Replace icon with the play icon
  playpause_btn.innerHTML = '<i class="fa fa-play-circle fa-5x"></i>';
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




//PARTE COMMENTI
let commentContainer = document.getElementById("comment-container");

function createInputBox() { 
    let div = document.createElement("div"); 

    div.setAttribute("class", "comment-details"); 

    div.innerHTML += `<form action="da scegliere..." method="post" class="comment-form">
                        <textarea class="form-control" style="resize: none;" name="comment" rows="3" required></textarea>
                        <button type="submit" class="btn btn-outline-success submit mt-2">Post Reply</button>
                      </form>`; 
    return div; 
} 

function addReply(text) { 
    let div = document.createElement("div"); 

    div.setAttribute("class", "all-comment"); 
    
    div.innerHTML += `<div class="card p-2"> 
                      <div class="d-flex justify-content-between align-items-start">
                          <div class="user d-flex flex-column">
                          <span>
												<small class="fw-bold text-primary">utentecherisponde</small>
											    </span>
                              <span class="comment-text">
                                  <small class="fw-bold">${text}</small> 
                              </span>
                              <small class="ml-auto">Just now</small>
                          </div>
                          <div class="reply px-0">
                              <a href="#" class="btn btn-outline-success reply">Reply</a>
                          </div>
                      </div>
                  </div>`; 
    return div; 
} 

commentContainer.addEventListener("click", function (e) { 
    e.preventDefault();  // Previene il comportamento predefinito

    let replyClicked = e.target.classList.contains("reply"); 
    let submitClicked = e.target.classList.contains("submit"); 
    let closestCard = e.target.closest(".all-comment"); 

    if (replyClicked) { 
        closestCard.appendChild(createInputBox()); 
    } 

    if (submitClicked) { 
        const commentDetails = e.target.closest(".comment-details"); 
        const commentForm = commentDetails.querySelector('.comment-form');
        
        // Invia il modulo al server
        commentForm.submit();
        
        // Aggiungi il commento localmente
        if (commentForm.children[0].value) { 
            closestCard.appendChild(addReply(commentForm.children[0].value)); 
            commentDetails.remove(); 
        }
    } 
});
