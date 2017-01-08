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
require_once TEMPLATES . DIRECTORY_SEPARATOR . 'common_functions.php';
$file->upDate(filemtime(TEMPLATES . DIRECTORY_SEPARATOR . 'common_functions.php'));

if(isset($metadata['pinnedPosts']) && count($metadata['pinnedPosts']) > 0) {
	// @var doesn't work, for no apparent reason.
	/** @noinspection PhpUndefinedMethodInspection */
	$file->upDate($metadata['pinnedPosts'][0]->getMtime());
}

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
		$b = '<p>' . printButton($link, $lang) . '</p>';
	}

	$date = printPostData($md['date'], $lang);

	$pinnedContent .= <<<EOF
	<article class="pinnedpost pinned-{COUNT}">
		<h2><a href="$link" title="$title">$title</a></h2>
		$date
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

require TEMPLATES . DIRECTORY_SEPARATOR . 'base.php';
$file->upDate(filemtime(TEMPLATES . DIRECTORY_SEPARATOR . 'base.php'));
