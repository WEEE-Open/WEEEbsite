---
title: Ubuntu OEM install via PXE
date: 2018-05-04T17:00:00Z
template: blogpost.php
author: Ludovico Pavesi
abstract: Da un po' di tempo abbiamo iniziato a effettuare installazioni OEM di Xubuntu sui computer che abbiamo riparato. Avviando il sistema tramite PXE non si può accedere al menu in cui selezionare "Installazione OEM"
---

Da un po' di tempo abbiamo iniziato a effettuare installazioni OEM di Xubuntu sui computer che abbiamo riparato.

La modalità di [installazione OEM](https://askubuntu.com/a/157821), presente su Ubuntu e tutte le distribuzioni derivate come Xubuntu, consente di installare il sistema operativo, effettuare alcune personalizzazioni utilizzando un account temporaneo (ad esempio installiamo anche VLC su tutti i computer) e poi "preparare il computer per la spedizione": al successivo avvio l'account temporaneo viene eliminato e viene chiesto all'utente finale che username e password utilizzare.

Il risultato ha un aspetto decisamente più professionale che fornire computer con username e password scelti da noi, anche se si possono cambiare.

Tuttavia, di recente abbiamo completato la costruzione di un server PXE per avviare tramite LAN l'installazione, ma con tale modalità non si può accedere al menu in cui selezionare "Installazione OEM". 

Ricordavo di aver trovato su internet il parametro da passare al kernel, anche se probabilmente lo legge qualche altro programma e non il kernel, ma non riuscendo più a localizzarlo in alcun anfratto del web abbiamo provato ad avviare Xubuntu da una chiavetta, impostato "Installazione OEM" e utilizzato "Altre opzioni" nel menu di avvio per visualizzare la "riga di comando" del kernel, dove però non c'era alcuna opzione aggiuntiva.

Invece di perdere ogni speranza, abbiamo banalmente avviato la live in modalità OEM Install e visualizzato la riga di comando da lì, tramite `cat /proc/cmdline`:

```
file=/cdrom/preseed/xubuntu.seed boot=casper only-ubiquity
initrd=/casper/initrd.lz quiet splash --- debian-installer/language=it
keyboard-configuration/layoutcode?=it oem-config/enable=true
```

È una riga unica ma sono stati inseriti degli a capo per leggibilità.

Probabilmente l'unico parametro importante è `oem-config/enable=true`. Con `ubiquity-only` viene avviato direttamente il setup, senza avvia una sessione live (da cui è comunque possibile effettuare l'installazione OEM). È anche positivo il fatto di aver finalmente capito come impostare il layout della tastiera.

[Mettendo insieme tutti i pezzi](https://github.com/WEEE-Open/ansible-pxe/), la entry nel menu di Syslinux/PXELINUX per avviare direttamente l'installazione OEM su Xubuntu 18.04, ma in generale su qualsiasi derivata di Ubuntu 18.04, è:

```
LABEL xubuntu1804x64OEM
  MENU LABEL Xubuntu 18.04 64 bit - OEM Install
  KERNEL nfs/xubuntu1804x64/casper/vmlinuz
  APPEND initrd=nfs/xubuntu1804x64/casper/initrd.lz boot=casper
   ubiquity-only netboot=nfs
   nfsroot=192.168.0.10:/tftpboot/nfs/xubuntu1804x64 ---
   debian-installer/language=it
   keyboard-configuration/layoutcode?=it
   oem-config/enable=true
```

Di nuovo, gli a capo sono solo per leggibilità: da `APPEND` in poi è tutto sulla stessa riga.

192.168.0.10 è l'IP del server NFS. I percorsi di `vmlinuz` e `initrd.lz` sono relativi alla radice del server TFTP (`/tftpboot`) in quanto vengono inviati via TFTP e non NFS, ma questo riguarda l'[avvio tramite PXE](https://askubuntu.com/a/440802) e non l'installazione OEM in sé.
