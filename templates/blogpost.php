<?php
$content = '<h1>'.$metadata['title'].'</h1>' . $content;

if(isset($metadata['next']) || isset($metadata['prev'])) {
	$content .= '<nav class="pages">';
	if(isset($metadata['prev'])) {
		$href = '/' . $metadata['prev']->getRelativeFileName();
		$name = $metadata['prev']->getMetadata()['title'];
		$content .= "Precedente: <a class=\"prev\" href=\"$href\">&larr; $name</a>";
	}
	if(isset($metadata['next'])) {
		$href = '/' . $metadata['next']->getRelativeFileName();
		$name = $metadata['next']->getMetadata()['title'];
		$content .= "Successivo: <a class=\"next\" href=\"$href\">$name &rarr;</a>";
	}
	$content .= '</nav>';
}

require 'base.php';
