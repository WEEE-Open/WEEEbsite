<?php
function bottone($href) {
	return "<a href=\"$href\" class=\"linkbutton\">Continua a leggere &rarr;</a>";
}

$content = '';
$count = count($metadata['posts']);

for($i = ($metadata['page'] * $metadata['postsPerPage']); $i < ($metadata['page'] * $metadata['postsPerPage'] + $metadata['postsPerPage']); $i++) {
	$title = $metadata['posts'][$i]['title'];
	$abstract = $metadata['posts'][$i]['abstract'] ?? $metadata['posts'][$i]['content'];
	$link = $metadata['posts'][$i]['link'];
	if(isset($metadata['posts'][$i]['img'])) {
		$img = '<img class="emblematica" href="' . $metadata['posts'][$i]['img']['href'] . '" alt="' . $metadata['posts'][$i]['img']['alt'] . '" title="' . $metadata['posts'][$i]['img']['title'] . '>';
	} else {
		$img = '';
	}
	if(isset($metadata['posts'][$i]['abstract'])) {
		$abstract = $metadata['posts'][$i]['abstract'] . ' ' . bottone($link);
	} else {
		$abstract = $metadata['posts'][$i]['content'];
	}

	$content .= <<<EOF
<article class="blogpost">
    <h1><a href="$link" title="$title">$title</a></h1>
    $img<p>$abstract</p>
</article>
EOF;
}

$pages = (int) ceil($count / $metadata['postsPerPage']);
if($pages > 1) {
	$content .= '<nav class="pages">';
	$path = substr($file_path, 0, strlen($file_path)-strlen(basename($file_name)));
	if($metadata['page'] > 1) {
		$prev =  $path . 'pagina-' . ($metadata['page'] - 1) . '.html';
		$content .= "<a href=\"$prev\">&larr; Indietro</a>";
	}
	if($metadata['page'] < $count) {
		$next =  $path . 'pagina-' . ($metadata['page'] + 1) . '.html';
		$content .= "<a href=\"$next\">Avanti &rarr;</a>";
	}
	$content .= '</nav>';
}

require 'base.php';
