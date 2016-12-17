#!/bin/php
<?php
define('INPUT', 'input');
define('OUTPUT', 'output');

$parsers = ['UnderscoreDotYaml', 'HTMLWithYAMLFrontMatter', 'HTMLWithDefaultTemplate', 'YamlForMarkdown', 'MarkdownWithYAMLFrontMatter', 'Markdown', 'CSSMinify'];

function onMerged($output) {
    $blog = $output->descendInto('blog');
    $posts = [];
    $blog->walkCallback(function($file) use (&$posts) {
        if($file->getDoRender() && isset($file->getMetadata()['blog_post']) && $file->getMetadata()['blog_post'] === true) {
            $posts[] = $file;
        }
    });
    count($posts);
    usort($posts, function($postA, $postB) {
        return $postA->getMetadata()['date'] - $postB->getMetadata()['date'];
    });
	if(isset($posts[1])) {
	    $posts[0]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['next' => $posts[1]]));
    }
	if(isset($posts[count($posts) - 2])) {
		$posts[count($posts) - 1]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['prev' => $posts[count($posts) - 2]]));
	}
	for($i = 1; $i < count($posts) - 1; $i++) {
        $posts[$i]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['next' => $posts[$i+1]]));
        $posts[$i]->addMetadataOnTop(new \lvps\MechatronicAnvil\Metadata(['prev' => $posts[$i-1]]));
    }
    count($posts);
};

require 'ma/ma.php';