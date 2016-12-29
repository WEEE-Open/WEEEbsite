<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file));
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));

$content = '<h1>'.$metadata['title'].'</h1><div class="postdata"><p>'.$metadata['date'].'</p></div>' . $content;

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
