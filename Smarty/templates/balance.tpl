{include file="header.tpl"}

    <!--saldo-->
    <div class="container mt-5">
        <div class="saldo-section bg-white p-4 rounded shadow-sm mb-4">
            <h2>Saldo Disponibile</h2>
            <div class="saldo mb-4">
                <span class="fw-bold">€ {$balance}</span>
            </div>
            <div class="button-container d-flex justify-content-between">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ricaricaModal">Ricarica Saldo</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#prelevaModal">Preleva Saldo</button>
            </div>
        </div>
        <div class="movimenti-section bg-white p-4 rounded shadow-sm">
            <h2>Storico delle donazioni</h2>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrizione</th>
                        <th>Importo</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$donations item=donation}
                    <tr>
                        <td>{$donation->getDonationTime()}</td>
                        <td>{$donation->getDonationText()}</td>
                        <td>{$donation->getDonationAmount()}</td>
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
                    <form>
                        <div class="mb-3">
                            <label for="ricaricaImporto" class="form-label">Importo</label>
                            <input type="number" class="form-control" id="ricaricaImporto" placeholder="Inserisci importo">
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
                    <form>
                        <div class="mb-3">
                            <label for="prelevaImporto" class="form-label">Importo</label>
                            <input type="number" class="form-control" id="prelevaImporto" placeholder="Inserisci importo">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-outline-danger">Conferma</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{include file="footer.tpl"}