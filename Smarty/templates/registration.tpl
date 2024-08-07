<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Jampod</title>
    <!-- CSS files -->
    <link href="/Jampod/Smarty/dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/demo.min.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
        font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body class="d-flex flex-column">
    <script src="/Jampod/Smarty/dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <img src="/Jampod/Smarty/images/logo.svg" alt="Jampod" style="width: 120px; height: auto; margin-left: 5px;">
          <h1>Jampod</h1>
        </div>
        <form id="registration" class="card card-md" action="/Jampod/User/registration" method="post" autocomplete="off" >
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Crea nuovo account</h2>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input name = "username" type="text" class="form-control" placeholder="Inserire lo username">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input name = "email" type="email" class="form-control" placeholder="Inserire l'email">
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <div class="input-group input-group-flat">
                <input name = "password" type="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
                <span class="input-group-text">
                  <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip" onclick="togglePasswordVisibility()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                      <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                    </svg>
                  </a>
                </span>
              </div>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-dark w-100">Crea un nuovo account</button>
            </div>
          </div>
        </form>
        <div class="text-center text-secondary mt-3">
          Hai già un account? <a href="/Jampod/User/loginForm" tabindex="-1">Login</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="/Jampod/Smarty/dist/js/tabler.min.js?1692870487" defer></script>
    <script src="/Jampod/Smarty/dist/js/demo.min.js?1692870487" defer></script>
    <script>
      function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
      }
    </script>
  </body>
</html>
