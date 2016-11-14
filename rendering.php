<?php
/*
 * Copyright (c) 2016 Ludovico Pavesi
 * Released under The MIT License (see LICENSE)
 */

/*
 * Render functions. Array keys are file extensions: when one is found, the corresponding anonymous function is called.
 * $innerpath is the relative path and file name without the INPUT\OUTPUT part (e.g. input/foo/bar.txt has $innerpath = "foo/bar.txt").
 * If you need a more "complete" relative path, use INPUT.DIRECTORY_SEPARATOR.$innerpath or OUTPUT.DIRECTORY_SEPARATOR.$innerpath.
 * $contents is the entire content of the file from the INPUT directory.
 * The returned string is the rendered content, which will be placed without further processing into OUTPUT.DIRECTORY_SEPARATOR.$innerpath.
 *
 * Note that files can't be renamed: you can't render foo.md to foo.html.
 * If some html files need to be rendered and other don't, you can try to tell them apart from their $innerpath, and
 * "return $contents;" for those that shouldn't be rendered.
 *
 * Also note that $defaults is defined in config.php.
 */
$render = [
	'html' => function(string $innerpath, string $contents) use ($defaults): string {
		// Find the delimiter in this byzantine file format, namely the string "---" on a line by itself
		$fragments = explode("\n---\n", $contents, 2);
		if(count($fragments) < 2) {
			// Windows newlines...
			$fragments = explode("\r\n---\r\n", $contents, 2);
			if(count($fragments) < 2) {
				throw new Exception('No delimiter found in ' . $innerpath . '!');
			}
		}

		$unjsoned_json = json_decode($fragments[0], true);
		if(json_last_error() !== JSON_ERROR_NONE || !is_array($unjsoned_json)) {
			throw new Exception('Failed to decode JSON in ' . $innerpath . ': ' . json_last_error_msg());
		}
		$metadata = array_merge($defaults, $unjsoned_json);
		$contents = $fragments[1];

		if(!file_exists($metadata['template'])) {
			throw new Exception('Template not found: ' . $metadata['template']);
		}

		// Prevent random variables from falling into templates.
		unset($defaults, $fragments, $unjsoned_json);
		// Only $innerpath, $contents and $metadata (and the INPUT\OUTPUT constants) are available beyond this point.
		ob_start();
		include $metadata['template'];
		return ob_get_clean();
	},
	'css' => function(string $innerpath, string $contents): string {
		return preg_replace('#\s*/\*.+?\*/#sm', '', $contents);
	}
];