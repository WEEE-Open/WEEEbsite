title: 
date: 2017-06-06T10:00:00Z
template: blogpost.php
author: 
abstract: 
---
Nei nostri lavori di riparazione dei computer, finora ci siamo imbattuti più volte in problemi di alimentatori, o di computer che non si accendono per cause apparentemente correlate ad essi. Vediamo quindi come funziona l'alimentatore di un computer desktop e quali sono i metodi di analisi più semplici per capire cosa c'è che non funziona.

Ricordiamo comunque che gli alimentatori dei computer sono dispositivi in grado di erogare correnti potenzialmente *pericolose*, se non *letali*; per questa ragione **sconsigliamo** a chi non ha esperienza di effettuare qualsiasi esperimento, misura, prova, analisi o riparazione indicata in questo articolo. Tali informazioni servono solamente a mostrare il legame tra la teoria e la pratica e dare un'idea di cosa facciamo in laboratorio, ma i test empirici è sempre meglio farli sotto la supervisione di una persona con più esperienza e con le dovute precauzioni di sicurezza, vista la pericolosità dei dispositivi trattati.

\[...]

Lo standard ATX definisce le caratteristiche elettriche (tensione, corrente, ripple, etc...) e meccaniche(?) (dimensione, forma dei connettori, etc...) degli alimentatori.

I colori dei cavi di alimentazione all'interno del computer sono standard e stabiliti sempre dallo standard ATX:

* Giallo: +12 V
* Rosso: +5 V
* Viola: +5 V standby (attivo anche a computer spento)
* Arancione: +3.3 V
* Nero: riferimento comune (terra)
* Bianco: -5 V (assente negli alimentatori moderni)
* Blu: -12 V
* Marrone: +3.3 V "sense"
* Verde: PS_ON#
* Grigio: PWR_OK

Tutte le tensioni si intendono "rispetto al riferimento comune", ad esempio il cavo giallo ha una tensione di 12 V rispetto al nero; la tensione è infatti per definizione la differenza di energia potenziale elettrica tra due punti, non ha senso misurare la tensione "in un punto" senza un altro riferimento.

Il riferimento comune è anche connesso alla massa, cioè alla struttura metallica del case, e al connettore di terra della presa elettrica. Questo può anche essere verificato con un multimetro in modalità "test di continuità" (buzzer) o "misura di resistenza": tra i connettori neri dell'alimentatore e qualsiasi parte metallica del case si rileverà una resistenza di fatto trascurabile.  
Va tenuto presente che le parti verniciate del case, di solito, non sono conduttive e quindi non sono collegate al riferimento comune e alla terra. Ciò può essere verificato allo stesso modo col multimetro.

\[dire che quindi le tensioni si sommano e si pu' trovare il 7 V, 24 V, etc...? non credo che serva a nulla nei pc ma si pu' verificare col multimetro]

La tensione di -5 V era utilizzata sugli slot ISA, ormai obsoleti e non più presenti sui computer moderni; infatti è stata rimossa dallo standard ATX intorno al 2003 e di conseguenza anche dalla maggior parte degli alimentatori prodotti in seguito.

(Anche il -12 V non serve a molto, ma sta ancora li'... perche' serve nel PCI?)

\[Dire qualcosa sul sense e fare misure col multimetro]

\[Dire che con ATX 2.0 hanno deciso di usare il 12 V per tutto, quindi ci sono DC-DC ovunque. O no. Boh.]

La tensione di "standby" di 5 V, a differenza delle altre tensioni di alimentazione, è presente anche a computer spento ed è utilizzata per mantenere in memoria le impostazioni del CMOS (verificare questa cosa senza fidarsi ciecamente di wikipedia) e alimentare alcuni circuiti della scheda madre, ad esempio quelli per il Wake-on-LAN (accensione del computer quando la scheda di rete riceve un opportuno pacchetto: per fare ciò, la scheda di rete deve essere alimentata per leggere i pacchetti in arrivo), supporto all'accensione da tastiera, etc...

Le impostazioni del CMOS sono necessarie alle prime fasi di avvio del computer e forniscono, ad esempio, informazioni su quale disco utilizzare per l'avvio, frequenza di clock delle RAM e della CPU se modificate rispetto al default, etc... e sono salvate su una memoria volatile (per quale oscura ragione, tra l'altro?), che deve essere mantenuta alimentata per mantenere i dati in memoria. Ciò è garantito, solitamente, da una pila a bottone da 3.3 V sulla scheda madre, ma se possibile vengono utilizzati i 5 V di standby per non scaricare inutilmente la pila (e allora c'e' un DC-DC? Le schede madri ne sono piene, col 12 V per la CPU che diventa tutte le tensioni possibili e immaginabili... ma qui? Ma poi sara' vero?).

\[scrivere anche qualcosa sul 20+4 pin]

Il segnale di PS_ON# (verificare nome...) viene utilizzato per accendere l'alimentatore e di conseguenza il computer: internamente all'alimentatore è connesso solitamente a una tensione di +5 V \[ma non al 5Vsb, pare...] tramite una resistenza di pull-up; quando si preme il tasto di accensione del computer il segnale di PS_ON# viene cortocircuitato col riferimento comune quindi portato alla tensione di circa 0 V.  
L'alimentatore rileva ciò e attiva tutte le altre uscite alle altre tensioni. Dopo alcuni millisecondi, quando le tensioni di uscita sono stabilizzate, l'alimentatore attiva il segnale PWR_OK collegando tale pin(?) al +5 V (verificare nome, pull-up, pull-down, cose varie...): la scheda madre a questo punto procede all'avvio del computer.
Per lo spegnimento, la scheda madre rimuove il cortocircuito tra PS_ON# e riferimento comune, l'alimentatore lo rileva e procede a spegne tutte le uscite, ad eccezione della tensione di 5 V di standby e del segnale PS_ON#.

In uno degli alimentatori che abbiamo provato in laboratorio, il segnale PS_ON# era a una tensione di +3 V rispetto al riferimento comune: è probabile che ciò sia stato fatto per ragioni di risparmio energetico, infatti \[...non bastava mettere una GRANDE resistenza di pull-up?]

(1300 megaohm sul PS_ON-5VSB, 1350 sul PS_ON-GND... 50 k pull up?)

\[Dire che si puo' cortocircuitare a mano il verde col nero]

\[Inserire schema circuitale della Rpu anche se e' una banalita']

\[Dire che non dovrebbe spegnersi l'alimentatore dopo aver disconnesso PS_ON e GND che poi e' COM, e abbiamo un alimentatore che lo fa...]

\[E lo spegnimento?]

\[Dire che esiste il tester, e lo abbiamo, e abbiamo un alimentatore che oscilla tra 2 e 5 V sul 3.3 perche' e' pieno di condensatori "esplosi"]
