<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Episodi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Jampod Admin Dashboard</h1>
            <a href="/Jampod/User/logout" class="btn btn-secondary">Logout</a>  
        </div>
        
        <!-- Episodes Section -->
        <h2>Episodi di {$podcast->getPodcastName()}</h2>
        {if count($episodes) == 0}
            <h4 class=" mt-3  text-center">Nessun episodio.</h4>
        {/if}
        <table class="table">
            <thead>
                <tr>
                    <th>Titolo</th>
                    <th>Durata</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                {foreach $episodes as $episode}

                <tr>
                    <td>{$episode->getEpisode_title()}</td>

                    <td>
                        <a href="/Jampod/Moderation/deleteEpisode/{$episode->getId()}" class="btn btn-danger btn-sm">elimina</a>
                        <a href="/Jampod/Moderation/showEpisodeComments/{$episode->getId()}" class="btn btn-info btn-sm">Visualizza Commenti</a>
                    </td>
                </tr>

                {/foreach}
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>