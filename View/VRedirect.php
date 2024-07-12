<?php
//La classe VRedirect contiene alcuni metodi che richiamano la funzione header di php che invia intestazioni http al client.
class VRedirect{
    
    /**
     * Esegue un redirect verso un URL specificato.
     *
     * @param string $url L'URL verso cui redirigere.
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Imposta un header HTTP.
     *
     * @param string $header La stringa del header.
     */
    public function setHeader($header)
    {
        header($header);
    }
}


