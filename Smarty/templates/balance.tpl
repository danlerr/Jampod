{include file="header.tpl"}

    <!--saldo-->
    <div class="container mt-5">
        <div class="saldo-section bg-white p-4 rounded shadow-sm mb-4">
            <h2>Saldo Disponibile</h2>
            <div class="saldo mb-4">
                <span class="fw-bold">€ 1,000.00</span>
            </div>
            <div class="button-container d-flex justify-content-between">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ricaricaModal">Ricarica Saldo</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#prelevaModal">Preleva Saldo</button>
            </div>
        </div>
        <div class="movimenti-section bg-white p-4 rounded shadow-sm">
            <h2>Movimenti Precedenti</h2>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrizione</th>
                        <th>Importo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01/06/2024</td>
                        <td>Ricarica</td>
                        <td>+ € 100.00</td>
                    </tr>
                    <tr>
                        <td>05/06/2024</td>
                        <td>Prelievo</td>
                        <td>- € 50.00</td>
                    </tr>
                    <tr>
                        <td>10/06/2024</td>
                        <td>Pagamento</td>
                        <td>- € 20.00</td>
                    </tr>
                    <!-- Aggiungi altri movimenti qui -->
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
                        <div class="mb-3">
                            <label for="cartaSelezionata" class="form-label">Seleziona Carta di Credito</label>
                            <select class="form-select" id="cartaSelezionata">
                                <option selected>Seleziona una carta...</option>
                                <option value="1">Carta Visa **** 1234</option>
                                <option value="2">Carta MasterCard **** 5678</option>
                                <!-- Aggiungi altre carte qui -->
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#aggiungiCartaForm">Aggiungi Carta</button>
                            <button type="submit" class="btn btn-outline-success">Conferma</button>
                        </div>
                        <div class="collapse mt-3" id="aggiungiCartaForm">
                            <div class="card card-body">
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
                                    <button type="button" class="btn btn-primary" id="confermaAggiungiCarta">Conferma Aggiunta Carta</button>
                                </div>
                            </div>
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
                        <div class="mb-3">
                            <label for="cartaSelezionataPrelievo" class="form-label">Seleziona Carta di Credito</label>
                            <select class="form-select" id="cartaSelezionataPrelievo">
                                <option selected>Seleziona una carta...</option>
                                <option value="1">Carta Visa **** 1234</option>
                                <option value="2">Carta MasterCard **** 5678</option>
                                <!-- Aggiungi altre carte qui -->
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#aggiungiCartaFormPrelievo">Aggiungi Carta</button>
                            <button type="submit" class="btn btn-outline-danger">Conferma</button>
                        </div>
                        <div class="collapse mt-3" id="aggiungiCartaFormPrelievo">
                            <div class="card card-body">
                                <div class="mb-3">
                                    <label for="numeroCartaPrelievo" class="form-label">Numero Carta</label>
                                    <input type="text" class="form-control" id="numeroCartaPrelievo" placeholder="Inserisci numero carta">
                                </div>
                                <div class="mb-3">
                                    <label for="nomeTitolarePrelievo" class="form-label">Nome Titolare</label>
                                    <input type="text" class="form-control" id="nomeTitolarePrelievo" placeholder="Inserisci nome titolare">
                                </div>
                                <div class="mb-3">
                                    <label for="dataScadenzaPrelievo" class="form-label">Data di Scadenza</label>
                                    <input type="date" class="form-control" id="dataScadenzaPrelievo" placeholder="MM/AA">
                                </div>
                                <div class="mb-3">
                                    <label for="cvvPrelievo" class="form-label">CVV</label>
                                    <input type="number" class="form-control" id="cvvPrelievo" placeholder="CVV" maxlength="3">
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-primary" id="confermaAggiungiCartaPrelievo">Conferma Aggiunta Carta</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{include file="footer.tpl"}