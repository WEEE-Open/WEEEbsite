<?php
$bottone = function($href) {
	return "<a href=\"$href\" class=\"linkbutton\">Continua a leggere &rarr;</a>";
};

$content = '';

foreach($metadata['posts'] as $post) {
	/** @var \lvps\MechatronicAnvil\File $post */
	$md = $post->getMetadata();

	$title = $md['title'];
	$abstract = $md['abstract'] ?? $md['content'];
	$link = '/' . $post->getRelativeFilename();
	if(isset($md['img'])) {
		$img = '<img class="emblematica" href="' . $md['img']['href'] . '" alt="' . $md['img']['alt'] . '" title="' . $md['img']['title'] . '>';
	} else {
		$img = '';
	}
	if(isset($md['abstract'])) {
		$abstract = $md['abstract'] . ' ' . $bottone($link);
	}

	$content .= <<<EOF
<article class="blogpost">
    <h1><a href="$link" title="$title">$title</a></h1>
    $img<p>$abstract</p>
</article>
EOF;
}

if(isset($metadata['pagination'])) {
	$content .= '<nav class="pages">';
	if(isset($metadata['pagination']['prev'])) {
		$prev = $metadata['pagination']['prev']->getRelativeFilename();
		$content .= "<a href=\"/$prev\">&larr; Articoli più recenti</a>";
	}
	if(isset($metadata['pagination']['next'])) {
		$next = $metadata['pagination']['next']->getRelativeFilename();
		$content .= "<a href=\"/$next\">Articoli più vecchi &rarr;</a>";
	}
	$content .= '</nav>';
}

require 'base.php';
