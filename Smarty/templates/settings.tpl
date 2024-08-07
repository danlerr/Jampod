{include file="Smarty/templates/header.tpl" username=$username email=$email isAdmin=$isAdmin}
     {if isset($textalert) && $textalert}
        {if $success}
            {include file="Smarty/templates/successAlert.tpl"  textalert=$textalert}
        {else}
            {include file="Smarty/templates/failAlert.tpl"  textalert=$textalert}
        {/if}
    {/if}

<div class="page-wrapper">
  
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="row g-0">
          <div class="col-12 col-md-3 border-end">
            <div class="card-body">
              <div class="list-group list-group-transparent">
                <a href="/Jampod/User/settings" class="list-group-item list-group-item-action d-flex align-items-center active">Il mio Account</a>
                <a href="/Jampod/User/userCards" class="list-group-item list-group-item-action d-flex align-items-center">Carte di Credito</a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-9 d-flex flex-column">
            <div class="card-body">
              <h2 class="mb-4">Il mio Account</h2>
              <h3 class="card-title">Dettagli Profilo</h3>
              <h3 class="card-title mt-4">Email</h3>
              <div>
                <div class="row g-2">
                  <div class="col-auto">
                    <input type="text" class="form-control w-auto" value="{$email}" readonly>
                  </div>
                  <div class="col-auto">
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#changeEmailModal">Cambia Email</button>
                  </div>
                </div>
              </div>
              <h3 class="card-title mt-4">Username</h3>
              <div>
                <div class="row g-2">
                  <div class="col-auto">
                    <input type="text" class="form-control w-auto" value="{$username}" readonly>
                  </div>
                  <div class="col-auto">
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#changeUsernameModal">Cambia Username</button>
                  </div>
                </div>
              </div>
              <h3 class="card-title mt-4">Password</h3>
              <div>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#setpasswordModal">Cambia Password</button>
              </div>
              <div class="modal fade" id="setpasswordModal" tabindex="-1" aria-labelledby="ricaricaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="cambiapassword">Cambia password</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="/Jampod/User/editPassword">
                        <div class="mb-3">
                          <label for="vecchiapassword" class="form-label">Vecchia Password</label>
                          <input type="password" class="form-control" id="vecchiapassword" name="old_password" placeholder="Inserisci la vecchia password">
                        </div>
                        <div class="mb-3">
                          <label for="nuovapassword" class="form-label">Nuova Password</label>
                          <input type="password" class="form-control" id="nuovapassword" name="new_password" placeholder="Inserisci la nuova password">
                        </div>
                        <div class="text-end">
                          <button type="submit" class="btn">Conferma</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Change Email Modal -->
              <div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="changeEmailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="changeEmailModalLabel">Cambia Email</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="/Jampod/User/editEmail">
                        <div class="mb-3">
                          <label for="oldemail" class="form-label">Email attuale</label>
                          <input type="email" class="form-control" id="oldemail" value="{$email}" readonly disabled >
                        </div>
                        <div class="mb-3">
                          <label for="newemail" class="form-label">Nuova Email</label>
                          <input type="email" class="form-control" id="newemail" name="email" placeholder="Inserisci la nuova email">
                        </div>
                        <div class="text-end">
                          <button type="submit" class="btn">Conferma</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Change Email Modal -->
<!-- Change Username Modal -->
              <div class="modal fade" id="changeUsernameModal" tabindex="-1" aria-labelledby="changeUsernameModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="changeUsernameModalLabel">Cambia Username</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <form method="post" action="/Jampod/User/editUsername">
                                  <div class="mb-3">
                                      <label for="oldusername" class="form-label">Username attuale</label>
                                      <input type="text" class="form-control" id="oldusername" value="{$username}" readonly disabled>
                                  </div>
                                  <div class="mb-3">
                                      <label for="newusername" class="form-label">Nuovo Username</label>
                                      <input type="text" class="form-control" id="newusername" name="nuovo_username" placeholder="Inserisci il nuovo username">
                                  </div>
                                  <div class="text-end">
                                      <button type="submit" class="btn">Conferma</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- End Change Username Modal -->
        


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




{include file="Smarty/templates/footer.tpl"}