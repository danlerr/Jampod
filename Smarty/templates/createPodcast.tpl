{include file="header.tpl"}

<!-- Form crea un nuovo episodio -->
<div class="card">
    <div class="container" style="margin-top: 5%;margin-bottom: 5%;">
        <h1 class="mb-4">Crea un nuovo podcast</h1>
        <div class="row">
            <form method="post" enctype="multipart/form-data" action="/Jampod/Podcast/createPodcast"> <!-- Unico form -->
                <!-- Colonna sinistra: form per titolo e descrizione -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Titolo del podcast</label>
                        <input name='podcast_name' type="text" class="form-control" id="inputTitle" placeholder="Inserisci il titolo" maxlength="38">
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label">Descrizione del podcast</label>
                        <textarea name='podcast_description' style="resize: none;" class="form-control" id="inputDescription" rows="3" placeholder="Inserisci la descrizione" maxlength="200"></textarea>
                    </div>
                </div>

                <!-- Colonna destra: form per cover e categoria -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="inputCover" class="form-label">Foto di copertina del podcast</label>
                        <input name='imagefile' type="file" class="form-control" id="inputCover">
                    </div>
                    <div class="mb-3">
                        <label for="categorySelect" class="form-label">Categoria</label>
                        <select name='podcast_category' class="form-select" id="categorySelect" aria-label="Seleziona una categoria">
                            <option selected>Seleziona una categoria</option>
                            <option value="1">Tecnologia</option>
                            <option value="2">Scienza</option>
                            <option value="3">Arte</option>
                            <option value="4">Sport</option>
                            <option value="5">Musica</option>
                        </select>
                    </div>
                </div>
                
                <!-- Bottone per salvare il podcast -->
                <div class="row mt-3">
                    <div class="col-lg-8">
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Salva podcast</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{include file="footer.tpl"}