<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Podcast Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Admin Dashboard</h1>
            <button class="btn btn-secondary">Logout</button>  
        </div>
        <ul class="nav nav-tabs mt-4" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="true">Utenti</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="podcasts-tab" data-bs-toggle="tab" data-bs-target="#podcasts" type="button" role="tab" aria-controls="podcasts" aria-selected="false">Podcast</button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="adminTabsContent">
            <!-- Users Tab -->
            <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                <h2>Utenti</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $users as $user}
                        <tr>
                            <td>{$user.username}</td>
                            <td>{$user.email}</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Banna</button>
                                <button class="btn btn-danger btn-sm">Elimina</button>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>

            <!-- Podcasts Tab -->
            <div class="tab-pane fade" id="podcasts" role="tabpanel" aria-labelledby="podcasts-tab">
                <h2>Podcast</h2>
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
                            <td>{$podcast.name}</td>
                            <td>{$podcast.author}</td>
                            <td>
                                <button class="btn btn-danger btn-sm">Elimina</button>
                                <button class="btn btn-info btn-sm" data-bs-toggle="collapse" data-bs-target="#episodes{$podcast.id}" aria-expanded="false" aria-controls="episodes{$podcast.id}">Visualizza Episodi</button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="collapse" id="episodes{$podcast.id}">
                                    <h3 class="mt-2">Episodi del {$podcast.name}</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Titolo</th>
                                                <th>Durata</th>
                                                <th>Azioni</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {foreach $podcast.episodes as $episode}
                                            <tr>
                                                <td>{$episode.title}</td>
                                                <td>{$episode.duration}</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm">Elimina</button>
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="collapse" data-bs-target="#comments{$episode.id}" aria-expanded="false" aria-controls="comments{$episode.id}">Visualizza Commenti</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="collapse" id="comments{$episode.id}">
                                                        <h4 class="mt-2">Commenti all'Episodio {$episode.title}</h4>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Utente</th>
                                                                    <th>Commento</th>
                                                                    <th>Azioni</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {foreach $episode.comments as $comment}
                                                                <tr>
                                                                    <td>{$comment.user}</td>
                                                                    <td>{$comment.text}</td>
                                                                    <td>
                                                                        <button class="btn btn-danger btn-sm">Elimina</button>
                                                                    </td>
                                                                </tr>
                                                                {/foreach}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            {/foreach}
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
