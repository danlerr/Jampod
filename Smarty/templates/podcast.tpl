{include file="Smarty/templates/header.tpl"}

<style>
      .podcast-container {
            display: flex;
            gap: 20px;
        }
        .podcast-cover {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 0 0 200px; /* Larghezza fissa per la colonna della copertina */
        }
        .podcast-cover img {
            width: 100%;
            max-width: 200px; /* Larghezza massima per la copertina */
            border-radius: 10px;
        }
        .podcast-episodes {
            flex: 1;
        }
        .podcast-episodes .card {
            width: 100%;
        }
        .small-badge {
            font-size: 1em; /* Modifica questa dimensione secondo necessità */
            background-color: #929dab; /* Colore di sfondo */
            color: white; /* Colore del testo */
            
        }
</style>

<!--alert-->
    {if isset($textalert) && $textalert}
        {if $success}
            {include file="Smarty/templates/successAlert.tpl"}
        {else}
            {include file="Smarty/templates/failAlert.tpl"}
        {/if}
    {/if}

<!--podcast-->
	  <div class="page-body">
        <div class="container-xl">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="text mb-0">{$podcast_name}</h1>
                <span class="badge small-badge">{$subscribeCounter} iscritti</span>
            </div>
            <h3 class="text mb-1">{$podcast_creator}</h3>
            <small class="text mb-5">{$podcast_category}</small>
            <h4 class="text mb-5 mt-5">Descrizione:{$podcast_description}</h4>
            
            <div class="podcast-container">
                <!-- Copertina del podcast -->
                <div class="podcast-cover">
                    <a href="#" class="d-block aspect-ratio-1x1">
                        <img src="data:{$mimetype};base64,{$imagedata}"" alt="Copertina podcast">
                    </a>
                </div>

                <!-- Lista degli episodi -->
                
                <div class="podcast-episodes">
                    <div class="card2">
                        <div class="list-group card-list-group">
                            {foreach from=$episodes item=episode}
                                <div class="list-group-item">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-auto fs-3">
                                            {$episode.episode_number}
                                        </div>
                                        <div class="col-auto">
                                            <img src="{$episode.image}" class="rounded" alt="{$episode.title}" width="40" height="40">
                                        </div>
                                        <div class="col">
                                            <a href="episodio{$episode.id}.html" style="text-decoration: none; color: inherit;">
                                                {$episode.title}
                                            </a>
                                        </div>
                                        <div class="col-auto text-secondary">
                                            {$episode.creationtime}
                                        </div>
                                        <div class="col-auto text-secondary">
                                            {$episode.duration}
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="link-secondary">
                                                <button class="switch-icon" data-bs-toggle="switch-icon">
                                                    <span class="switch-icon-a text-muted">
                                                        <img src="/Smarty/images/bookmark.svg" alt="Bookmark Icon">
                                                    </span>
                                                    <span class="switch-icon-b text-red">
                                                        <img src="/Smarty/images/bookmark-filled.svg" alt="Bookmark Icon">
                                                    </span>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-auto lh-1">
                                            <div class="dropdown">
                                                <a href="#" class="link-secondary" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                        <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                        <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Elimina</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            
        </div>
        <!-- Bottone in base al ruolo dell'utente -->
        <div class="row mt-3">
            <div class="col-lg-8">
                <div class="mt-3 d-flex justify-content-center">
                    {if $userRole == 'creator'}
                        <a href="creazioneEpisodio.html" class="btn btn-primary">Crea un nuovo episodio</a>
                    {else}
                        {if $sub == false}
                            <a href="iscrizionePodcast.html" class="btn btn-primary">Iscriviti al podcast</a>
                        {else}
                            <a href="iscrizionePodcast.html" class="btn btn-primary">Iscritto</a>
                        {/if}
                    {/if}
                </div>
            </div>
        </div>
    </div>


{include file="Smarty/templates/footer.tpl"}