
{include file="Smarty/templates/header.tpl" username=$username}
	   <!-- episode -->
	

	   <h3 class="fw-bold text-center mt-2" id="albumTitle">{$podcast_title}</h3>
	   <div class="episode-container ">
		 <div class="row justify-content-center gx-3 ms-3">  <!-- Centra la parte dell'episodio -->
			 <!-- Colonna sinistra per l'immagine del podcast e il titolo -->
			 <div class="col-lg-4 col-md-4 align-self-center">
				 <div class="text-center">
					 <img src="data:{$mimetype};base64,{$imagedata}" alt="Episode image" class="media-album-icon">
				 </div>
				 
			 </div>
			 <!-- Colonna destra per le informazioni sull'episodio e il player audio -->
			 <div class="col-lg-8 col-md-8">
			   
				 <header class="text-center">
					<!-- Titolo dell'episodio -->
          
					<h3 class="h4 mb-2">{$episode_title}</h3> <!-- max 38 caratteri -->
        
					<!-- Autore -->
					<small class="text-muted">{$usernamecreator}</small>
					 <div class="player">
		  
						 <!-- Define the section for displaying track buttons -->
						 <div class="buttons">
						   
						   <div class="playpause-track" onclick="playpauseTrack()">
							<div class="playpause-track" data-episode-id= {$episode_id} onclick="playpauseTrack(this)"> <!-- this si riferisce all'elemento html playpause-->

							 <i class="fa fa-play-circle fa-5x text-dark "></i>
						   </div>
						   
						 </div>
					  
						 <!-- Define the section for displaying the seek slider-->
						 <div class="slider_container">
						   <div class="current-time">00:00</div>
						   <input type="range" min="1" max="100"
							 value="0" class="seek_slider" onchange="seekTo()">
						   <div class="total-duration">00:00</div>
						 </div>
					  
						 <!-- Define the section for displaying the volume slider-->
						 <div class="slider_container ">
						   <i class="fa fa-volume-down"></i>
						   <input type="range" min="1" max="100"
							 value="99" class="volume_slider" onchange="setVolume()">
						   <i class="fa fa-volume-up" ></i>
						 </div>
					   </div>
					  
				 </header>			 
			 </div>		 
		 </div>

	 </div>

	 <!-- Donation, vote and save -->
	 <div class="container">
		<div class="row text-center">
			<div class="col  d-flex justify-content-end align-items-center  ">
				<div class="svg-container text-center mt-2">
					<!-- Replace 'image.svg' with your SVG image file -->
					<img src="/Smarty/images/headphones.svg" alt="SVG Image" style="max-width: 50px; vertical-align: bottom;">
					<!-- Replace 'Your Number' with your chosen number -->
					<span class="ml-2 h6" style="vertical-align: bottom;">{$episode_streams}</span>
				</div>
			</div>
			<div class="col">
				<div class="d-flex justify-content-center align-items-center mt-2">
					<form action="/Jampod/Episode/voteEpisode/{$episode->getId()}" method="post" class="comment-form">
						<select id="rating-default" class="form-select" name="rating" style="display:none;">
							<option value="">Select a rating</option>
							<option value="5">Excellent</option>
							<option value="4">Very Good</option>
							<option value="3">Average</option>
							<option value="2">Poor</option>
							<option value="1">Terrible</option>
						</select>
						<button type="submit" style="display:none;">Submit</button>
					</form>
					<h3 class="h6 mb-0" style="margin-top: 0px;">{$avgVote}</h3>
				</div>
			</div>
			<input type="hidden" id="user-rating" value="{$votevalue|default:0}">

			<div class="col d-flex justify-content-start align-items-center" >
				<a href="donation.html" class="link-secondary">
					<img class="currency-icon  mt-2 " src="/Jampod/Smarty/images/currency-dollar.svg" alt="Currency Dollar Icon">
				</a>
				
			</div>
		</div>
	</div>
	
	





	 <!-- episode description-->
	<div class="episode-description-container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold">Descrizione dell'episodio</h5>
                    <p class="card-text">{$episode_description}</p>
                </div>
            </div>
        </div>
    </div>
</div>


    
	  <!-- Comment -->
	  <section class="bg-white py-3 py-md-4">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
					<h2 class="mb-3 mt-3 display-5 text-center">Fai un commento!</h2> <!-- Modificato mb-4 in mb-3 -->

					
					
					<!-- Post comment -->
					<form id="postcomment" action="/Jampod/Comment/createComment{$episode->getId()}" method="post">
						<div class="row gy-3 gy-xl-4 p-3 p-xl-4"> <!-- Modificato gy-4 in gy-3 e p-4 in p-3 -->
							<div class="col-12">
								<label for="comment" class="form-label">Commento</label>
								<!-- Form per pubblicare un commento -->
								<textarea class="form-control"   style = "resize: none;"  id="comment" rows="3" required></textarea>
								<!-- fine form per pubblicare un commento -->
							</div>
							<div class="col-12">
								<div class="d-grid">
									<button class="btn btn-dark btn-lg" type="submit">Post</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	
<!-- Box che mostra il commento -->
<div class="container mt-4"> 
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <!-- Card commento -->
            <div class="container">
                <div id="comment-container" class="comment-container"> <!-- Id del comment container passato a js -->
                    {foreach from=$commentAndReplies item=commentWithReplies}
                        {include file='comment.tpl' comment=$commentWithReplies.0 replies=$commentWithReplies.1}
                    {/foreach}
                </div>
            </div>
            <!-- fine card commento -->
        </div>
    </div>
</div>

		
		
		
	</section>




{include file="Smarty/templates/footer.tpl"}


 <!-- Script JS per lo star rating.  StarRating è inizializzato sul selettore #rating-default, che è il <select> HTML nel form. -->
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const userRating = document.getElementById('user-rating').value;
			const ratingSelect = document.getElementById('rating-default');
	
			// Imposta il valore del selettore in base al valore del voto dell'utente
			if (userRating) {
				ratingSelect.value = userRating;
			}
	
			// Inizializza il sistema di stelle
			const rating = new StarRating('#rating-default', {
				tooltip: false, 
				clearable: false,
				stars: function (el, item, index) {
					el.innerHTML = `<!-- Download SVG icon from http://tabler-icons.io/i/star-filled --><svg xmlns="http://www.w3.org/2000/svg" class="icon gl-star-full icon-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor" /></svg>`;
				},
			});
	
			// Colora le stelle in base al valore del selettore
			if (userRating > 0) {
				rating.setRating(userRating);
			} else {
				rating.setRating(0); // Assicura che le stelle siano vuote se il voto è 0
			}
	
			// Aggiungi il listener per il click sulle stelle
			const stars = document.querySelectorAll('.gl-star-full');
			stars.forEach((star, index) => {
				star.addEventListener('click', function (event) {
					event.preventDefault();  // Previene il comportamento predefinito del click
					const value = stars.length - index;
					ratingSelect.value = value;
					// Simulazione di submit del form quando l'utente clicca sulla stella
					ratingSelect.form.submit();
				});
			});
		});
	</script>
	
	  