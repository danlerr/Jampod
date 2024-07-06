<?php
/* Smarty version 5.3.0, created on 2024-07-06 12:14:40
  from 'file:Smarty/templates/login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.3.0',
  'unifunc' => 'content_66891910541b70_00540945',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c33c1999199afd62e064349ab8f4500709395a28' => 
    array (
      0 => 'Smarty/templates/login.tpl',
      1 => 1720260879,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:Smarty/templates/failAlert.tpl' => 1,
  ),
))) {
function content_66891910541b70_00540945 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\Jampod\\Smarty\\templates';
?><!doctype html>
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
  <body>
    <?php echo '<script'; ?>
 src="/Jampod/Smarty/dist/js/demo-theme.min.js?1692870487"><?php echo '</script'; ?>
>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <img src="/Jampod/Smarty/images/logo.svg" alt="Jampod" style="width: 120px; height: auto; margin-left: 5px;">
          <h1>Jampod</h1>
        </div>
        <?php if ($_smarty_tpl->getValue('error')) {?>
          <?php $_smarty_tpl->renderSubTemplate("file:Smarty/templates/failAlert.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
        <?php }?>

        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Login</h2>
            <form id="login" action="/Jampod/User/login" method="post" autocomplete="off">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" autocomplete="off">
              </div>
              <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <div class="input-group input-group-flat">
                  <input type="password" id="password" name="password" class="form-control" placeholder="La tua password" autocomplete="off">
                  <span class="input-group-text">
                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip" onclick="togglePasswordVisibility()">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                      </svg>
                    </a>
                  </span>
                </div>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-dark w-100">Login</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center text-secondary mt-3">
          Non hai ancora un account? <a href="/Jampod/User/registrationForm" tabindex="-1">Registrati</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <?php echo '<script'; ?>
 src="/Jampod/Smarty/dist/js/tabler.min.js?1692870487" defer><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/Jampod/Smarty/dist/js/demo.min.js?1692870487" defer><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
      function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
      }
    <?php echo '</script'; ?>
>
  </body>
</html>
<?php }
}
