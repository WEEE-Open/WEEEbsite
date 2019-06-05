title: Storia di un computer decisamente caldo
date: 2019-06-05T17:00:00Z
template: blogpost.php
author: Gabriele Mariani
abstract: "Fra i tanti computer di cui il team si sta occupando spiccano per numero i Dell Optiplex 745 USFF. Presentano nella loro quasi totalità il medesimo problema: i condensatori della porzione inferiore destra della scheda madre risultano gonfi."
pinned: true
img:
    src: /blog/media/optiplex-termocamera.jpg
    alt: Foto con termocamera del pc decisamente caldo
    title: Foto con termocamera del pc decisamente caldo
---

Fra i tanti computer di cui il team si sta occupando spiccano per numero i Dell Optiplex 745.

Giunti tutti nel formato "ultra small" (USFF), questi pc presentano nella loro quasi totalità il medesimo problema: i condensatori della porzione inferiore destra della scheda madre risultano gonfi.
 
<img class="decorativa" src="" alt="Immagine ripresa dalla termocamera" title="Immagine ripresa dalla termocamera">
 
I condensatori elettrolitici presenti nei prodotti elettronici sono particolarmente sensibili allo stress termico. La parte superiore dei condensatori è costruita a "x" per far sfogare gli eventuali aumenti di pressione dell'elettrolita all'interno e dirigere in direzioni meno dannose la conseguente esplosione del componente.

Il problema risiede probabilmente nelle alte temperature che si vengono a sviluppare in quella parte del case. I moderni condensatori sono progettati per avere una vita media di una quindicina di anni ma le condizioni esterne possono modificare di molto questo valore: i computer che ci sono toccati in sorte hanno iniziato a manifestare questo problema dopo 10 anni o meno da quando sono stati prodotti.

Nonostante quindi tutti gli accorgimenti costruttivi e la presenza di abbondanti superfici di scambio termico le temperature in questi case così compatti restano un problema.

L'analisi svolta con la termocamera rivela in posizione centrale dei chip molto caldi (attorno ai 70 °C) in condizioni di idle. 

Sopra questi chip va posizionato il supporto per il disco rigido da 3.5" munito di ventola. Questo aiuta a mantenere il flusso d'aria tra le ventole in ingresso e in uscita.

Con questo in posizione le temperature del case in idle non superano i 40 °C.

<img class="decorativa" src="/blog/media/optiplex-airflow.jpg" alt="Flusso d'aria" title="Flusso d'aria">

Perché dunque i condensatori vengono danneggiati? La risposta non è semplice. La teoria di chi scrive è che data la posizione e l'altezza dei condensatori l'aria sia portata a ristagnare in quella posizione creando una zona a temperatura più alta all'interno del case. Oltre al flusso non ottimale inoltre bisogna considerare le che dimensioni ridotte della scheda madre sono tali da porre questi componenti molto vicino a fonti di calore considerevoli.
