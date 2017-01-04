<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file));
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));

$lang = isset($metadata['lang']) ? $metadata['lang'] : 'it';
require_once 'common_functions.php';

$img = '';
if(isset($metadata['img']) && !(isset($metadata['img']['hide']) && $metadata['img']['hide'] === true)) {
	$img = printImgEmblematica($metadata['img']);
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
} else {
	/* desperate hack to place a clearfix thingamajig somewhere near the bottom of the page */
	$content .= '<nav class="pages">&nbsp;</nav>';
}

require 'base.php';
