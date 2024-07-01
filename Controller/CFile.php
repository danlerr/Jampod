<?php

class CFile{
    //La funzione getImageInfo ritorna il contenuto  in forma binario e il mimetype di un'immagine caricata attraverso form.
    public static function getImageInfo()
{
    // Ottieni il file dalle richieste HTTP usando UHTTPMethods::files('imagefile')
    $file = UHTTPMethods::files('imagefile');

    // Esegue la validazione dell'immagine 
    $validationResult = FPersistentManager::validateImage($file);

    // Controlla se la validazione dell'immagine è passata
    if ($validationResult[0]) {
        // Ottieni il nome e il tipo MIME dell'immagine
        $imagename = $file['name'];
        $mimetype = $file['type'];

        // Leggi i dati binari dell'immagine
        $imagedata = file_get_contents($file['tmp_name']);
        

        echo "File $imagename inserito correttamente!";
        
        // Ritorna le informazioni data e mimetype dell'immagine
        return [
            'imagedata' => $imagedata,
            'imagemimetype' => $mimetype,
        ];
    } else {
        // Se la validazione fallisce, stampa il messaggio di errore
        $errorMessage = $validationResult[1];
        echo "Errore durante la validazione dell'immagine: $errorMessage";
        
        return null;
    }
}

     //La funzione getAudioInfo ritorna il contenuto  in forma binario e il mimetype di un file audio caricato attraverso form.
     public static function getAudioInfo()
     {
         // Ottieni il file audio dalle richieste HTTP usando UHTTPMethods::files('audiofile')
         $file = UHTTPMethods::files('audiofile');
     
         // Esegui la validazione del file audio usando FPersistentManager::validateAudio
         $validationResult = FPersistentManager::validateAudio($file);
     
         // Controlla se la validazione del file audio è passata
         if ($validationResult[0]) {
             // Ottieni il nome e il tipo MIME del file audio
             $audioname = $file['name'];
             $audiomimetype = $file['type'];
     
             // Leggi i dati binari del file audio
             $audiodata = file_get_contents($file['tmp_name']);               
     
             echo "File $audioname inserito correttamente!";            
             return [
                 'audiodata' => $audiodata,
                 'audiomimetype' => $audiomimetype,
             ];
         } else {
             // Se la validazione fallisce, stampa il messaggio di errore
             $errorMessage = $validationResult[1];
             echo "Errore durante la validazione del file audio: $errorMessage";
             
             return null;
         }
     }
     

}









