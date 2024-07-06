{include file="Smarty/templates/header.tpl" username=$username email=$email}
     {if isset($textalert) && $textalert}
        {if $success}
            {include file="Smarty/templates/failAlert.tpl"  textalert=$textalert}
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
                <a href="./settings.html" class="list-group-item list-group-item-action d-flex align-items-center active">My Account</a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">My Credit Cards</a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-9 d-flex flex-column">
            <div class="card-body">
              <h2 class="mb-4">My Account</h2>
              <h3 class="card-title">Profile Details</h3>
              <h3 class="card-title mt-4">Email</h3>
              <div>
                <div class="row g-2">
                  <div class="col-auto">
                    <input type="text" class="form-control w-auto" value="{$email}" readonly>
                  </div>
                  <div class="col-auto">
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#changeEmailModal">Change</button>
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
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#changeUsernameModal">Change</button>
                  </div>
                </div>
              </div>
              <h3 class="card-title mt-4">Password</h3>
              <div>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#setpasswordModal">Cambia password</button>
              </div>
              <div class="modal fade" id="setpasswordModal" tabindex="-1" aria-labelledby="ricaricaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="cambiapassword">Cambia password</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="mb-3">
                          <label for="vecchiapassword" class="form-label">Vecchia Password</label>
                          <input type="password" class="form-control" id="vecchiapassword" placeholder="Inserisci la vecchia password">
                        </div>
                        <div class="mb-3">
                          <label for="nuovapassword" class="form-label">Nuova Password</label>
                          <input type="password" class="form-control" id="nuovapassword" placeholder="Inserisci la nuova password">
                        </div>
                        <div class="text-end">
                          <button type="button" class="btn" id="confermamodificapassword">Conferma</button>
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
                          <a href="/Jampod/User/editEmail" type="submit" class="btn">Conferma</a>
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

<div class="alert alert-danger">
  {$string}
</div>



{include file="Smarty/templates/footer.tpl"}