<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file));
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));

$lang = isset($metadata['lang']) ? $metadata['lang'] : 'it';
require_once 'printdate.php';

$img = '';
if(isset($metadata['img']) && !(isset($metadata['img']['hide']) && $metadata['img']['hide'] === true)) {
	$img = '<img class="emblematica" src="' . $metadata['img']['src'] . '" alt="' . $metadata['img']['alt'] . '" title="' . $metadata['img']['title'] . '">';
}

$content = '<h1>'.$metadata['title'].'</h1><div class="postdata"><p>'.printdate($metadata['date'], $lang).'</p></div>' . $img . $content;

if(isset($metadata['next']) || isset($metadata['prev'])) {
	$content .= '<nav class="pages">';
	// not really but stops some warnings:
	/** @var \lvps\MechatronicAnvil\File[] $metadata */
	if(isset($metadata['prev'])) {
		$href = '/' . $metadata['prev']->getRelativeFileName();
		$name = $metadata['prev']->getMetadata()['title'];
		$content .= "<p class=\"prev\">Precedente: <a href=\"$href\">$name</a></p>";
	}
	if(isset($metadata['next'])) {
		$href = '/' . $metadata['next']->getRelativeFileName();
		$name = $metadata['next']->getMetadata()['title'];
		$content .= "<p class=\"next\">Successivo: <a href=\"$href\">$name</a></p>";
	}
	$content .= '</nav>';
}

require 'base.php';
