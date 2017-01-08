<?php
assert(isset($file_path));
assert(isset($file_name));
assert(isset($file)); /** @var \lvps\MechatronicAnvil\File $file */
assert(isset($templatePath));
assert(isset($content));
assert(isset($metadata));

$content = '';

// note: page language, not this post language
$lang = isset($metadata['lang']) ? $metadata['lang'] : 'it';
require_once TEMPLATES . DIRECTORY_SEPARATOR . 'common_functions.php';
$file->upDate(filemtime(TEMPLATES . DIRECTORY_SEPARATOR . 'common_functions.php'));

$file->addMetadataOnBottom($file->getParent()->getMetadata());

foreach($metadata['posts'] as $post) {
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
		$b = '<p>' . printButton($link, $lang) . '</p>';
	}

	$date = printPostData($md['date'], $lang);

	$content .= <<<EOF
<article class="blogabstract">
	<h2><a href="$link" title="$title">$title</a></h2>
	$date
	<p>$img$abstract</p>
	$b
</article>
EOF;
}

$metadata['title'] = 'Blog';

if(isset($metadata['pagination'])) {
	$content .= '<nav class="pages">';
	if(isset($metadata['pagination']['prev'])) {
		/** @noinspection PhpUndefinedMethodInspection */
		$prev = $metadata['pagination']['prev']->getRelativeFilename();
		$content .= "<a class=\"prev\" href=\"/$prev\">&larr; Articoli più recenti</a>";
	}
	if(isset($metadata['pagination']['next'])) {
		/** @noinspection PhpUndefinedMethodInspection */
		$next = $metadata['pagination']['next']->getRelativeFilename();
		$content .= "<a class=\"next\" href=\"/$next\">Articoli più vecchi &rarr;</a>";
	}
	$content .= '</nav>';

	if($metadata['pagination']['this'] > 0) {
		$i = $metadata['pagination']['this'];
		$metadata['title'] .= " (pagina $i)";
	}
}

require TEMPLATES . DIRECTORY_SEPARATOR . 'base.php';
$file->upDate(filemtime(TEMPLATES . DIRECTORY_SEPARATOR . 'base.php'));
