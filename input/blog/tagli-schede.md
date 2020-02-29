title: "Schede di espansione interne per pc: facciamo chiarezza."
date: 2020-02-24T17:00:00Z
template: blogpost.php
author: Andrea Mannarella
abstract: "Durante il nostro lavoro di riparazione dei PC che recuperiamo, ci siamo accorti che esistono svariate tipologie di connessione per le schede di espansione interne al PC"
pinned: true
img:
    src: /blog/media/PCIslots.jpg
    alt: Tipologie slot collegamnto periferiche
    title: Tipologie slot collegamnto periferiche
---

Durante il nostro lavoro di riparazione dei PC che recuperiamo, ci siamo accorti che esistono svariate tipologie di connessione per le schede di espansione interne al PC, che siano tower, all in one, portatili, ecc…

Queste ci permettono di aggiungere, ad esempio, diverse tipologie di porte sia interne (sata, ide, scsi…) che esterne (come usb, jack, ethernet…) che saranno accessibili dal case, oppre schede grafiche o di altro tipo.

In questo excursus andremo a analizzare le più importanti, da quelle sviluppate negli anni ’80 a quelle in uso oggi.

## ISA

Acronimo di *Industry Standard Architecture* è stata la tipologia di bus sviluppata da IBM nel 1981 per il suo PC che stava commercializzando in all’epoca. Il suo connettore era tipicamente nero.

Abituati a vedere nelle schede madri moderne già tutto l’hardware necessario per l’I/O, osservando quelle in uso fino ai primi del 2000 ci sembra strano che la maggior parte della superficie del PCB sia occupato da questi connettori a “pettine”; infatti anche solo i controller per i dischi ATA, le connessioni seriali per il mouse, per la stampante, schede grafiche e via discorrendo erano aggiunte alla scheda madre tramite ISA.

Esistevano tre versioni dello slot in rifermento al PC IBM su cui erano state implementale per la prima volta: XT a 62 contatti con un bus di 8 bit, AT a 98 contatti con un bus di 16 bit, retro-compatibile con la precedente ed un'altra, sempre a a 16 bit, ma con l'aggiunta di uno slot aggiuntivo chiamato VLB (VESA Local Bus) che aveva un accesso diretto alla memoria di sistema che lo rendeva molto più veloce. Nell'immagine seguente possiamo osservare le varie tipologie appena descritte.

![ISA](/blog/media/ISA.png "Scheda madre con slot ISA")

Interessante notare che non era quasi per nulla plug and play, infatti l’utente doveva configurare parametri come la linea IRQ, l’indirizzo I/O o il canale DMA.
La velocità di trasmissione dati era tra i 4 e i 5 MB/s che era adeguata per i compiti eseguiti all’epoca ma è stato il fattore che ne ha decretato l’estinzione quando non è stata più sufficiente.

## PCI

Utilizzato per lungo tempo ed ancora oggigiorno, è uno standard sviluppato da Intel a patire dal 1990 e approdato prima nei server e pochi anni dopo nei computer per uso professionale. E l’acronimo di *Peripheral Component Interconnect*, e viene largamente utilizzato per schede di rete, schede audio, controller USB e per dischi, sintonizzatori TV, ecc...

<a title="I, Jonathan Zander / CC BY-SA (http://creativecommons.org/licenses/by-sa/3.0/)"
href="https://commons.wikimedia.org/wiki/File:PCI_Slots_Digon3.JPG"><img width="512"
alt="PCI Slots Digon3"
src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/67/PCI_Slots_Digon3.JPG/512px-PCI_Slots_Digon3.JPG"></a>

Esistono vari standard a seconda della tensione di funzionamento (3,3V o 5V) e della larghezza del bus (32 o 64 bit).  
Quelle a 32 bit sono usate in ambito consumer ed hanno 62 contatti per ogni lato. Mentre quelle a 64 bit erano (ora sostituite dalla PCIe) implementate in sever e workstation. Queste ultime sono chiamate __PCI-X__ la cui X sta per eXtended da non confondere con Express (PCI-E o PCIe). Vediamo degli slot nell'immagine seguente:

![PCI-X](/blog/media/PCIslots.jpg "Scheda madre con slot PCI e PCI-X")

Hanno 32 contatti in più per lato rispetto alle 32 bit e sono separati, il che le rende retro-compatibili con le precedenti. Installando una PCI-X in una PCI lascerà i pin specifici della -X furi dal connettore richiedendo che nessun’altro componente della scheda madre lo ostacoli.
Parlando della tensione di funzionamento, che riguarda solo la prima parte del connettore (quella a 32 bit), le schede operanti a 3,3V hanno una tacca in corrispondenza dei pin 12 e 13 (altrimenti collegati a ground), invece quelle a 5V hanno la tacca a al posto dei pin 50 e 51. Esistono anche schede che hanno entrambe le tacche che entrano in qualsiasi connettore e sono chiamate universali. Le tacche sono inserite con lo specifico motivo di impedire fisicamente l’inserimento di schede incompatibili nel connettore posto sulla scheda madre, cosa che le danneggerebbe.

<a title="See page for author / CC BY-SA (https://creativecommons.org/licenses/by-sa/4.0)"
href="https://commons.wikimedia.org/wiki/File:PCI_Keying.svg"><img width="1024"
alt="PCI Keying"
src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/15/PCI_Keying.svg/1024px-PCI_Keying.svg.png"></a>

Esiste una variante per i portatili chiamata __miniPCI__ che occupa circa ¼ dello spazio e non accessibile dell’esterno del case.

![mini PCI](/blog/media/miniPCI.png "Scheda miniPCI")

In generale le PCI sono quasi del tutto plug and play ed addirittura la loro variante a 64 bit è anche installabile quando il calcolatore è già acceso.
La velocità di trasferimento può raggiungere:

- 133 MB/s per le 32-bit a 33 MHz
- 266 MB/s per le 32-bit a 66 MHz
- 266 MB/s per le 64-bit a 33 MHz
- 533 MB/s per le 64-bit a 66 MHz

## AGP

Sviluppata specificamente per poter collegare schede video e per soppiantare le PCI in questo ambito quando la parte grafica e videoludica ha assunto un ruolo importante dell’utilizzo del PC. È l’acronimo di *Accelerated Graphics Port* ed è stata progettata da Intel nel 1996 e negli anni a venire è stata largamente implementata nei calcolatori fino al 2004 quando la PCIe iniziava ad affacciarsi sul mercato.

![AGP](/blog/media/AGP.png "Scheda Video AGP")

È basata sostanzialmente sullo standard PCI. Un grande miglioramento fu dato dalla capacità di leggere le texture direttamente dalla RAM di sistema, mentre con la PCI bisognava copiarle prima nella memoria video della scheda grafica.
Aveva 66 connettori per lato con 1 mm di spazio tra ciascuno ma con 2 righe di connettori sfalsati distanti 2 mm.
Tenetevi forte perché le varianti di questo standard non sono poche ma anzi le varie case produttrici si sono divertite a crearne di proprie. Iniziamo proprio da loro:

+ __Ultra-AGP__: sviluppato da SiS, non una porta vera e propria ma un collegamento interno per le loro grafiche integrate.
+ __AGP Express__: un acrocchio per collegare una scheda AGP su una porta PCIe, ha un supporto parziale per le gpu e performace ridotte.
+ __AGI__: variante proprietaria di ASRock.
+ __AGX__: variante proprietaria di Epox.
+ __XGP__: variante proprietaria di Biostar.
+ __AGR__: come la AGP Express ma sviluppata da MSI e con compatibilità più estesa.

Invece le varianti ufficiali comprendono:

+ __AGP Pro__: usate principalmente per workstation, ha uno slot più lungo per ospitare più connettori atti a veicolare più potenza elettrica per schede più energivore. Era possibile usare una scheda non pro su un connettore pro ma non viceversa.
+ __AGP a 64-bit__: sviluppata e mai realizzata praticamente, migliorava la velocità di trasmissione verso la CPU.

Oltre alle varianti, in generale le AGP potevano funzionare a 3,3 V o a 1,5 V (più recenti) con tacche sul connettore come sulle PCI atti a impedire collegamenti errati.
Per quelle a 3,3 V era presente la tacca dal pin 22 al 25 mentre per le 1,5 V dal 42 al 45.
Anche qui esistevano gli slot universali che potevano ospitare qualsiasi scheda. Purtroppo però date le molte varianti poteva capitare che era possibile inserire fisicamente schede in porte incompatibili rischiando di danneggiare la gpu e la scheda madre.

<a title="The original uploader was JigPu at English Wikipedia. Later versions were uploaded by Aluvus at en.wikipedia. / CC BY-SA (https://creativecommons.org/licenses/by-sa/2.5)"
href="https://commons.wikimedia.org/wiki/File:AGP_%26_AGP_Pro_Keying.svg"><img width="512"
alt="AGP &amp; AGP Pro Keying"
src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/AGP_%26_AGP_Pro_Keying.svg/512px-AGP_%26_AGP_Pro_Keying.svg.png"></a>

La sua velocità di trasmissione poteva raggiungere i 2133 MB/s.

## PCIe

È l’evoluzione del PCI, oggigiorno è il più diffuso per il collegamento di periferiche interne ed esterne che richiedono una grande larghezza di banda. È l’acronimo di *Peripheral Component Interconnect Express* ed ha rimpiazzato quasi del tutto PCI, PCI-X e AGP (ha un connettore completamente diverso dalle precedenti per evitare qualsiasi equivoco). È stata sviluppata inizialmente da Intel, poi affiancata da vari partner commerciali a partire dal 2003.

<a title="Csendesmark / Public domain"
href="https://commons.wikimedia.org/wiki/File:PCI_Express.jpg"><img width="512"
alt="PCI Express"
src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/PCI_Express.jpg/512px-PCI_Express.jpg"></a>

Introduce il concetto di “linee”, ovvero più comunicazioni seriali che avvengono parallelamente. Vengono rappresentate con una x davanti al numero, nello specifico un bus PCIe può essere x1, x2, x4, x8, x16, x32. Le più diffuse sono x1 e x16. Il numero di linee determina la lunghezza del connettore. Fortunatamente la interoperabilità di schede e connettori con diverse linee è assicurata: sarà sempre possibile connettere una scheda PCIe con il numero di linee minore o uguale a quello del connettore, invece se è maggiore bisogna verificare che il connettore sia senza fine (come nella foto successiva), non esistono denti o tacche che impediscono l’inserimento fisico nella maggior parte dei casi.

<a title="Hans Haase / CC BY-SA (https://creativecommons.org/licenses/by-sa/4.0)"
href="https://commons.wikimedia.org/wiki/File:PCIe_J1900_SoC_ITX_Mainboard_IMG_1820.JPG"><img width="256"
alt="PCIe J1900 SoC ITX Mainboard IMG 1820"
src="https://upload.wikimedia.org/wikipedia/commons/a/a3/PCIe_J1900_SoC_ITX_Mainboard_IMG_1820.JPG"></a>

Anche qui esistono vare versioni ma la differenza di ognuna sta solo nella velocità massima raggiungibile. Comunque come per il discorso delle linee, è assolutamente possibile, per esempio, inserire una scheda con versione 1.1 in un connettore 4.0 o il contrario: la velocità sarà adeguata alla versione più bassa raggiunta dalla scheda o dal connettore.
A proposito di velocità, va da 250 MB/s per la V1.0 per poi moltiplicarsi per ogni linea e duplicarsi per ogni versione successiva fino ad arrivare a circa 32 GB/s per la V4.0 con 16 linee.
Il numero di pin va da 18 per la x1 a 82 per la x16, c’è solo una tacca tra il pin 11 e 12 presente in qualunque scheda PCIe.
Con questo standard di comunicazione è nato anche uno di alimentazione: un connettore può erogare fino a 66W, a volte non sufficienti. Per questo si collega un cavo proveniente dall’alimentatore del computer ad un connettore posto in alto a destra sulla scheda che può essere a 8, 6 o multipli di questi pin arrivando ad una potenza di 300W in totale.

Esiste una variante specifica per i portatili chiamate __MiniPCIe__, più piccola della sua controparte miniPCI.

<a title="© Raimond Spekking"
href="https://commons.wikimedia.org/wiki/File:Broadcom_BCM94311MCG_-_BCM4311KFBG-5346.jpg"><img width="512"
alt="Broadcom BCM94311MCG - BCM4311KFBG-5346"
src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/Broadcom_BCM94311MCG_-_BCM4311KFBG-5346.jpg/512px-Broadcom_BCM94311MCG_-_BCM4311KFBG-5346.jpg"></a>

Inoltre su questo stesso connettore è stata sviluppata l’interfaccia __M.2__ conosciuta come *Next Generation Form Factor* utilizzata per il collegamento di SSD e sta prendendo piede negli ultimi anni soprattutto in apparecchi portatili come ultrabook o tablet.
Esistono interfacce esterne che trasportano al loro interno linee PCIe tra cui __ExpressCard__ e __Thunderbolt__ con la caratteristica di poter essere collegate o scollegate con il pc accesso.

<a title="photo: Qurren / CC BY-SA (https://creativecommons.org/licenses/by-sa/3.0)"
href="https://commons.wikimedia.org/wiki/File:Logitec_LPM-ECSA32.jpg"><img width="512"
alt="Logitec LPM-ECSA32"
src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/57/Logitec_LPM-ECSA32.jpg/512px-Logitec_LPM-ECSA32.jpg"></a>

La prima, sviluppata nel 2003 è ormai caduta in disuso, Thunderbolt invece sta prendendo molto piede ultimamente venendo inserita dai produttori nelle loro schede madri di fascia alta: è stata sviluppata da Apple ed Intel ed adoperata dal 2011. Nella versione 1 e 2 aveva il connettore di una Mini DisplayPort, mentre nella sua ultima versione (3) ha il connettore USB-C (quindi è possibile inserirlo da entrambi i lati). In un singolo cavo vengono trasportati PCI-e x4, DisplayPort e alimentazione con la possibilità di collegare fino a 6 dispositivi in catena.

<a title="Amin / CC BY-SA (https://creativecommons.org/licenses/by-sa/4.0)"
href="https://commons.wikimedia.org/wiki/File:Thunderbolt_3_Cable_connected_to_OWC_Thunderbolt_3_Dock.jpg"><img width="256"
alt="Thunderbolt 3 Cable connected to OWC Thunderbolt 3 Dock" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Thunderbolt_3_Cable_connected_to_OWC_Thunderbolt_3_Dock.jpg/512px-Thunderbolt_3_Cable_connected_to_OWC_Thunderbolt_3_Dock.jpg"></a>

## Per approfondire:
<a href="http://www.youtube.com/watch?feature=player_embedded&v=PrXwe21biJo
" target="_blank"><img src="http://img.youtube.com/vi/PrXwe21biJo/0.jpg"
alt="Video PCIe" width="240" height="180" border="5" /></a>
<a href="http://www.youtube.com/watch?feature=player_embedded&v=tS99SDQ5BL0
" target="_blank"><img src="http://img.youtube.com/vi/tS99SDQ5BL0/0.jpg"
alt="Video Thunderbolt" width="240" height="180" border="5" /></a>
