{include file="Smarty/templates/header.tpl" username=$username}

    

    <!--sezione i miei podcast-->
    <div class="page-body">
        <div class="container-xl">
            <!--username-->
            <h1 class="text mb-5">{$username}</h1>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
                {foreach $userPodcasts item=podcast}
                    <div class="col">
                        <div class="card">
                            <a href="/Jampod/Podcast/visitPodcast/{podcast->getId}" class="d-block aspect-ratio-1x1">
                                <img src="data:{$podcast->getImageMimeType};base64,{$podcast->getImageData}" class="card-img-top" alt="{$podcast->getPodcastName}">  
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{$podcast->getPodcastName}</h5>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>


{include file="Smarty/templates/footer.tpl"}