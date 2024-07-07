{include file="Smarty/templates/header.tpl" username=$username}

   <div class="card">
    <div class="container" style="margin-top: 5%; margin-bottom: 5%;">
        <h1 class="mb-4">Crea un nuovo episodio</h1>
        <div class="row">

            <!-- Colonna sinistra: form per titolo e descrizione -->
            <div class="col-md-6">
                <form method="post" enctype="multipart/form-data" action="/Jampod/Episode/uploadEpisode/{$podcast_id}">
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Titolo dell'episodio</label>
                        <input name = "title" type="text" class="form-control" id="inputTitle" placeholder="Inserisci il titolo">
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label">Descrizione dell'episodio</label>
                        <textarea name = "description" style="resize: none;" class="form-control" id="inputDescription" rows="3" placeholder="Inserisci la descrizione" maxlength="200"></textarea>
                    </div>

                    <!-- Colonna destra: form per cover e traccia audio -->
                    <div class="mb-3">
                        <label for="inputCover" class="form-label">Foto di copertina dell'episodio</label>
                        <input name = "imagefile" type="file" class="form-control" id="inputCover">
                    </div>
                    <div class="mb-3">
                        <label for="inputAudio" class="form-label">Traccia audio dell'episodio</label>
                        <input name = "audiofile" type="file" class="form-control" id="inputAudio">
                    </div>
                    
                    <!-- Bottone per salvare l'episodio -->
                    <div class="row mt-3">
                        <div class="col-lg-8">
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Salva episodio</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{include file="Smarty/templates/footer.tpl"}