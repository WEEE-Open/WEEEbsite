title: Riparazione di una tastiera danneggiata esternamente
date: 2017-06-05T17:00:00Z
template: blogpost.php
author: Emanuele Guido
abstract: In laboratorio capita a volte di ricevere dispositivi il cui problema maggiore è l'essere danneggiato esternamente. In queste situazioni la cosa da fare in genere è trovare un apparecchio simile e danneggiato ed usarne le componenti come ricambi.
img:
    src: /blog/media/riparazione-tastiera-mini.jpg
    alt: Riparazione della tastiera
    title: Riparazione della tastiera
    hide: true
---

In laboratorio capita a volte di ricevere dispositivi il cui problema maggiore è l'essere danneggiato esternamente.  
Quando ci si trova in queste situazioni la cosa da fare in genere è trovare un apparecchio simile e danneggiato a
sua volta ed usarne le componenti come ricambi.

Uno degli ultimi casi riguarda due tastiere dello stesso modello: una perfettamente funzionante ma con la plastica
rotta in più punti e l'altra con l'elettronica non funzionante ma la plastica completamente intatta.

## Premessa

<img class="decorativa" src="/blog/media/Membrane_keyboard_diagram_FULL_SCALE.png" alt="Diagramma tastiera a membrana" title="Diagramma di una tastiera a membrana">

Le tastiere si dividono in due grandi categorie: tastiere meccaniche e tastiere a membrana, ma non sono le uniche.

Le due categorie differiscono principalmente nel modo in cui l'input viene rilevato. Nel nostro caso la tastiera
da riparare era una a membrana, si può dedurre dal fatto che il circuito è stampato su diversi fogli in materiale
plastico molto flessibile. Lo strato superiore e quello inferiore sono conduttivi mentre lo strato centrale funge
da divisore. Quando viene premuto un tasto, lo strato superiore e quello inferiore chiudono il circuito e il
segnale viene inviato ad un microcontrollore che lo elabora.

## All'opera

<img class="decorativa-flow" src="riparazione-tastiera.jpg" alt="Riparazione della tastiera" title="Riparazione della tastiera">

La prima fase del lavoro è quella dello smontaggio. Vanno rimosse tutte le viti e in caso di viti di diverse
dimensioni ne va segnata la posizione per facilitare la fase di riassemblaggio ed evitare di danneggiare le
filettature della tastiera.

La tastiera deve avere i tasti rivolti verso il piano di lavoro nella fase di apertura
dell'involucro. Una volta smontate entrambe le tastiere si procede con il trasferimento della circuiteria.

Si rimuovono il controllore e i fogli con il circuito stampato e si riposizionano con cura nell'involucro della
seconda tastiera precedentemente svuotato.  
Nel nostro caso la tastiera è stata aperta tre volte in quanto una
volta riassemblata e collegata, nonostante i led di alimentazione accesi non dava nessun Output.

Abbiamo smontato nuovamente la tastiera e ci siamo assicurati che ci fosse il contatto tra il circuito e il controllore,
abbiamo notato che effettivamente era quello il problema. Anche questa volta però la tastiera non dava alcun
segnale. Alla terza prova abbiamo cambiato la parte dell'involucro in cui era alloggiato il controllore che, in
quanto danneggiata, non permetteva il completo contatto dei componenti.

Una volta riassemblata il risultato finale è stato una tastiera che è come nuova e pronta per essere donata.

## Osservazioni

Nello smontare una tastiera a membrana bisogna prestare attenzione alle varie componenti in silicone che compongono 
la stessa. Queste componenti permettono la chiusura del circuito e fanno in modo che il tasto torni nella corretta
posizione una volta rilasciato, quindi sono importanti per il funzionamento della tastiera.

I fogli con il circuito, anche se appaiono resistenti non vanno maneggiati con troppa superficialità.

Un'altra delle cose a cui prestare attenzione quando si smonta una tastiera a membrana è quella di non danneggiare
il microcontrollore o i contatti con il circuito.

Durante la sostituzione del case della tastiera uno degli inconvenienti era dovuto al fatto che il nuovo
alloggiamento seppur intatto esternamente presentava dei problemi all'interno, alcune parti che avevano il compito
di tenere fermi i componenti erano danneggiate. In questa particolare tastiera, per costruzione, il circuito e il
controllore non erano saldati insieme ma sovrapposti e tenuti insieme proprio da una delle parti danneggiate.
