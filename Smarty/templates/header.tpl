<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Jampod</title>
    <!-- CSS files -->
    <link href="/Jampod/Smarty/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/demo.min.css" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/style.css" rel="stylesheet"/>
	  <link href="/Jampod/Smarty/dist/css/style1.css" rel="stylesheet"/>
    <link href="/Jampod/Smarty/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/comments-forms/comment-form-1/assets/css/comment-form-1.css" />
	  <link href="/Jampod/Smarty/dist/libs/star-rating.js/dist/star-rating.min.css?1692870487" rel="stylesheet"/>
    
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
    <div class="page">
    <!-- Navbar 1-->
	  <header class="navbar navbar-expand-md d-print-none" >
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
		      <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
			      <a href="/Jampod/Home/homePage" style="text-decoration: none; display: flex; align-items: center;">
			        <img src="/Jampod/Smarty/images/logo.png" style="width: 80px; height: auto;" alt="Tabler" class="navbar-brand-image">
			        <span class="ms-1 fw-bold " style="font-size: 1.70rem;">Jampod</span>
			      </a>
		      </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">
                
              </div>
            </div>
            
			<!--icona profilo-->
            <div class="nav-item dropdown">
				      <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <div><img src="/Jampod/Smarty/images/user.svg" alt=""></div>
                <div class="d-none d-xl-block ps-2">
                  <div>{$username}</div>
                </div>
				      </a>
				      <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					      <a href="/Jampod/Podcast/myPodcast" class="dropdown-item">I miei podcast</a>
					      <a href="/Jampod/Balance/viewBalance" class="dropdown-item">Saldo</a>
					      <div class="dropdown-divider"></div>
					      <a href="/Jampod/User/settings" class="dropdown-item">Impostazioni</a>
                {if $isAdmin}
                  <a href="/Jampod/Moderation/showDashboard" class="dropdown-item">Dashboard admin</a>
                {/if} 
					      <a href="/Jampod/User/logout" class="dropdown-item">Logout</a>
				      </div>
			      </div>
          </div>
        </div>
		
    </header>

  <!-- Navbar 2-->
	  <header class="navbar-expand-md">
      <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
              <div class="container-xl d-flex justify-content-center">
                  <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                      <form action="/Jampod/Podcast/searchPodcasts" method="post" autocomplete="off" novalidate>
                          <div class="input-icon">
                              <span class="input-icon-addon">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                      <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/>
                                      <path d="M21 21l-6 -6"/>
                                  </svg>
                              </span>
                              <input type="text" name="query" class="form-control" placeholder="Search Podcasts…" aria-label="Search in website">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </header>