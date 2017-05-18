title: "A journey to Linux path #0: introduzione a FHS"
date: 2017-05-17T23:00:00Z
template: blogpost.php
author: Gisueppe Nesca
medium: https://medium.com/@neskov7/a-journey-to-linux-path-0-introduzione-a-fhs-9ed5358c4c1c
abstract: "Linux (o meglio GNU/Linux) è una famiglia di sistemi operativi Unix-like. Pertanto, qualunque sia la distribuzione a cui appartiene, rispetta nella maggior parte dei casi l’FHS: il Filesystem Hierarchy Standard. Essa è una convenzione sostenuta dalla Linux Foundation che definisce la struttura delle directories e del loro contenuto."
---
Linux (o meglio GNU/Linux) è una famiglia di sistemi operativi Unix-like. Pertanto, qualunque sia la distribuzione a cui
appartiene, rispetta nella maggior parte dei casi l’**FHS**: il **Filesystem Hierarchy Standard**. Essa è una convenzione
sostenuta dalla Linux Foundation che definisce la struttura delle directories e del loro contenuto.

> Per directory si intende l’indirizzo “virtuale” con il quale il sistema operativo indica all’utente la posizione di un
file.

A differenza di quanto avviene nei sistemi DOS e quindi in Windows, nei sistemi con FHS tutte le directories e i files
appartengono alla stessa directory principale chiamata root e indicata con il simbolo /. Non si ha quindi la distinzione
in drives indicati con una lettera maiuscola (*C:\\*, *D:\\*) come avviene in Windows e che rappresentano i volumi di memoria
come elementi distinti. Tutto è una subdirectory di root. I drives stessi sono presenti nella sottodirectory **/dev**
proprio come se fossero files. Da qui la definizione **“Everything is a file”**, anche se tecnicamente sarebbe vera la
negazione di quella frase perché tutto non è un file, ma è un [file descriptor](https://it.wikipedia.org/wiki/Descrittore_di_file).
Tutto è riconducibile a un flusso di bytes.

Le differenze con Windows non si limitano ai drives, ma riguardano anche il modo in cui vengono salvate le applicazioni
(sempre secondo la convenzione) e come è posizionato in memoria il sistema stesso.

FHS è strutturato in modo tale da raccogliere con ordine logico i file necessari all'esecuzione del sistema, i tools
fondamentali per il suo funzionamento, le sue applicazioni base e le applicazioni installate dall'utente. È di
fondamentale importanza quindi avere una conoscenza minima delle directories del sistema operativo che andiamo ad
esplorare.