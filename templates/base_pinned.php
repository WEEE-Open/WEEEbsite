<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file));
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));

$pinnedContent = '';

// note: page language, not this post language
$lang = isset($metadata['lang']) ? $metadata['lang'] : 'it';
require_once 'common_functions.php';
// TODO: move button to another template:
$bottone = function($href) {
	return "<a href=\"$href\">Continua a leggere &rarr;</a>";
};

foreach($metadata['pinnedPosts'] as $post) {
	/** @var \lvps\MechatronicAnvil\File $post */
	$md = $post->getMetadata();

	$title = $md['title'];
	$abstract = $md['abstract'] ?? $md['content'];
	$link = '/' . $post->getRelativeFilename();
	if(isset($md['img'])) {
		$img = printImgEmblematica($md['img']);
	} else {
		$img = '';
	}

	$b = '';
	if(!isset($md['read_more']) || $md['read_more'] === true) {
		$b = '<p>' . $bottone($link) . '</p>';
	}

	$date = printdate($md['date'], $lang);

	$pinnedContent .= <<<EOF
	<article class="pinnedpost pinned-{COUNT}">
		<h2><a href="$link" title="$title">$title</a></h2>
		<div class="postdata"><p>$date</p></div>
		<p>$img$abstract</p>
		$b
	</article>
EOF;
}

if($pinnedContent !== '') {
	$pinnedContent = '<div id="pinned">' . $pinnedContent . '</div>';
	$pinnedContent = str_replace('{COUNT}', count($metadata['pinnedPosts']), $pinnedContent);
}

$replaced = 0;
$content = str_replace('{PINNED}', $pinnedContent, $content, $replaced);
if($replaced < 1) {
	throw new \RuntimeException('Cannot find {PINNED} tag!');
}

require 'base.php';