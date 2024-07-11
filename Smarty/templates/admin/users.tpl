<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Utenti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <a href="/Jampod/Moderation/showDashboard" class="display-4 text-decoration-none text-dark">Jampod Admin Dashboard</a>  
            
            <a href="/Jampod/User/logout" class="btn btn-secondary">Logout</a>  
        </div>
        
        <!-- Users Section -->
        <h4>Utenti</h4>
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
                        <a href="/Jampod/Moderation/deleteUser/{$user.user_id}" class="btn btn-danger btn-sm">elimina</a>
                        <a href="/Jampod/Moderation/showUserPodcasts/{$user.user_id}" class="btn btn-info btn-sm">visualizza Podcast</a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>