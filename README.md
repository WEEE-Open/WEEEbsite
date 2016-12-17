# Sito del team WEEE Open
Il sito ch'è sito su [weeeopen.eu](http://weeeopen.eu).

## Build
### Installazione
Dopo aver clonato il repo, entrare nella directory `ma` e dare il comando `composer install`
per installare le dipendenze del [generatore di siti statici](https://github.com/lvps/mechatronic-anvil).
Per aggiornarlo: `git submodule foreach git pull`.

### Build vera e propria
Per effettuare la build del sito, eseguire `php build.php` o `build.php`,
il prodotto finito apparirà nella cartella `output`, a meno di unhandled exception varie.

## TODO
- [X] Rivedere il testo di tutte le pagine
- [X] Creare una home separata da "il progetto", scriverci in breve chi siamo e cosa facciamo e "Saremo alla Sustainability Week" (news)
	- [ ] Metterci le immagini...
- [X] Mettere link a tesi e pdf di presentazione in fondo a "il progetto"
- [X] Link a pagina Facebook e codice su GitHub nel footer?
- [X] Creare pagina contatti
	- [X] Mettere link a pagina Facebook
	- [X] e indirizzo email
- [ ] Riordinare la pagina "chi siamo" e aggiungere nuove reclute
    - [ ] Trovare un ordinamento sensato
	- [ ] Mettere foto
	- [ ] Trovare un modo più compatto e leggibile per esprimere la mole di informazioni presente
	    - [ ] Eliminare età, per non aggiornarla ogni 2 min o lasciare informazioni vecchie?
- [X] Ridurre la quantità di verde ai lati
- [ ] Tradurre tutto in inglese
- [X] Favicon
- [X] Capire perché su tutti i browser esistenti, tranne Firefox,
menu.js spara fuori un `undefined` in mezzo al testo
- [X] Capire se `srcset` di `greenday980.jpg` sta funzionando
- [X] Scrivere esattamente *dove* saremo alla Sustainability week, mettere una mappa, etc...
	- [X] Creare pagina "eventi passati", o metterli là sotto
- [ ] Creare una mailing list e\o alias

## Licenze/crediti
* Template e contenuto del sito, salvo diverse indicazioni, rilasciato sotto licenza [Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale](http://creativecommons.org/licenses/by-sa/4.0/).
* `img/raee960.jpg`: [originale di mkthedy](https://pixabay.com/it/cestino-elettronico-piastre-622419/), originariamente rilasciata nel pubblico dominio (CC0).
* `img/greenday555.jpg`, `img/greenday980.jpg`: licenza e stato di copyright incognito (probabilmente © Politecnico di Torino), confidiamo nel fair use.
* `img/pdf.svg`: *pdf icon* di [Mimooh](https://commons.wikimedia.org/wiki/User:Mimooh), rilasciata sotto licenza [Creative Commons Attribution-Share Alike 3.0 Unported](https://creativecommons.org/licenses/by-sa/3.0/deed.en)
