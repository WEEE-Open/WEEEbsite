title: "Gestione dell'alimentazione, parte 1: definizione degli stati ACPI"
date: 2017-09-01T10:00:00Z
template: blogpost.php
author: Federico Bassignana
abstract: Questo è il primo di una serie di articoli riguardanti le tecniche utilizzate dalle case produttrici di pc per gestire il sistema di alimentazione nei loro dispositivi. Quanto scritto fa riferimento all'elettronica presente nei laptop ma, a livello teorico, non si discosta di molto ciò che avviene anche nei desktop; mentre a livello pratico le cose posso essere abbastanza diverse, infatti i desktop verranno trattati più avanti. 
---
## Introduzione
Questo è il primo di una serie di articoli riguardanti le tecniche utilizzate dalle case produttrici di pc per gestire il sistema di alimentazione nei loro dispositivi. 
Quanto scritto fa riferimento all'elettronica presente nei laptop ma, a livello teorico, non si discosta di molto ciò che avviene anche nei desktop; mentre a livello pratico 
le cose posso essere abbastanza diverse, infatti i desktop verranno trattati più avanti. 
 
Nel corso degli anni le maggiori case produttrici hanno sviluppato in comune accordo standard di gestione energetica al fine di avere una maggiore compatibilità tra i loro dispositivi.
Nel 1992 venne introdotto lo standard **APM** (*Advanced Power Management*), tuttavia presto diventato obsoleto a causa di una sempre maggiore necessità di risparmio energetico.
Venne infatti rimpiazzato dalla [specifica **ACPI**](http://www.uefi.org/acpi/specs) (*Advanced Configuration and Power Interface*), di cui si occupa questo articolo e che permette un controllo completo dell'alimentazione direttamente dal sistema operativo, a differenza del precedente metodo che ne permetteva la gestione attraverso il BIOS.
 
La specifica ACPI definisce, tra le altre cose, degli **stati** che descrivono il comportamento delle principali componenti del computer in base al risparmio energetico desiderato. Quindi di fatto la specifica definisce ogni componente, nonché l'intero computer, come una macchina a stati finiti, dal punto di vista della gestione energetica.   
Gli stati a loro volta sono suddivisi in più livelli che crescono quanto pi&ugrave; il sistema risparmia energia, (WIP)
 
Prima di tutto bisogna specificare che ogni dispositivo è alimentato dall'alimentazione principale e da un'alimentazione secondaria sempre presente (Se non diversamente specificato) di circa 3.3 V (WIP).
Quest'ultima svolge un ruolo importante in diverse situazioni come pper esempio tener alimentati dei moduli quando il pc rimane spento (e.g. RTC, WakeOnLan) . Quando si parler&agrave; di consumi 
ci si riferir&agrave; all'aalimentazione principale.
 
La specifica ACPI fa riferimento in vari punti al contesto del sistema (*system context*) e al contesto del dispositivo (*device context*): questi non sono altro che "dati variabili" memorizzati nel dispositivo e necessari al suo immediato funzionamento. Ad esempio, su una CPU il contesto potrebbe indicare il contenuto dei registri, su un dispositivo USB il suo indirizzo sul bus, e così via.
La specifica stabilisce in quali stati i contesti devono essere mantenuti, in quali possono essere persi, e in quali vengono persi dall'hardware ma è richiesto al sistema operativo di implementare un metodo per salvarli in modo permanente.
  
## Stati G (Sistema Globale)
Sono stati che descrivono la percezione che ha l'utente finale del sistema complessivo, cioè del computer.

* _G0_: 
    * Il sistema è completamente funzionante e alimentato con il 100% dell'energia a disposizione
    * Alcuni dispositivi in quel momento inutilizzati potrebbero essere in uno stato "addormentato", purché possano tornare a uno stato di funzionamento in tempi brevi
* _G1_ "Sistema addormentato": 
    * Il pc sembra spento pur non essendolo effettivamente, i consumi in generale sono ridotti
    * La sessione di lavoro può essere ripristinata senza necessariamente riavviare il sistema
    * I contesti relativi ai processi sono salvati in memoria
* _G2_ Spegnimento software:
    * Il pc comsuma piccole quantità di energia
    * Per ripristinare la sessione di lavoro c'è un'alta latenza (riavvio del sistema)
    * Nessun contesto viene salvato dall'hardware, ma può essere salvato preventivamente dal sistema operativo (WIP)? (ibernazione = G2?)
* _G3_ Spegnimento meccanico:
    * Azionato da un comando meccanico (tasto ON/OFF)
    * Il sistema deve essere riacceso col medesimo tasto, poi riavviato per ripristinare la sessione (WIP) (altrimenti si può pensare che il normale tasto di accensione sia quello del G3. La specifica non dà definizioni chiare, fa solo l'esempio di "un grande tasto rosso"...)
    * Non viene consumata energia

## Stati S
Sono stati che descrivono cosa accade a livello di sistema. S0 è associato a G0, S1-S4 si trovano all'interno di G1 e S5 è associato a G2. 

* _S0_ stato attivo:
    * Il computer è alimentato, l'utente finale utilizza l'apparecchio
* _S1_ / _S2_ stati "addormentati" (solitamente inutilizzati): 
    * _S1_:
        * Breve tempo di riaccensione
        * Nessun contesto viene perso
    * _S2_:
        * Breve tempo di riaccensione
        * Vengono persi il contesto della CPU e le cache 
* _S3_ stato "addormentato" (e.g. stand-by, sospensione in RAM):
    * Breve tempo di ripristino della sessione
    * Il sistema operativo salva nella RAM i contesti di tutte le unità come CPU, chipset e dispositivi di I/O, che vengono spenti
    * Al "risveglio" il sistema operativo ripristina i contesti dalla RAM. Questo permette un risveglio del sistema piuttosto rapido ma l'inconveniente è che se viene a mancare corrente la sessione di lavoro viene persa, in quanto la RAM è volatile  
    * La memoria viene copiata in un file su memorie di massa (letteralmente "Memory image" -> copia della memoria virtuale dei processi, per salvare lo stato del sistema) e viene comunque mantenuta alimentata. (WIP) (il normale standby non salva nulla sulla memoria di massa!)
	* I dispositivi possono essere in stati non spenti (WIP)
* _S4_ stato "addormentato" (ibernazione, sospensione su hard disk):
    * Alta latenza per tornare allo stato attivo (_S0_)
    * In questo livello anche la RAM viene spenta
    * Tutti i contesti del sistema vengono salvati in un file su memoria di massa
    * Al risveglio il sistema operativo ripristina i contesti dal file
    * I dispositivi devono essere spenti (WIP)
* _S5_ spegnimento software:
    * Simile allo stato _S4_ ma il sistema operativo non salva nessun contesto
    * Per riavviare la sessione è necessario un riavvio completo del sistema operativo

## Stati C

Descrivono il comportamento della CPU. Si trovano tutti all'interno dello stato G0.

* _C0_:
    * La CPU esegue le istruzioni normalmente
* _C1_:
    * La CPU si trova in uno stato in cui *non* esegue istruzioni
    * Bassa latenza di ripristino della sessione
    * Mediante software viene ridotta la frequenza interna della CPU (*Dynamic Frequency Scaling*, conosciuto anche come *CPU throttling*) (WIP) (è previsto dalla specifica? nella sezione 2.5 non viene detto)
* _C2_ :
	* È necessario più tempo per "risvegliare il sistema", cioè tornare allo stato C0, ma i consumi sono più bassi rispetto allo stato C1
* _C3_:
	* Richiede più tempo per il risveglio
    * Le cache non vengono più aggiornate quindi al risveglio non saranno più valide 

Il passaggio dallo stato C0 a C1 avviene, nei processori x86, tramite l'istruzione **HLT** (*halt*) che interrompe l'esecuzione di ulteriori istruzioni fino alla ricezione di una richiesta di interrupt, che riporta il processore nello stato C0.  
Linux talvolta utilizza le istruzioni **MWAIT** o **MWAITX**, ma a grandi linee il funzionamento è lo stesso.  
Il firmware ACPI indica al sistema operativo la latenza di caso peggiore per tornare dagli stati C2 e C3 allo stato C0, mentre per lo stato C1 la specifica richiede che sia così bassa da "non preoccuparsene": è il sistema operativo a decidere quale passare a questi stati, in base al carico di lavoro e alla massima latenza accettabile.

Negli stati C1 e successivi di solito viene effettuato *clock gating* per interrompere la distribuzione del clock, e quindi azzerare il consumo di potenza dinamico dei transistor, su tutte le parti del processore ad eccezione di quelle che devono rilevare interrupt o altri eventi esterni.  
Nello stato C3 non viene più distribuito segnale di clock all'interno della CPU.  
La differenza tra C1 e C2 è che il primo viene raggiunto tramite un'istruzione macchina, mentre il secondo con altri meccanismi che di solito si traducono nell'inviare un segnale a un piedino del processore, oltre al fatto che lo stato C2 ha consumi più bassi e latenza di uscita più alta rispetto al C1.

Su Linux è possibile visualizzare il tempo speso dal processore nei vari stati tramite il comando `cpupower`.  
Ad esempio, `cpupower monitor -i 10` restituisce queste informazioni, relative agli ultimi 10 secondi:
```
    |Mperf               || Idle_Stats         
CPU | C0   | Cx   | Freq || POLL | C1   | C2   
   0|  9,17| 90,83|  1772||  0,00|  7,92| 83,15
   1|  4,18| 95,82|  1457||  0,00|  4,74| 91,20
   2|  7,72| 92,28|  1591||  0,00|  7,69| 84,80
   3|  3,90| 96,10|  1422||  0,00|  3,71| 92,52
   4|  7,32| 92,68|  1413||  0,00|  8,03| 84,86
   5|  8,95| 91,05|  1596||  0,00|  6,63| 84,53
   6| 10,61| 89,39|  1604||  0,00|  8,02| 81,57
   7|  3,39| 96,61|  1495||  0,00|  7,29| 89,43
```
Gli 8 core del processore sono considerati come processori separati. Prendendo ad esempio il core 0, si può notare che ha passato circa il 9% del tempo nello stato C0, ad una frequenza media di 1.77 GHz (alternando tra 1.4 e 1.9 GHz a causa del Dynamic Frequency Scaling, ma non è indicato dall'output del comando), e circa l'8% e l'83% del tempo negli stati C1 e C2, rispettivamente.

Lo stato C3 non è supportato dal processore in questione, mentre POLL non è un vero stato: si tratta di un ciclo di busy wait, utilizzato dal sistema operativo quando sono imminenti altre operazioni e la latenza per entrare e uscire dallo stato C1 sarebbe troppo alta, ma ciò è fuori dall'ambito della specifica ACPI.

### Stati C addizionali

Alcuni processori, soprattutto quelli per laptop, più sensibili alla questione del risparmio energetico, talvolta supportano stati C addizionali. Come sempre, più il numero dello stato cresce, più i consumi diminuiscono e la latenza per tornare allo stato C0 aumenta:

* _C1E_ (Intel):
	* Viene ridotta anche la tensione (*Dynamic Voltage Scaling*, conosciuto anche come *undervolting*)
	* È utilizzato in alternativa allo stato C1
* _C1E_ (AMD):
	* Viene interrotta la distribuzione di clock all'interno della CPU, come nel C3
	* Viene raggiunto in automatico dalla CPU quando tutti i core si trovano nello stato C0
* _C2E_:
	* Viene ridotta anche la tensione
	* È utilizzato in alternativa allo stato C2
* _C4_, _C4E_, _C6_:
	* Viene ridotta anche la tensione (anche a 0 V nel caso di C6)

Poiché nei dispositivi mobili la CPU è uno dei componenti che consumano di più e che meglio si prestano a complesse operazioni di risparmio energetico (mentre su uno schermo, ad esempio, a parte ridurre la luminosità non si può fare molto), [esistono altre sottili differenze e sotto-stati](http://www.hardwaresecrets.com/everything-you-need-to-know-about-the-cpu-c-states-power-saving-modes/), ma esulano dall'ambito di questo articolo e talvolta anche dalla specifica ACPI.

## Stati P

(WIP) (sezione 2.6, validi in C0 e D0 (!), definiti in appendice A)

## Stati T

(WIP) (sono obsoleti. Fine.)

## Stati D
Sono stati che descrivono il comportamento di tutti i vari dispositivi collegati al sistema.
    * _D0_ Completamente operativo:
        * Il dispositivo è completamente attivo;
	* _D1_ , _D2_ :
		Sono stati intermedi, quindi non ben documentaati nelle specifiche, le loro caratteristiche variano da periferica a periferica;
	* _D3_:
		Si suddivide in 2 sotto livelli di transizione:
		* _D3<sub>HOT</sub>_ :
			* Viene ancora fornita l'alimentazione al dispositivo;
			* Si alza il livello dello stato Link a _L1_ in modo che il dispositivo non supporti pi&ugrave; il clock fornito dal bus, se è dispositivo PCIe
		* _D3<sub>COLD</sub>_:
			* L'alimentazione principale viene totalmente rimossa dal dispositivo;
			* Si porta lo stato Link al livello:
				1. _L2_ se l'alimentazione ausiliaria (AUX) è supportata dal dispositivo;
				2. _L3_ in caso contrario;
			* Il clock del BUS PCI viene interrotto;

## Stati L
Descrivono il comportamento dell' interfaccia PCIe
* _L0_:
    * Il bus funziona a regime;
* _L0<sub>s</sub>_ IDLE elettrico (autonomo):
    * bassa latenza di uscita (circa 1 μs); 
    * Viene ridotto il consumo energetico anche se questo IDLE duranta brevi intervalli di tempo visto che un livello di transizione; 
    * In ogni permutazione di stato (_L0_  &#8592;&#8594; _L1_)è necessario passare per questo livello
* _L1_ IDLE elettrico (Richiamato da un livello superiore):
    * Bassa latenza di uscita (circa 2-4 μs)
    * Livello gestito dal protocollo ASPM (Active State Power Management, protocollo definito per aumentare il risparmio energetico nelle periferiche PCIe, porta il livello dello stato Link da 0 a _L2_ / _L3 READY_;
    * In assenza di operazioni attive sull'interfaccia viene ridotta l'alimentazione;
    * Sono inoltre possibili delle ulteriori operazioni per il risparmio energetico:
        * Spegnimento di tutti i dispositivi radio;
        * **Clock gating** sulla maggior parte delle porte PCIe (viene ridotta ulteriormente la frequenza);
        * Spegnimento PLL (Phase Locked Loop, sono circuiti di controllo molto usati nelle telecomunicazioni che permettono di ottenere, dato un segnale in ingresso, uno in uscita con la 
            stessa fase di quello in entrata);
* _L2_ / _L3 READY_:
    * Fase di transizione tra gli stati _L0<sub>s</sub>_ a _L2_ / _L3_
    * Prepara la porta PCIe a rimuovere la tensione d'alimentazione e il clock;
    * Il dispositivo si trova in _D3<sub>HOT</sub>_ e si prepara per entrare nel livello _D3<sub>COLD</sub>_;
* _L2_:
	* Il dispositivo alimentato dalla tensione AUX
    * In questo livello agisce il segnale **WAKE#** ('#' sta a indicare che si attiva quando il segnale ha valore logico 0) necessario ad avviare il computer da remoto attraverso il WakeOnLan
* _L3_:
    * Vengono rimossi l'alimentazione e il clock
    * Il dispositivo è completamente spento visto che la tensione AUX non è supportata;
    * Per uscire da questo stadio è necessario un riavvio del sistema;
 
Tutti gli stati appena descritti sono riassunti nella seguente immagine dove vengono collocati secondo una linea temporale tutte le fasi necessarie per lo spegnimento di un computer.
<img alt="Tabella riassuntiva degli stati ACPI" title="Tabella riassuntiva degli stati ACPI" src="media/states.png" class="decorativa">
Nel prossimo articolo si inizierà a vedere come questa specifica viene effettivamente implementata a livello hardware nei notebook.       


