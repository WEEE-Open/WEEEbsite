<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php
		if(isset($metadata['title'])) {
			echo $metadata['title'] . $metadata['separator'] . $metadata['site_name'];
		} else {
			echo $metadata['site_name'];
		}?></title>
	<meta name="viewport" content="width=device-width">
	<meta name="generator" content="Corkhammer">
	<link type="text/css" rel="stylesheet" href="main.css" media="screen">
</head>
<body>
	<div id="logo">
		<img src="img/logo325.png" srcset="img/logo650.png 650w, img/logo974.png 974w, img/logo3248.png 3248w" sizes="(max-width: 26em) 100vw, 26em" alt="WEEE Open">
	</div>
	<div id="menu">
		<nav>
			<a href="index.html" <?php if($innerpath === 'index.html'){echo 'class="active"';} ?>>Il progetto</a
			><a href="attivita.html" <?php if($innerpath === 'attivita.html'){echo 'class="active"';} ?>>Attività</a
			><a href="chi-siamo.html" <?php if($innerpath === 'chi-siamo.html'){echo 'class="active"';} ?>>Chi siamo</a
			><a href="obiettivi.html" <?php if($innerpath === 'obiettivi.html'){echo 'class="active"';} ?>>Obiettivi</a>
		</nav>
	</div>
	<div id="content">
		<article>
			<?php echo $contents ?>
		</article>
	</div>
	<footer id="footer">
		<p>Copyleft <span class="copyleft">&copy;</span> 2016, sito e contenuto distribuiti con licenza <a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale</a>.<!--<a href="" target="_blank">Codice sorgente</a>.--></p>
	</footer>
	<script src="menu.js"></script>
</body>
</html>
