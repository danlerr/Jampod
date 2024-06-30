{include file="header.tpl" pageTitle=""}

    <!--bottone per creare un nuovo podcast-->
    <div class="d-grid gap-2" style="margin-top: 1%;">
        <div class="mt-3 d-flex justify-content-center">
            <a href="creazionePodcast.html" class="btn btn-primary">Crea podcast</a>
        </div>
    </div>

    <!--sezione i miei podcast-->
    <div class="page-body">
        <div class="container-xl">
            <h2 class="text mb-5">I miei podcast</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5 g-4">
                {foreach $userPodcasts as $index => $podcast}
                    <div class="col">
                        <div class="card">
                            <a href="podcast.php?id={$podcast.id}" class="d-block aspect-ratio-1x1">
                                <img src="{podcast_(/.)imageeeeeeeeeeeeeeeeeeeeeeee}" class="card-img-top" alt="...">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{$podcast.title}</h5>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>


{include file="footer.tpl"}