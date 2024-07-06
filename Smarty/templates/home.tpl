{include file="Smarty/templates/header.tpl" username=$username}

<!-- Podcast in evidenza -->
<div class="page-body">
    <div class="container-xl">
        <h2 class="text mb-5">Podcast in evidenza</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
            {foreach from=$featuredPodcasts item=podcast}
                <div class="col">
                    <div class="card">
                        <a href="/Jampod/Podcast/visitPodcast/{$podcast.podcast_id}" class="d-block aspect-ratio-1x1">
                            <img src="data:{$podcast.image_mimetype};base64,{$podcast.image_data}" class="card-img-top" alt="{$podcast.podcast_name}">
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

<!-- Categorie -->
<div class="page-body">
    <div class="container-xl">
        <h2 class="text mb-5">Categorie</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
            {foreach from=$categories item=category}
                <div class="col">
                    <a href="/Jampod/Home/visitCategory/{$category}" class="d-block aspect-ratio-1x1" style="text-decoration: none;">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="card-title">{$category}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            {/foreach}
        </div>
    </div>
</div>

<!-- Nuovi podcast -->
<div class="page-body">
    <div class="container-xl">
        <h2 class="text mb-5">Novità</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
            {foreach from=$newPodcasts item=podcast}
                <div class="col">
                    <div class="card">
                        <a href="/Jampod/Podcast/visitPodcast/{$podcast.podcast_id}" class="d-block aspect-ratio-1x1">
                            <img src="data:{$podcast.image_mimetype};base64,{$podcast.image_data}"class="card-img-top" alt="{$podcast.podcast_name}">
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

<!-- Ti potrebbe piacere -->
<div class="page-body">
    <div class="container-xl">
        <h2 class="text mb-5">Ti potrebbe piacere</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
            {foreach from=$recommendedPodcasts item=podcast}
                <div class="col">
                    <div class="card">
                        <a href="podcast{$podcast.podcast_id}" class="d-block aspect-ratio-1x1">
                            <img src="data:{$podcast.image_mimetype};base64,{$podcast.image_data}" class="card-img-top" alt="{$podcast.podcast_name}">
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