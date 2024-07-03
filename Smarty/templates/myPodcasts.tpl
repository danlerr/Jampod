{include file="Smarty/templates/header.tpl"}

<!--alert-->
    {if isset($textalert) && $textalert}
        {if $success}
            {include file="Smarty/templates/successAlert.tpl"}
        {else}
            {include file="Smarty/templates/failAlert.tpl"}
        {/if}
    {/if}

    <!--bottone per creare un nuovo podcast-->
    <div class="d-grid gap-2" style="margin-top: 1%;">
        <div class="mt-3 d-flex justify-content-center">
            <a href="/Jampod/Podcast/creationForm" class="btn btn-primary">Crea podcast</a>
        </div>
    </div>

    <!--sezione i miei podcast-->
    <div class="page-body">
        <div class="container-xl">
            <h2 class="text mb-5">I miei podcast</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
                {foreach $userPodcasts item=podcast}
                    <div class="col">
                        <div class="card">
                            <a href="Jampod/Podcast/{podcast.podcast.id}" class="d-block aspect-ratio-1x1">
                                <img src="data:{$mimetype};base64,{$imagedata}" class="card-img-top" alt="{$podcast.podcast_name}">  
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{$podcast.podcast_name}</h5>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>


{include file="Smarty/templates/footer.tpl"}