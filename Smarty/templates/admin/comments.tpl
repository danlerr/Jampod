<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Commenti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Jampod Admin Dashboard</h1>
            <a href="/Jampod/User/logout" class="btn btn-secondary">Logout</a>  
        </div>
        
        <!-- Comments Section -->
        <h2>Commenti dell'Episodio {$episode->getEpisode_title()}</h2>
            {if count($comments) == 0}
                <h4 class=" mt-3  text-center">Nessun commento.</h4>
            {/if}
        <table class="table">
            
            <thead>
                <tr>
                    <th>Utente</th>
                    <th>Commento</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                {foreach $comments as $comment}

                <tr>
                    <td>{$comment->getCommetUsername()}</td>
                    <td>{$comment->getCommentText()}</td>
                    <td>
                        <a href="/Jampod/Moderation/deleteComment/{$comment->getId()}" class="btn btn-danger btn-sm">elimina</a>
                    </td>
                </tr>

                {/foreach}
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>