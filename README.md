Per l avvio dell'applicazione e necessario il composer install,dopo copaire nel file .env da creare l example e settare i permessi del db. Quindi lanciare la migrate per la creazioen delle tabelle.

Si puo comunque nella cartella database/migrate vedere le 2 tabelle create.

In App si trovano i 2 model usati per le query.

In App/Http/Controller invece si trova la logica delle request.

Compreso il punto bonus per un calcolo di distanza da latitudine e longitudine.

In roites/web sono presenti le rotte, e'stato disabilitato la richeista del crf token per queste rotte in modo da poter essere interrogate da postman passando semplicemente i dati.
# link2me
