{include file="Smarty/templates/header.tpl" username=$username}

{if isset($textalert) && $textalert}
    {if $success}
        {include file="Smarty/templates/successAlert.tpl" textalert=$textalert}
    {else}
        {include file="Smarty/templates/failAlert.tpl" textalert=$textalert}
    {/if}
{/if}

</head>
<body>
<script src="/Smarty/dist/js/demo-theme.min.js?1692870487"></script>
<div class="page">

<div class="page-wrapper">
    
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <div class="list-group list-group-transparent">
                                <a href="/Jampod/User/settings" class="list-group-item list-group-item-action d-flex align-items-center">Il mio Account</a>
                                <a href="/Jampod/User/userCards" class="list-group-item list-group-item-action d-flex align-items-center active">Carte di Credito</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h2 class="mb-4">Carte di credito</h2>
                            
                           
                                {if $card_count>0}
                                    {foreach from=$cards item=card}
                                        {if $card instanceof ECreditCard}
                                            <div class="payment-card mt-5 d-flex justify-content-between align-items-center mb-5">
                                                <div class="card-details d-flex flex-row align-items-center">
                                                    <img src="/Jampod/Smarty/images/creditcard.png" class="card-image" width="50">
                                                    <div class="card-info d-flex flex-column">
                                                        <span class="card-type">{$card->getCreditCardHolder()}</span>
                                                        <span class="card-number">{$card->getCreditCardNumber()}</span>
                                                    </div>
                                                </div>
                                        <div class="card-actions">
                                            <form action="/Jampod/User/removeCreditCard/{$card->getId()}" method="post">
                                                <input type="hidden" name="card_id" value="{$card->getId()}">
                                                <a href="/Jampod/User/removeCreditCard/{$card->getId()}" class="btn btn-danger btn-move-left" data-bs-toggle="modal" data-bs-target="#rimuoviModal">Rimuovi carta</a>
                                            </form>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        {/if}
                
                            <a href="/Jampod/User/addCreditCard" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#aggiungiModal">Aggiungi carta</a>

                            <div class="modal fade" id="aggiungiModal" tabindex="-1" aria-labelledby="aggiungiModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="aggiungiModalLabel">Aggiungi carta</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/Jampod/User/addCreditCard" method="post">
                                                <div class="mb-3">
                                                    <label for="numeroCarta" class="form-label">Numero Carta</label>
                                                    <input type="text" class="form-control" id="numeroCarta" name="card_number" placeholder="Inserisci numero carta">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomeTitolare" class="form-label">Nome Titolare</label>
                                                    <input type="text" class="form-control" id="nomeTitolare" name="card_holder" placeholder="Inserisci nome titolare">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dataScadenza" class="form-label">Data di Scadenza</label>
                                                    <input type="text" class="form-control" id="dataScadenza" name="expiration_date" placeholder="MM/AA">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cvv" class="form-label">CVV</label>
                                                    <input type="text" class="form-control" id="cvv" name="security_code" placeholder="CVV">
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-outline-success" id="confermaAggiungiCarta">Conferma Aggiunta Carta</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="rimuoviModal" tabindex="-1" aria-labelledby="rimuoviModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered custom-modal-size">
                                   <div class="modal-content custom-modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="rimuoviModalLabel">Sei sicuro di voler eliminare la carta?</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/Jampod/User/removeCreditCard/{$card->getId()}" method="post">
                                            
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-outline-danger" id="confermaRimuoviCarta">Conferma</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .custom-modal-size {
                            max-width: 400px; /* Dimensione personalizzata della finestra modale */
                        }
                        .custom-modal-content {
                            max-height: 150px; /* Altezza massima del contenuto del modale */
                        }
                        .btn-move-left {
                            margin-right: 20px; /* Piccolo margine a destra per spostare il pulsante a sinistra */
                        }
                        </style>

{include file="Smarty/templates/footer.tpl"}
