#!/bin/php
<?php
define('INPUT', 'input');
define('OUTPUT', 'output');

$parsers = ['UnderscoreDotYaml', 'HTMLWithYAMLFrontMatter', 'HTMLWithDefaultTemplate', 'YamlForMarkdown', 'MarkdownWithYAMLFrontMatter', 'Markdown', 'CSSMinify'];

function onMerged($output) {
	$parser = new \lvps\MechatronicAnvil\Parsers\NoContentPHPTemplate();
	$index = NULL;
	/** @var \lvps\MechatronicAnvil\Directory $output */
	$output->walkCallback(function($file) use (&$index) {
		/** @var \lvps\MechatronicAnvil\File $file */
		if(substr($file->getBasename(), 0, 6) === 'index.') {
			$index = $file;
		}
	});
	/** @var \lvps\MechatronicAnvil\File $index */
	if($index === NULL) {
		throw new LogicException('Missing index file!');
	}

	/** @var \lvps\MechatronicAnvil\Directory $blog */

	$blog = $output->descendInto('blog');
	$posts = [];
	$pinnedPosts = ['it' => []];
	$blog->walkCallback(function($file) use (&$posts, &$pinnedPosts) {
		/** @var \lvps\MechatronicAnvil\File $file */
		if($file->getDoRender()) { // TODO: what happens if there's a subdirectory?
			$md = $file->getMetadata();
			// blog_post: is it a blog post? If not, we won't do anything else.
			// hidden: hide from list (but still render its page, with next\prev buttons, and add to pinned if needed)
			// pinned: the 3 most recent pinned posts will be passed to index.html, to be displayed in home page.
			if(isset($md['blog_post']) && $md['blog_post'] === true) {
				if(!isset($md['hidden']) || $md['hidden'] === false) {
					$posts[] = $file;
				}
				if(isset($md['pinned']) && $md['pinned'] === true) {
					$pinnedPosts['it'][] = $file;
				}
			}
		}
	});

	// newest first, oldest last
	usort($pinnedPosts['it'], function($postA, $postB) {
		/** @var \lvps\MechatronicAnvil\File $postA */
		/** @var \lvps\MechatronicAnvil\File $postB */
		return $postB->getMetadata()['date'] - $postA->getMetadata()['date'];
	});

	if(count($pinnedPosts['it']) > 0) {
		$pinnedPosts['it'] = array_slice($pinnedPosts['it'], 0, 3);
		$index->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata([
			'pinnedPosts' => $pinnedPosts['it'],
		]));
	}

	// oldest first, newest last
	usort($posts, function($postA, $postB) {
		/** @var \lvps\MechatronicAnvil\File $postA */
		/** @var \lvps\MechatronicAnvil\File $postB */
		return $postA->getMetadata()['date'] - $postB->getMetadata()['date'];
	});
	if(isset($posts[1])) {
		$posts[0]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['next' => $posts[1]]));
	}
	if(isset($posts[count($posts) - 2])) {
		$posts[count($posts) - 1]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['prev' => $posts[count($posts) - 2]]));
	}
	for($i = 1; $i < count($posts) - 1; $i++) {
		$posts[$i]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['next' => $posts[$i + 1]]));
		$posts[$i]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['prev' => $posts[$i - 1]]));
	}

	// oldest last, newest first
	$posts = array_reverse($posts);

	$ppp = $blog->getMetadata()['postsPerPage'];
	$pages = [];
	$pagesCount = (int) ceil(count($posts) / $ppp);
	for($page = 0; $page < $pagesCount; $page++) {
		if($page === $pagesCount - 1) {
			// last page
			$postsInThisPage = array_slice($posts, $page * $ppp);
		} else {
			$postsInThisPage = array_slice($posts, $page * $ppp, $ppp);
		}

		if($page === 0) {
			$thisPage = new \lvps\MechatronicAnvil\File('index.html', $blog);
		} else {
			$thisPage = new \lvps\MechatronicAnvil\File('pagina-' . $page . '.html', $blog);
		}

		$thisPage->setParser($parser);
		$thisPage->setMtime($postsInThisPage[0]->getMtime());
		$thisPage->addMetadataOnTop($blog->getMetadata());
		$thisPage->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata([
			'posts' => $postsInThisPage,
			'template' => 'blogpage.php',
		]));

		$pages[] = $thisPage;
	}

	foreach($pages as $i => $page) {
		if($i === 0) {
			if($pagesCount > 1) {
				$pages[$i]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata([
					'pagination' => [
						'next' => $pages[$i + 1],
						'this' => $i,
					]
				]));
			}
		} else if($i === $pagesCount - 1) {
			if($pagesCount > 1) {
				$pages[$i]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata([
					'pagination' => [
						'prev' => $pages[$i - 1],
						'this' => $i,
					]
				]));
			}
		} else {
			$pages[$i]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata([
				'pagination' => [
					'next' => $pages[$i + 1],
					'prev' => $pages[$i - 1],
					'this' => $i,
				]
			]));
		}
	}
}

;

require 'ma/ma.php';