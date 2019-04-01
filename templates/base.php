<!DOCTYPE HTML>
<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file));
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));
$active = function(string $what) use ($file_path) {
	if($file_path === $what) {
		echo ' class="active"';
	}
}
?>
<html lang="<?php if(isset($metadata['lang'])) {
	echo $metadata['lang'];
} else {
	echo 'it';
} ?>">
<head>
	<meta charset="UTF-8">
	<title><?php
		if(isset($metadata['title'])) {
			echo $metadata['title'] . $metadata['separator'] . $metadata['site_name'];
		} else {
			echo $metadata['site_name'];
		} ?></title>
	<meta name="viewport" content="width=device-width">
	<meta name="generator" content="Mechatronic Anvil">
	<link type="text/css" rel="stylesheet" href="/main.css" media="screen">
	<link rel="apple-touch-icon" sizes="144x144" href="/img/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/img/apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="/img/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/img/favicon-16x16.png" sizes="16x16">
	<meta name="application-name" content="WEEE Open">
	<meta name="msapplication-TileColor" content="#00983A">
	<meta name="msapplication-TileImage" content="/img/mstile-144x144.png">
	<?php
	if(isset($metadata['translations'])) {
		foreach($metadata['translations'] as $link_lang => $link) {
			$content .= "<link rel=\"alternate\" hreflang=\"$link_lang\" href=\"$link\">";
		}
	}
	?>
</head>
<body>
<div id="logo">
	<img src="/img/logo325.png"
			srcset="/img/logo325.png 325w, /img/logo650.png 650w, /img/logo974.png 974w, /img/logo3248.png 3248w"
			sizes="(max-width: 26em) 100vw, 26em" alt="WEEE Open">
</div>
<div id="menu">
	<nav>
		<a href="/index.html"<?php $active('index.html') ?>>WEEE Open</a
		><a href="/blog/"<?php $active('blog/index.html') ?>>Blog</a
		><a href="/progetto.html"<?php $active('progetto.html') ?>>Il progetto</a
		><a href="/entra-nel-team.html"<?php $active('entra-nel-team.html') ?>>Entra nel team</a
		><a href="/chi-siamo.html"<?php $active('chi-siamo.html') ?>>Chi siamo</a
		><a href="/contatti.html"<?php $active('contatti.html') ?>>Contatti</a>
	</nav>
</div>
<div id="content">
	<main>
		<?php echo $content ?>
	</main>
</div>
<footer id="footer">
	<p>Copyleft <span class="copyleft">&copy;</span>, sito e contenuto distribuiti con licenza <a rel="license" target="_blank" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale</a>.
		<a href="https://github.com/WEEE-Open/WEEEbsite" target="_blank">Codice sorgente</a>.</p>
	<p>Seguici su Facebook: <a href="https://www.facebook.com/weeeopenpolito/" target="_blank" rel="nofollow">Team WEEE Open</a> e Instagram: <a href="https://www.instagram.com/weeeopen/" target="_blank" rel="nofollow">@weeeopen</a></p>
	<p><small>Il Team WEEE Open &egrave; finanziato dal Politecnico di Torino tramite i contributi alla progettualit&agrave; studentesca.</small></p>
</footer>
<script src="/menu.js"></script>
</body>
</html>
