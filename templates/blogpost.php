<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file));
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));

$lang = isset($metadata['lang']) ? $metadata['lang'] : 'it';
require_once TEMPLATES . DIRECTORY_SEPARATOR . 'common_functions.php';
$file->upDate(filemtime(TEMPLATES . DIRECTORY_SEPARATOR . 'common_functions.php'));

$img = '';
if(isset($metadata['img']) && !(isset($metadata['img']['hide']) && $metadata['img']['hide'] === true)) {
	$img = printImgEmblematica($metadata['img']);
}

$content = '<h1>'.$metadata['title'].'</h1>' . printPostData($metadata['date'], $lang) . $img . $content;

if(isset($metadata['facebook'])) {
	$content .= '<p>' . facebookLink($metadata['facebook'], $metadata['title'], $lang) . '</p>';
}

if(isset($metadata['next']) || isset($metadata['prev'])) {
	$content .= '<nav class="pages">';
	// not really but stops some warnings:
	/** @var \lvps\MechatronicAnvil\File[] $metadata */
	if(isset($metadata['next'])) {
		// yes, prev and next are reversed.
		$href = '/' . $metadata['next']->getRelativeFileName();
		$name = $metadata['next']->getMetadata()['title'];
		$content .= "<p class=\"prev\">Successivo: <a href=\"$href\">$name</a></p>";
	}
	if(isset($metadata['prev'])) {
		$href = '/' . $metadata['prev']->getRelativeFileName();
		$name = $metadata['prev']->getMetadata()['title'];
		$content .= "<p class=\"next\">Precedente: <a href=\"$href\">$name</a></p>";
	}
	$content .= '</nav>';
} else {
	/* desperate hack to place a clearfix thingamajig somewhere near the bottom of the page */
	$content .= '<nav class="pages">&nbsp;</nav>';
}

require TEMPLATES . DIRECTORY_SEPARATOR . 'base.php';
$file->upDate(filemtime(TEMPLATES . DIRECTORY_SEPARATOR . 'base.php'));
