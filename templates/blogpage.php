<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file));
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));

$bottone = function($href) {
	return "<a href=\"$href\">Continua a leggere &rarr;</a>";
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
	$b = $bottone($link);

	// note: page language, not this post language
	$lang = isset($metadata['lang']) ? $metadata['lang'] : 'it';
	require_once 'printdate.php';
	$date = printdate($md['date'], $lang);

	$content .= <<<EOF
<article class="blogabstract">
    <h1><a href="$link" title="$title">$title</a></h1>
    <div class="postdata"><p>$date</p></div>
    <p>$img$abstract</p>
    <p>$b</p>
</article>
EOF;
}

if(isset($metadata['pagination'])) {
	$content .= '<nav class="pages">';
	// not really but stops some warnings:
	/** @var \lvps\MechatronicAnvil\File[][] $metadata */
	if(isset($metadata['pagination']['prev'])) {
		$prev = $metadata['pagination']['prev']->getRelativeFilename();
		$content .= "<a class=\"prev\" href=\"/$prev\">&larr; Articoli più recenti</a>";
	}
	if(isset($metadata['pagination']['next'])) {
		$next = $metadata['pagination']['next']->getRelativeFilename();
		$content .= "<a class=\"next\" href=\"/$next\">Articoli più vecchi &rarr;</a>";
	}
	$content .= '</nav>';
}

require 'base.php';
