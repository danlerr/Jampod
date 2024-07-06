{include file="Smarty/templates/header.tpl" username=$username}

    <!--sezione i miei podcast-->
    <div class="page-body">
        <div class="container-xl">
            <h2 class="text mb-5">{$category_name}</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
                {foreach $category_podcasts item=podcast}
                    <div class="col">
                        <div class="card">
                            <a href="/Jampod/Podcast/visitPodcast/{$podcast.podcast_id}" class="d-block aspect-ratio-1x1">
                                <img src="data:{$podcast.image_mimetype};base64,{$podcast.image_data}" class="card-img-top" alt="$podcast.podcast_name">  
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