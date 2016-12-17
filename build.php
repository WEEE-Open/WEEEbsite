#!/bin/php
<?php
define('INPUT', 'input');
define('OUTPUT', 'output');

$parsers = ['UnderscoreDotYaml', 'HTMLWithYAMLFrontMatter', 'HTMLWithDefaultTemplate', 'YamlForMarkdown', 'MarkdownWithYAMLFrontMatter', 'Markdown', 'CSSMinify'];

require 'ma/ma.php';