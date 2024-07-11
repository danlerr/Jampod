{include file="Smarty/templates/headerboot.tpl" username=$username}

<!--alert-->
{if isset($textalert) && $textalert}
    {if $success}
        {include file="Smarty/templates/successAlert.tpl"  textalert=$textalert}
    {else}
        {include file="Smarty/templates/failAlert.tpl"  textalert=$textalert}
    {/if}
{/if}

    <div class="container mt-5">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex justify-content-center">
                <img src="/Jampod/Smarty/images/quartz.png" class="img-fluid img-custom-size" alt="Image description">
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="row justify-content-end mb-5">Stai donando a </h4>
                            </div>
                            <div class="col-6">
                                <h4 class="fw-bold justify-content-end mb-5 text-primary">{$creator}</h4>
                            </div>
                        </div>
                        <form method="post" action="/Jampod/Donation/createDonation/{$recipient_id}">
                            <div class="mb-3">
                                <label for="donationAmount" class="form-label">Somma della donazione (saldo disponibile: {$senderBalance} quartz)</label>
                                <input type="number" class="form-control" id="donationAmount" name="amount" placeholder="Inserisci l'importo della donazione " required>
                                <div class="invalid-feedback">Inserisci solo numeri per l'importo della donazione.</div>
                            </div>
                            <div class="mb-3">
                                <label for="donationDescription" class="form-label">Descrizione della donazione</label>
                                <textarea class="form-control" style="resize: none;" id="donationDescription" name="donationDescription" rows="3" placeholder="Inserisci la descrizione della donazione" required></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Dona</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

{include file="Smarty/templates/footer.tpl"}