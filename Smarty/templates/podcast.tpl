{include file="Smarty/templates/header.tpl" username=$username}

{nocache}

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
        {include file="Smarty/templates/successAlert.tpl"  textalert=$textalert}
    {else}
        {include file="Smarty/templates/failAlert.tpl"  textalert=$textalert}
    {/if}
{/if}

<!--podcast-->
	  <div class="page-body">
        <div class="container-xl">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="text mb-0">{$podcast->getPodcastName()}</h1>
                <span class="badge small-badge">{$podcast->getSubscribeCounter()} iscritti</span>
            </div>
            <h3 class="text mb-1">{$podcast_creator}</h3>
            <small class="text mb-5">{$podcast->getPodcastCategory()}</small>
            <h4 class="text mb-5 mt-5">Descrizione:{$podcast->getPodcastDescription()}</h4>
            
            <div class="podcast-container">
                <!-- Copertina del podcast -->
                <div class="podcast-cover">
                    <a href="#" class="d-block aspect-ratio-1x1">
                        <img src="data:{$podcast->getImageMimeType()};base64,{$podcast->getEncodedImageData()}" alt="Copertina podcast">
                    </a>
                </div>

                <!-- Lista degli episodi -->
                
                <div class="podcast-episodes">
                    <div class="card2">
                        <div class="list-group card-list-group">
                        {if $episodes|@count == 0}
                            <p>Nessun episodio disponibile.</p>
                        {else}
                            {foreach from=$episodes item=episode}
                                <div class="list-group-item">
                                    <div class="row g-2 align-items-center">
                                    <a href="/Jampod/Episode/visitEpisode/{$episode->getId()}" style="text-decoration: none; color: inherit;">
                                        <div class="col-auto fs-3">
                                            {$episode->getEpisode_title()}
                                        </div>
                                   
                                        <div class="col-auto">
                                            <img src="data:{$episode->getImageMimeType()};base64,{$episode->getEncodedImageData()}" class="rounded" alt="{$episode->getEpisode_title}" width="40" height="40">
                                        </div>
                                        <div class="col">
                                            
                                                {$episode->getEpisode_title()}
                                            
                                        </div>
                                        <div class="col-auto text-secondary">
                                            {$episode->getTimeToStr()}
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
                                                    <a class="dropdown-item" href="/Jampod/Episode/delete/{$episode->getId()}">Elimina</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                </div>
                                            </div>
                                        </div>
                                     </a>
                                    </div>
                                </div>
                            {/foreach}
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bottone in base al ruolo dell'utente -->
        <div class="mt-3 d-flex flex-column align-items-center">
                    {if $userRole == 'creator'}
                        <a href="/Jampod/Episode/creationEpisodeForm/{$podcast->getId()}" class="btn btn-primary">Crea un nuovo episodio</a>
                        <a href="/Jampod/Podcast/deletePodcast/{$podcast->getId()}" class="btn btn-danger mt-2">Elimina podcast</a>
                    {else}
                        {if $sub == false}
                            <a href="/Jampod/Podcast/Subscribe/{$podcast->getId()}" class="btn btn-primary">Iscriviti al podcast</a>
                        {else}
                            <a href="/Jampod/Podcast/Unsubscribe/{$podcast->getId()}" class="btn btn-primary">Iscritto</a>
                        {/if}
                    {/if}
    </div>

{/nocache}
{include file="Smarty/templates/footer.tpl"}