
{include file="Smarty/templates/header.tpl"}
{if isset($textalert) && $textalert}
        {if $success}
            {include file="Smarty/templates/successAlert.tpl "  textalert=$textalert}
        {else}
            {include file="Smarty/templates/failAlert.tpl"  textalert=$textalert}
        {/if}
    {/if}

<div class="page-wrapper">
  <!-- Page header -->
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Impostazioni account
          </h2>
        </div>
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="row g-0">
          <div class="col-12 col-md-3 border-end">
            <div class="card-body">
              <div class="list-group list-group-transparent">
                <a href="./settings.html" class="list-group-item list-group-item-action d-flex align-items-center">Il mio account</a>
                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center active">Carte di credito</a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-9 d-flex flex-column">
            <div class="card-body">
              <h2 class="mb-4">Carte di credito</h2>

              <div class="payment-card mt-5 d-flex justify-content-between align-items-center mb-5">
                <div class="card-details d-flex flex-row align-items-center">
                  <img src="/Smarty/images/creditcard.png" class="card-image" width="50">
                  <div class="card-info d-flex flex-column">
                    <span class="card-type">Proprietario carta</span>
                    <span class="card-number">1234 XXXX XXXX 2570</span>
                  </div>
                </div>
              </div>

              <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#aggiungiModal">Aggiungi carta</button>
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rimuoviModal">Rimuovi carta</button>

              <div class="modal fade" id="aggiungiModal" tabindex="-1" aria-labelledby="ricaricaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="ricaricaModalLabel">Aggiungi carta</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="/Jampod/User/addCreditCard" method="post" >
                        <div class="mb-3">
                          <label for="numeroCarta" class="form-label">Numero Carta</label>
                          <input type="text" class="form-control" id="numeroCarta" placeholder="Inserisci numero carta">
                        </div>
                        <div class="mb-3">
                          <label for="nomeTitolare" class="form-label">Nome Titolare</label>
                          <input type="text" class="form-control" id="nomeTitolare" placeholder="Inserisci nome titolare">
                        </div>
                        <div class="mb-3">
                          <label for="dataScadenza" class="form-label">Data di Scadenza</label>
                          <input type="text" class="form-control" id="dataScadenza" placeholder="MM/AA">
                        </div>
                        <div class="mb-3">
                          <label for="cvv" class="form-label">CVV</label>
                          <input type="text" class="form-control" id="cvv" placeholder="CVV">
                        </div>
                        <div class="text-end">
                          <button type="button" class="btn btn-outline-success" id="confermaAggiungiCarta">Conferma Aggiunta Carta</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="rimuoviModal" tabindex="-1" aria-labelledby="ricaricaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="ricaricaModalLabel">Rimuovi carta</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                  <form action="/Jampod/User/removeCreditCard" method="post" >

                        <div class="mb-3">
                          <label for="cartaSelezionataPrelievo" class="form-label">Seleziona Carta di Credito</label>
                          <select class="form-select" id="cartaSelezionataPrelievo">
                            <option selected>Seleziona una carta...</option>
                            <option value="1">Carta Visa **** 1234</option>
                            <option value="2">Carta MasterCard **** 5678</option>
                          </select>
                        </div>
                        <div class="text-end">
                          <button type="button" class="btn btn-outline-danger" id="confermaAggiungiCarta">Conferma Rimozione Carta</button>
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

{include file="Smarty/templates/footer.tpl"}