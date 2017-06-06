title: 
date: 2017-06-06T10:00:00Z
template: blogpost.php
author: 
abstract: 
---
Nei nostri lavori di riparazione dei computer, finora ci siamo imbattuti pi&ugrave; volte in problemi di alimentatori, o di computer che non si accendono per cause apparentemente correlate ad essi. Vediamo quindi come funziona l'alimentatore di un computer desktop e quali sono i metodi di analisi pi&ugrave; semplici per capire cosa c'&egrave; che non funziona.

\[...]

Lo standard ATX definisce le caratteristiche elettriche (tensione, corrente, ripple, etc...) e meccaniche(?) (dimensione, forma dei connettori, etc...) degli alimentatori.

I colori dei cavi di alimentazione all'interno del computer sono standard e stabiliti sempre dallo standard ATX:

* Giallo: +12 V
* Rosso: +5 V
* Viola: +5 V standby (attivo anche a computer spento)
* Arancione: +3.3 V
* Nero: riferimento di terra/comune(?) (nello standard e' COM, pare)
* Bianco: - 5 V (assente negli alimentatori moderni)
* Blu: - 12 V
* Marrone: +3.3 V "sense"
* Verde: PS_ON#
* Grigio: PWR_OK

Tutte le tensioni si intendono "rispetto al riferimento di terra", ad esempio il cavo giallo ha una tensione di 12 V rispetto al nero; non ha infatti fisicamente senso (o si ma non e' possibile o ha senso fisicamente ma non in altri contesti? Metterci i termini giusti.) parlare ti tensione in un punto, la differenza di tensione &egrave; sempre definita tra due punti.

Il riferimento di terra &egrave; anche connesso alla massa, cio&egrave; alla struttura metallica del case, e al connettore di terra della presa elettrica.

\[dire che quindi le tensioni si sommano e si pu' trovare il 7 V, 24 V, etc...? non credo che serva a nulla nei pc ma si pu' verificare col multimetro]

La tensione di -5 V era utilizzata sugli slot ISA, ormai obsoleti e non pi&ugrave; presenti sui computer moderni; infatti &egrave; stata rimossa dallo standard ATX intorno al 2003 e di conseguenza anche dalla maggior parte degli alimentatori prodotti in seguito.

(Anche il -12 V non serve a molto, ma sta ancora li'... perche' serve nel PCI?)

\[Dire qualcosa sul sense e fare misure col multimetro]

\[Dire che con ATX 2.0 hanno deciso di usare il 12 V per tutto, quindi ci sono DC-DC ovunque. O no. Boh.]

La tensione di "standby" di 5 V, a differenza delle altre tensioni di alimentazione, sono presenti anche a computer spento e sono utilizzati per mantenere in memoria le impostazioni del CMOS (verificare questa cosa senza fidarsi ciecamente di wikipedia) e alimentare alcuni circuiti della scheda madre, ad esempio quelli per il Wake-on-LAN (accensione del computer quando la scheda di rete riceve un opportuno pacchetto: per fare ci&ograve;, la scheda di rete deve essere alimentata per leggere i pacchetti in arrivo), supporto all'accensione da tastiera, etc...

Le impostazioni del CMOS sono necessarie alle prime fasi di avvio del computer e forniscono, ad esempio, informazioni su quale disco utilizzare per l'avvio, frequenza di clock delle RAM e della CPU se modificate rispetto al default, etc... e sono salvate su una memoria volatile (per quale oscura ragione, tra l'altro?), che deve essere mantenuta alimentata per mantenere i dati in memoria. Ci&ograve; &egrave; garantito, solitamente, da una pila a bottone da 3.3 V sulla scheda madre, ma se possibile vengono utilizzati i 5 V di standby per non scaricare inutilmente la pila (e allora c'e' un DC-DC? Le schede madri ne sono piene, col 12 V per la CPU che diventa tutte le tensioni possibili e immaginabili... ma qui? Ma poi sara' vero?).

\[scrivere anche qualcosa sul 20+4 pin]

Il segnale di PS_ON# (verificare nome...) viene utilizzato per accendere l'alimentatore e di conseguenza il computer: internamente all'alimentatore &egrave; connesso al +5 V (standby? Avrebbe senso... Ma ci sono circa 30 ohm tra lui e 5Vsb e tra lui e massa, e sta a 3.0 V spaccati...), quando si preme il tasto di accensione del computer (direttamente o tramite circuiteria? verificare col multimetro ad ali scollegato), il segnale di PS_ON# viene cortocircuitato col riferimento di terra quindi portato alla tensione di circa 0 V. L'alimentatore rileva questo e procede ad attivare la roba(?). Dopo alcuni millisecondi, quando le tensioni di uscita sono stabilizzate, l'alimentatore attiva il segnale PWR_OK (verificare nome, tensione, pull-up, pull-down, cose varie... e' attacato al 5 V non sb): la scheda madre a questo punto NON rimuove il cortocircuito tra PS_ON# (verificare con multimetro.) e terra e procede all'avvio del computer.

(1300 megaohm sul PS_ON-5VSB, 1350 sul PS_ON-GND... 50 k pull up?)

\[Dire che si puo' cortocircuitare a mano il verde col nero]

\[Inserire schema circuitale della Rpu anche se e' una banalita']

\[Dire che non dovrebbe spegnersi l'alimentatore dopo aver disconnesso PS_ON e GND che poi e' COM, e abbiamo un alimentatore che lo fa...]

\[E lo spegnimento?]

\[Dire che esiste il tester, e lo abbiamo, e abbiamo un alimentatore che oscilla tra 2 e 5 V sul 3.3 perche' e' pieno di condensatori "esplosi"]
