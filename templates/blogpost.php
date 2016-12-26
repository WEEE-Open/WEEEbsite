<?php
$content = '<h1>'.$metadata['title'].'</h1>' . $content;

if(isset($metadata['next']) || isset($metadata['prev'])) {
	$content .= '<nav class="pages">';
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
