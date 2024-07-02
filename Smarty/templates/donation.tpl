{include file="Smarty/templates/header.tpl"}

    <div class="container mt-5">
        <div class="row justify-content-end">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="row justify-content-end mb-0">Stai donando a</h4>
                            </div>
                            <div class="col-6">
                                <h4 class="fw-bold text-primary">leonpastorelli</h4>
                            </div>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label for="donationAmount" class="form-label">Somma della donazione</label>
                                <input type="number" class="form-control" id="donationAmount" name="donationAmount" placeholder="Inserisci l'importo della donazione " required>
                                <div class="invalid-feedback">Inserisci solo numeri per l'importo della donazione.</div>
                            </div>
                            <div class="mb-3">
                                <label for="donationDescription" class="form-label">Descrizione della donazione</label>
                                <textarea class="form-control" style="resize: none;" id="donationDescription" name="donationDescription" rows="3" placeholder="Inserisci la descrizione della donazione" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Dona</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

{include file="Smarty/templates/footer.tpl"}