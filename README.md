# Sito del team WEEE Open
Il sito ch'è sito su [weeeopen.polito.it](http://weeeopen.polito.it).

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
- [X] Barra di navigazione che segue lo scroll
    - [ ] Trovare il modo di farla funzionare senza che sparisca a metà pagina per colpa del "footer che non si espande"
- [X] Footer che non si espande
- [X] Creare una home separata da "il progetto", scriverci in breve chi siamo e cosa facciamo e "Saremo alla Sustainability Week" (news)
	- [X] Metterci la foto del disco rigido aperto
	- [X] Metterci riquadri che scorrono con ultimi post o altre informazioni ("abbiamo recuperato 9001 pc il mese scorso", "riciclare è bello", etc...)
- [X] Mettere link a tesi e pdf di presentazione in fondo a "il progetto"
- [X] Link a pagina Facebook e codice su GitHub nel footer?
    - [X] Mettere icona Facebook
- [X] Creare pagina contatti
	- [X] Mettere link a pagina Facebook
	- [X] e indirizzo email
	- [X] Metterci un "dove siamo"
- [X] Trasformare "attività" in "news" (o "blog"?)
    - [X] Metterci blog
    - [X] Mettere foto sustainability week (in ritardo di 1 mese, va beh)
    - [X] Mettere logo Linux Day per quel post
- [X] Riordinare la pagina "chi siamo" e aggiungere nuove reclute
    - [X] Metterla al fondo, di fianco ai contatti
    - [X] Trovare un ordinamento sensato
	- [ ] Mettere foto
	- [X] Trovare un modo più compatto e leggibile per esprimere la mole di informazioni presente
	    - [X] Eliminare età, per non aggiornarla ogni 2 min o lasciare informazioni vecchie
	    - [X] Mettere gente affiancata
	    - [X] Mettere ombre per effetto pseudo-3D molto material design
- [X] Ridurre la quantità di verde ai lati
- [ ] Mettere timeline nella pagina "obiettivi"
- [ ] Trovare una lightbox funzionante per div.photogallery
	- [ ] Creare la suddetta lightbox, poiché non esiste nulla di veramente *semplice* e senza milioni di dipendenze
- [ ] Tradurre tutto in inglese
- [X] Favicon
- [X] Capire perché su tutti i browser esistenti, tranne Firefox,
menu.js spara fuori un `undefined` in mezzo al testo
- [X] Capire se `srcset` di `greenday980.jpg` sta funzionando
- [X] Scrivere esattamente *dove* saremo alla Sustainability week, mettere una mappa, etc...
	- [X] Creare pagina "eventi passati", o metterli là sotto
- [X] Creare una mailing list e\o alias

## Licenze/crediti
* Template e contenuto del sito, salvo diverse indicazioni, rilasciato sotto licenza [Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale](http://creativecommons.org/licenses/by-sa/4.0/).
* `img/raee960.jpg`: [originale di mkthedy](https://pixabay.com/it/cestino-elettronico-piastre-622419/), originariamente rilasciata nel pubblico dominio (CC0).
* `blog/media/greenday555.jpg`, `blog/media/greenday980.jpg`: licenza e stato di copyright incognito (probabilmente copyright © Politecnico di Torino), confidiamo nel fair use.
* `img/pdf.svg`: *pdf icon* di [Mimooh](https://commons.wikimedia.org/wiki/User:Mimooh), rilasciata sotto licenza [Creative Commons Attribution-Share Alike 3.0 Unported](https://creativecommons.org/licenses/by-sa/3.0/deed.en)
* `img/fb.svg`: [icona ufficiale di Facebook](https://en.facebookbrand.com/assets/f-logo), forse priva di copyright perché troppo "semplice", in ogni caso rappresenta un marchio registrato; usata secondo le linee guida presenti nella medesima pagina.
* `blog/media/ldto-2016-tux.svg`: [Logo ufficiale Linux Day Torino 2016](https://github.com/0iras0r/ld2016/blob/877d31f8cbcd0a4add1677a34b432f39f7f4a5d5/2016/static/ld-2016-tux.svg), copyright © Comitato Linux Day Torino, rilasciato sotto licenza [Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale](http://creativecommons.org/licenses/by-sa/4.0/)
* `blog/media/ldto-2016-tux.svg`: Logo ufficiale Linux Day Torino 2017, copyright © Comitato Linux Day Torino, licenza come sopra probabilmente
* `blog/media/a-bit-of-history-logo.png`: Logo ufficiale [a bit of \[hi\]story](http://abitofhistory.it/): licenza Creative Commons Attribuzione - Non commerciale.
* `blog/media/Membrane_keyboard_diagram_FULL_SCALE.png`: *Stylised diagram of membrane keyboard* di [Fourohfour](https://en.wikipedia.org/wiki/en:User:Fourohfour), rilasciata sotto licenza Creative Commons Attribution-Share Alike 2.5 o GFDL 1.2, origiale su [Wikimedia commons](https://commons.wikimedia.org/wiki/File:Membrane_keyboard_diagram_FULL_SCALE.png)
* `input/blog/media/fixfest-2017-logo.png`: Flyer del [Fixfest 2017](https://fixfest.therestartproject.org/) presente nel Media Kit, licenza incognita ma confidiamo nel fair use
