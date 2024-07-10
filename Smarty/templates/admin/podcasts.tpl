<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Podcast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Jampod Admin Dashboard</h1>
            <a href="/Jampod/User/logout" class="btn btn-secondary">Logout</a>  
        </div>
        
        <!-- Podcasts Section -->
        
        <h2>Podcasts di {$user->getUsername()}</h2>
        {if count($podcasts) == 0}
            <h4 class=" mt-3  text-center">Nessun podcast.</h4>
        {/if}

        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Autore</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                {foreach $podcasts as $podcast}
                
                <tr>
                    <td>{$podcast.podcast_name}</td>
                    
                    <td>
                        <a href="/Jampod/Moderation/deletePodcast/{$podcast.podcast_id}" class="btn btn-danger btn-sm">elimina</a>
                        <a href="/Jampod/Moderation/showEpisodePodcasts/{$podcast.podcast_id}" class="btn btn-info btn-sm">Visualizza Episodi</a>
                    </td>
                </tr>

                {/foreach}
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>