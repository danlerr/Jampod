{include file="header.tpl"}


<!--alert-->
    {if isset($textalert) && $textalert}
        {if $success}
            {include file="Smarty/templates/successAlert.tpl"}
        {else}
            {include file="Smarty/templates/failAlert.tpl"}
        {/if}
    {/if}
    <!--saldo-->
    <div class="container mt-5">
        <div class="saldo-section bg-white p-4 rounded shadow-sm mb-4">
            <h2>Il tuo saldo</h2>
            <small>1€ = 1<img src="/Jampod/Smarty/images/quartz.png" alt="Moneta Virtuale" class="img-fluid" style="width: 20px; height: 20px; margin-bottom:5px"></small>
            <div class="saldo mb-4">
                <span class="fw-bold display-5">
                <img src="/Jampod/Smarty/images/quartz.png" alt="Moneta Virtuale" class="img-fluid" style="width: 60px; height: 60px; margin-bottom: 15px;"> 
                {$balance}
                </span>
            </div>
            <div class="button-container d-flex justify-content-between">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ricaricaModal">Ricarica Saldo</button>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#prelevaModal">Preleva Saldo</button>
            </div>
        </div>
        <div class="movimenti-section bg-white p-4 rounded shadow-sm">
            <h2>Donazioni in entrata</h2>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrizione</th>
                        <th>Importo</th>
                        <th>Ricevuta da</th>

                    </tr>
                </thead>
                <tbody>
                    {foreach from=$donationsReceived item=donation}
                    <tr>
                        <td>{$donation.donation_date}</td>
                        <td>{$donation.donation_description}</td>
                        <td>{$donation.amount}</td>
                        <td>{$donation.senderUsername}</td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
        <div class="movimenti-section bg-white p-4 rounded shadow-sm">
            <h2>Donazioni in uscita</h2>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrizione</th>
                        <th>Importo</th>
                        <th>Inviata a</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$donationsMade item=donation}
                    <tr>
                        <td>{$donation.donation_date}</td>
                        <td>{$donation.donation_description}</td>
                        <td>{$donation.amount}</td>
                        <td>{$donation.recipientUsername}</td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal Ricarica Saldo -->
    <div class="modal fade" id="ricaricaModal" tabindex="-1" aria-labelledby="ricaricaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ricaricaModalLabel">Ricarica Saldo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="amountForm" method="post" action="/Jampod/Balance/rechargeBalance">
                        <div class="mb-3">
                            <label for="ricaricaImporto" class="form-label">Importo</label>
                            <input type="number" class="form-control" id="ricaricaImporto" name="amount" placeholder="Inserisci importo" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-outline-success">Conferma</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal Preleva Saldo -->
    <div class="modal fade" id="prelevaModal" tabindex="-1" aria-labelledby="prelevaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prelevaModalLabel">Preleva Saldo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="withdrawForm" method="post" action="/Jampod/Balance/withdrawBalance">
                        <div class="mb-3">
                            <label for="prelevaImporto" class="form-label">Importo</label>
                            <input type="number" class="form-control" id="prelevaImporto" name="amount" placeholder="Inserisci importo" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-outline-danger">Conferma</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{include file="footer.tpl"}