<?php

class UHTTPMethods{
    //metodo per la gestione delle form
    public static function post($param){ // $param è il nome del campo della richiesta post inviata al server
        return $_POST[$param]; //restituisce ciò che è stato inserito nella form nel campo $param 
    }
    //metodo per l'accesso ai file caricati , prende un certo  numero di parametri 
    public static function files(...$param){ 
        if (count($param)      == 1) return $_FILES[$param[0]]; //restituisce l'array $_files relativo al primo parametro
        else if (count($param) == 2) return $_FILES[$param[0]][$param[1]];
        else if (count($param) == 3) return $_FILES[$param[0]][$param[1]][$param[2]];
        else if (count($param) == 4) return $_FILES[$param[0]][$param[1]][$param[2]][$param[3]];
        else return $_FILES[$param[0]][$param[1]][$param[2]][$param[3]][$param[4]];
    }
}

//!! BISOGNA VALIDARE E SANITIZZARE L'INPUT !! 