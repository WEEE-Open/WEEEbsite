title: "GNU/Linux su un tablet 2-in-1 con Atom Bay Trail"
date: 2020-09-27T11:33:04+02:00
author: Andrea Mannarella
template: blogpost.php
abstract: Nel 2014-2015 andavano molto questi tablet di fascia medio-bassa con la tastiera rimovibile che si attaccava magneticamente al corpo del computer. Il loro problema era l'UEFI a 32 bit.
canonical: https://mannarella.it/posts/baytrail/
---
Nel 2014-2015 andavano molto questi tablet di fascia medio-bassa con la tastiera rimovibile che si attaccava magneticamente al corpo del computer. Nello specifico il mio è un **Acer Switch 10 SW5-012** ma la configurazione harware variava poco a seconda del produttore e del modello, ma in generale era così caratterizzata:

- CPU Intel Atom Z3735F della [serie Bay Trail](https://ark.intel.com/content/www/it/it/ark/products/codename/55844/bay-trail.html) @ 1.33GHz
- 2 GB di RAM DDR3L @ 1333 MHz
- Scheda grafica integrata Intel della serie Ivy Bridge
- 32 GB di storage EMMC
- Display touchscreen IPS 1280x800
- Wi-Fi b/g/n + Bluetooth 4.0

Specifiche che non facevano gridare al miracolo, ma per la fascia di prezzo di 200-300€ (su alcuni modelli vi era anche il digitalizzatore Synaptic per la penna, molto comoda per prendere appunti, o altre caratteristiche che lo facevano salire di prezzo) erano accettabili visto anche il periodo.

Il computer montava Windows 8.1 32 bit al rilascio, poi aggiornato a 10 ma non ha mai visto software a 64 bit, nonostante la CPU lo permettesse. Anche provando ad installare manualmente la versione a 64 bit non si trovavano i driver per molte delle periferiche, rendendolo quasi inutilizzabile. Ora che Microsoft ha dismesso le versioni a 32 bit, ci si ritrova con un sistema operativo abbandonato dal produttore e in balia del primo hakerino che vuole divertisi un po', soprattutto ora che è stato leakato il sorgente di XP[^1].

Per non parlare della memoria di massa: praticamente una scheda SD saldata con limitate capacità di storage e velocità, rendono l'utilizzo del dispositivo quasi snervante, considerando anche i soli 2 GB di RAM che contringono l'OS a swappare (o meglio *usare il file di paging* per dirlo alla Windows) tutti i tab di Chrome dopo il primo e la *telemetria* di Windows che ci mette del suo per ucciderlo del tutto.

L'unico modo per renderlo utilizzabile oggigiorno è quello di purgare Windows e installarci una bella e moderna distro  GNU/Linux, ma la questione è più complicata del previsto perché quella diavoleria del bootloader UEFI è a 32 bit e sembra che abbiano volutamente reso complicato la vita a chiunque cerchi di far partire un SO diverso da quello preinstallato.

Come distro ho scelto Linux Mint XFCE per la leggerezza dell'ambiente grafico e per l'ampio sofware già installato e configutato, ma il procedimento dovrebbe essere il medesimo per qualsiasi distro scegliate e per il modello di tablet Bay Trail che avete, magari con delle differenze nelle impostazioni del BIOS.

## Preparazione

- Abbiamo bisogno di una chiavetta USB da almeno 2 GB e una notte in bianco (quale momento migliore sennò).
- Vi consiglio di leggere tutta la guida prima di fare qualsiasi cosa, per avere le idee chiare su ogni passaggio.
- Ovviamente fate un backup dei file che vi servono, anche sulla scheda micro-SD.
- Siccome molto probabilmente questo computer non vedrà più Windows, è conveniente aggiornare il BIOS all'ultima versione prima di iniziare. Nel mio caso montavo la V1.18 mentre l'ultima è la V1.20 scaricabile dal [sito Acer](https://global-download.acer.com/GDFiles/BIOS/BIOS/BIOS_Acer_1.20_A_A.zip?acerid=635943075181893127&Step1=NOTEBOOK&Step2=ASPIRE%20SWITCH&Step3=SW5-012&OS=10M2&LC=it&BC=ACER&SC=EMEA_17).

Ora possiamo iniziare!

### Chiavetta

1. Direttamente dal tablet con Windows scarichiamo l'[ISO della distro](https://linuxmint.com/download.php) e [Rufus](https://rufus.ie).
2. Una volta terminato inserite la chiavetta (salvatevi i file che avete sopra magari), aprite Rufus, selezionate l'unità corretta, l'immgine scaricata, schema partizione **GPT**, sistema destinazione **UEFI** e file system **FAT32** e infine AVVIA. Questa operazione è necessaria farla in questo modo perché dobbiamo poter inserire un file dopo la copia. Con dd o balenaEtcher dopo aver copiato l'immagine non è possibile scrivere più nulla nella chiavetta.[^3]
3. Nel frattempo scaricate il file [bootia32.efi](https://github.com/hirotakaster/baytail-bootia32.efi/raw/master/bootia32.efi) e schiaffatelo in `/EFI/BOOT/bootia32.efi` quando Rufus avrà terminato.
4. Dite addio a Windows e spegnete.

### Boot

1. Accendetelo premendo **F2** per entrare nelle impostazioni del BIOS.
2. Nella sezione *Security* impostate una password nella sezione *Supervisor Password*.
3. Ora nella sezione *Boot* potete disattivare la voce *Secure Boot*.
4. Impostate *USB HDD* primo nella lista.
5. Salvate e uscite

## Installazione

1. Al riavvio partirà la live di Mint, non avviate subito l'installazione ma aprite un terminale e eseguite  `ubiquity --no-bootloader`. Installeremo GRUB in seguito.
2. Proseguite come di consueto nell'installazione ma al momento del partizionamento dei dischi scegliete la via manuale e replicate il seguente schema:

| Partizione | File system | Punto di montaggio | Dimensione |
| :--------- | ----------- | ------------------ | ---------- |
| mmcblk1p1  | fat32       | /boot/efi          | 100MB      |
| mmcblk1p2  | ext2        | /boot              | 300MB      |
| mmcblk1p3  | ext4        | /                  | il resto   |
| mmcblk1p4  | swap        |                    | 4GB        |

La scheda micro-SD funziona in sola lettura, per ora.

3. Prendete nota della partizione di root, ci servirà in seguito.
4. Proseguite e, una volta terminato il processo, spegnete il PC.

### Grub

Non essendo ancora installato alcun bootloader dobbiamo appogiarci ancora a quello della chiavetta, pertanto rifacciamo partire da lì, ma dal menù di GRUB aprite la linea di comando premendo *c* sulla tastiera.

con `ls` vediamo la lista di tutti i dischi e le partizioni `(hd0), (hd0,gpt1), (hd2), ...` di solito il disco interno è `hd1` ma potete scoprirlo digitando `ls (hd` e premendo tab verranno fuori i suggerimenti. 

1. Individuate la partizione di boot cretata nel passo precedente (quella da 300MB ext2 per intenderci) e eseguite modificando opportunamente:
```
set root=(hd1,gpt2)
```
2. Dopodiché ricordatevi la partizione root che avete segnato prima e eseguite anche qui modificando:
```
linux /vmlinuz root=/dev/mmcblk1p3
initrd /initrd.img
boot
```
Se tutto fila liscio, vi ritroverete nell'ambiente installato precedentemente.[^4]

3. Aprite un terminale e installate `grub-efi-ia32 grub-efi-ia32-bin` nel mio caso da `apt`, essendo su Mint.
4. Installiamo finalmente GRUB con:
```bash
sudo grub-install --target=i386-efi --efi-directory=/boot/efi/
sudo grub-mkconfig -o /boot/grub/grub.cfg
```
5. Se volete personalizzare le impostazioni, potete farlo in `/etc/default/grub` prima di eseguire l'ultimo comando:
```bash
sudo update-grub
```
Giusto per scrupolo potete vedere con `efibootmgr` se compare l'entry all'interno della lista di boot.
6. A questo punto spegnete il computer e togliete la chiavetta.

### Secure Boot

1. Riaccendetelo e entrate ancora nei settaggi del BIOS.
2. Inserite la password, andate su *Boot* e riattivate il *Secure Boot*.
3. Salvate e uscite.
4. Rientrate nel BIOS.
5. Su *Security* cliccate su *Select an UEFI file as trustedfor executing:*.
6. Navigate su `HDD0/EFI/ubuntu` e selezionate `grubia32.efi`.
7. Nello spazio bianco sotto la scritta *Do you whish to add this file to allowable database?* scrivete *Linux* (o quello che vi pare)
8. Salvate e uscite.
9. Rientrate nel BIOS per l'ulima volta 🤯.
10. Su *Boot* disabilitate il *Secure Boot* e impostate *Linux* come primo nella lista.
11. Salvate e uscite.

Riavviatelo, se parte senza fare storie non mi resta che farvi i complimenti!

## Ultimi ritocchi

Sfortunatamente alcuni dispositivi non funzionano ma potrebbero uscire patch per risolvere, ad oggi la situazione con il kernel 5.4.0 è la seguente:

- [x] tastiera
- [x] touchpad
- [x] touchscreen
- [x] bluetooth
- [x] livello della batteria
- [x] Wi-Fi
- [ ] scheda micro-SD (sola lettura)
- [x] audio (con patch)
- [ ] stand-by
- [ ] regolazione luminosità
- [ ] webcam
- [x] rotazione schermo (l'hardware viene rilevato con `monitor-sensor` ma XFCE non ha il supporto per la rotazione)
- [ ] micro-HDMI

### Audio

Se l'audio funziona solo dalle cuffie, è semplice risolvere:
```bash
git clone https://github.com/plbossart/UCM.git
sudo cp -rf UCM/bytcr-rt5640 /usr/share/alsa/ucm
sudo -i
echo 'blacklist snd_hdmi_lpe_audio' >> /etc/modprobe.d/50-block-hdmi-audio.conf
reboot
```

### Tastiera su schermo

Essendo un tablet, è ragionevole poterlo usare senza tastiera, per farlo basta attivare Onboard (già preinstallato), anche nella schermata di login.

### Scroll su Firefox

Il touchscreen funziona perfettamente, anche con più dita, ma Firefox va abilitato ad utilizzarlo per poter scorrere le pagine. Per farlo bisogna aggiungere `MOZ_USE_XINPUT2 DEFAULT=1` nel file `/etc/security/pam_env.conf` e andare su `about:config` da Firefox e settare `dom.w3c_touch_events.enabled` su `1` (default `2`). Riavviate il tablet per vedere i risultati.

### Errore durante update-initramfs

Se durante un `full-upgrade` dovesse fallire `update-initramfs`, basta eliminare un kernel vecchio dopo il riavvio. Vedete quale è di troppo con `dpkg --list | grep linux-image` e purgatelo.

### Regolazione luminosità schermo

Pare che nel kernel 5.6 il bug sia sistemato, quindi avete tre possibilità: aspettate che Ubuntu lo distribuisca, lo installate manualmente o usate una distro che già lo usa. Per ora è fissa al massimo con conseguente calo della durata della batteria aggravata dall'impossibilità della sospensione.

## Conclusioni

Peccato per i dispositivi che non vengono riconosciuti, soprattutto la webcam in questo periodo di smart working e DaD, ma confido che qualche utente su qualche blog o forum abbia già trovato una soluzione. Nel caso editerò questo articolo.

Per il resto il computer si comporta molto bene, in rapporto al suo hardware. La navigazione con Firefox e l'utilizzo office sono soddisfacenti con [uBlock Origin](https://addons.mozilla.org/it/firefox/addon/ublock-origin/). La riproduzione di video su Youtube è fluida, fino al 1080p. Addirittura giochi 3D come SuperTuxKart[^2], ovviamente con i settaggi al minimo, riescono a girare dignitosamente, al contrario di Windows.

### Note

[^1]:[https://tech.everyeye.it/amp/notizie/pubblicato-4chan-codice-sorgente-windows-xp-non-buona-notizia-470759.html](https://tech.everyeye.it/amp/notizie/pubblicato-4chan-codice-sorgente-windows-xp-non-buona-notizia-470759.html)

[^2]:Mi raccomando installate la versione &geq;1.2 per avere il supporto completo al touchscreen e ai controller. Su Debian e derivate basta aggiungere il repository `ppa:stk/dev`

[^3]:Curioso che uno dei miei sofware preferiti su Windows sia proprio uno che serve a toglierlo. [semicit. Mike Party]

[^4]:Probabilemte è possibile installare Grub anche in chroot o direttamente dall'ambiente live usando anche il paramentro `--boot-directory=/mnt/boot`, ma con me non ha funzionato.
