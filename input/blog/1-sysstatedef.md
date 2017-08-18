Gestione dell'alimentazione dei notebook
----------------------------------------------------
Questo &egrave; il primo di una serie di articoli riguardanti le tecniche utilizzate dalle case produttrici di pc per gestire il sistema di alimentazione nei loro dispositivi. 
Quanto scritto &egrave; strettamente legato all'elettronica presente nei laptop ma, a livello teorico, non si discosta di molto ci&ograve; che avviene anche nei desktop, mentre a livello pratico 
le cose posso essere abbastanza diverse infatti i desktop verranno trattati pi&ugrave; avanti. 
 
Nel corso degli anni le maggiori case produttrici in comune accordo hanno sviluppato standard di gestione energetica al fine di avere una maggiore compatibilità tra dispositivi.
A inizio / metà anni 90 venne introdotto lo standard **APM** (Advanced Power Management) presto diventato obsoleto a causa di una sempre maggiore necessità di risparmio energetico.
Venne infatti rimpiazzato dalla specifica **ACPI** (Advanced Configuration Power Interface) che permette un controllo completo dell'alimentazione direttamente dal sistema operativo 
(a differenza del precedente metodo che ne permetteva la gestione attraverso il BIOS) .
 
 Per semplificare queste specifiche sono stati definiti degli stati che descrivono il comportamento delle principali componenti del pc. A loro volta sono suddivisi in più livelli che crescono quanto pi&ugrave; il sistema risparmia energia,
 
Prima di tutto bisogna specificare che ogni dispositivo &egrave; alimentato dall'alimentazione principale e da un'alimentazione secondaria sempre presente (Se non diversamente specificato) di circa 3.3 V.
Quest'ultima svolge un ruolo importante in diverse situazioni come pper esempio tener alimentati dei moduli quando il pc rimane spento (e.g. RTC, WakeOnLan) . Quando si parler&agrave; di consumi 
ci si riferir&agrave; all'aalimentazione principale.
 
Pi&ugrave; avanti parleremo dei contesti relativi ai processi che non sono altro che informazioni sul stato attuale di esecuzione che devono essere memorizzate così che quando è nuovamente
 schedulato per l'esecuzione sul processore pu&ograve; riprendere le sue operazioni da una posizione identica. Ci si render&agrave; conto che in diversi questi contesti verranno persi; questo avviene 
 a livello di specifica, mentre in pratica ogni OS implementa sistemi per salvarli in modo permanente.
  
1. Stati G (Sistema Globale):
Sono stati che descrivono la percezione che ha l'utente finale del sistema.
    * _G0_: 
        * Il sistema è completamente funzionante e alimentato con il 100% dell'energia a disposizione; 
    * _G1_ "Sistema  addormentato": 
        * Il pc sembra spento pur non essendolo effettivamente, i consumi in generale sono ridotti;
        * La sessione di lavoro pu&ograve; essere ripristinata senza necessariamente riavviare il sistema; 
        * I contesti relativi ai processi sono salvati in memoria;
        
    * _G2_ Spegnimento software: 
        * Il pc comsuma piccole quantit&agrave; di energia 
        * Per ripristinare la sessione di lavoro c'&egrave; un'alta latenza; 
        * Nessun processo viene salvato, &egrave; necessario riavviare il sistema; 
    * _G3_ Spegnimento meccanico:
        * Azionato da un comando meccanico (switch ON/OFF) 
        * Il sistema deve essere riavviato per ripristinare la sessione;
        * Non viene consumata energia;
 
 2.  Stati S:
    Sono stati che descrivono cosa accade a livello di sistema.
    * _S0_ stato attivo:
        * Il computer è alimentato, ci troviamo nella situazione in cui l'utente finale utilizza l'apparecchio;
    * _S1_ / _S2_ stati "addormentati" (solitamente inutilizzati): 
        * _S1_:
            * Breve tempo di riaccensione;
            * Nessun processo viene perso; 
        * _S2_:
            * A differenza dello stato _S1_ i contesti presenti nella CPU e nelle cache vengono persi; 
    * _S3_ stato "addormentato" (e.g. stand-by, sospensione in RAM):
        * Breve tempo di ripristino della sessione; 
        * La memoria viene copiata in un file su memorie di massa (letteralmente "Memory image" -> copia della memoria virtuale dei processi, per salvare lo stato del sistema) 
			e viene comunque mantenuta alimentata.
        * Le unit&agrave; come CPU, Chipset, dispositivi di I/O mandano i contesti alla RAM, che sar&agrave; l'unico dispositivo rimasto alimentato, e vengono spenti. 
			Questo permette di avere un "risveglio" del  sistema piuttosto rapido ma l'inconvegnente &egrave; che se viene a mancare corrente tutto viene perso;  
    * _S4_ stato "addormentato" (Ibernazione, sospensione su Hard Disk):
        * Alta latenza per tornare allo stato attivo (_S0_);
        * In questo livello anche la RAM viene spenta;
        * Tutti i contesti del sistema vengono salvati in un file su memoria di massa;
     * _S5_ spegnimento software:
        * Simile allo stato _S4_ ma il sistema operativo non salva nessun contesto; 
        * Per riavviare la sessione &egrave; necessario un riavvio completo del sistema operativo;
3. Stati D:
Sono stati che descrivono il comportamento di tutti i vari dispositivi collegati al sistema.
    * _D0_ Completamente operativo:
        * Il dispositivo è completamente attivo;
	* _D1_ , _D2_ :
		Sono stati intermedi, quindi non ben documentaati nelle specifiche, le loro caratteristiche variano da periferica a periferica;
	* _D3_:
		Si suddivide in 2 sotto livelli di transizione:
		* _D3<sub>HOT</sub>_ :
			* Viene ancora fornita l'alimentazione al dispositivo;
			* Si alza il livello dello stato Link a _L1_ in modo che il dispositivo non supporti pi&ugrave; il clock fornito dal bus;
		* _D3<sub>COLD</sub>_:
				* L'alimentazione principale viene totalmente rimossa dal dispositivo;
				* Si porta lo stato Link al livello:
					1. _L2_ se l'alimentazione ausiliaria (AUX) &egrave; supportata dal dispositivo;
					2. _L3_ in caso contrario;
				* Il clock del BUS PCI viene interrotto;
4. Stati C:
    Descrivono il comportamento della CPU.
    * _C0_:
        In questo stato la CPU esegue le istruzioni normalmente;
    * _C1_:
        * Bassa latenza di ripristino della sessione;
        * La CPU si trova in uno stato in cui NON esegue istruzioni;
        * Mediante software viene ridotta la frequenza interna della CPU (Dynamic Frequency Scaling, conosciuto anche come **CPU throttling**)
    * _C2_ :
        * Viene ridotta anche la tensione (Dynamic voltage Scaling, conosciuto anche come **Undervolting**)
        * &Egrave; necessario più tempo per "risvegliare il sistema";
     * _C3_:
        * Vengono spenti il generatore di clock e le cache;
        * Richiede pi&ugrave; tempo per il riavvio;
5. Stati L:
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
        * Il dispositivo &egrave; completamente spento visto che la tensione AUX non &egrave; supportata;
        * Per uscire da questo stadio è necessario un riavvio del sistema;
 
 Tutti gli stati appena descritti sono riassunti nella seguente immagine dove vengono collocati secondo una linea temporale tutte le fasi necessarie per lo spegnimento di un computer.
 ![](media/states.png?raw=true)
 Nel prossimo articolo si inizierà a vedere come questa specifica viene effettivamente implementata a livello hardware nei notebook.       


