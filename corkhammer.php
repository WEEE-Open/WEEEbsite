#!/bin/php
<?php
/*
 * Copyright (c) 2016 Ludovico Pavesi
 * Released under The MIT License (see LICENSE)
 */
println('Corkhammer 1.1 started.');
require 'config.php';
// Check that needed constants and variables are available
if(defined('INPUT')) {
	$input_len = strlen('input' . DIRECTORY_SEPARATOR);
} else {
	println('Missing INPUT constant from config.php!');
	exit(1);
}
if(defined('OUTPUT')) {
	$output_len = strlen('output' . DIRECTORY_SEPARATOR);
} else {
	println('Missing OUTPUT constant from config.php!');
	exit(1);
}
require 'rendering.php';
if(!isset($render) || !is_array($render)) {
	println('Missing $render from rendering.php!');
	exit(1);
}

$files_in_output_directory = [];
$rendered_counter = 0;
$updated_counter = 0;
$copied_counter = 0;
$not_updated_counter = 0;
$removed_counter = 0;

if(file_exists(OUTPUT)) {
	// Build a list of files located in OUTPUT directory
	// Every time their counterpart is found in INPUT, that entry gets removed from the array
	$output = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(OUTPUT, FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_FILEINFO));
	foreach($output as $path => $splfileinfo) {
		// Path and modification time are the only informations we'll need
		$files_in_output_directory[substr($path, $output_len)] = $splfileinfo->getMTime();
	}
	// Avoid possible bugs, chaos and destruction when reusing variable names (which shouldn't be done anyway)
	unset($output, $path, $splfileinfo);
	//println('Output directory ('.OUTPUT.') already contains '.count($files_in_output_directory).' files.');
} else {
	mkdir(OUTPUT);
}

// Build a list of files located in INPUT directory
$input = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(INPUT, FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_FILEINFO));
foreach($input as $path => $splfileinfo) {
	$innerpath = substr($path, $input_len); // path without the "input/" part

	// Is it renderizable?
	if(isset($render[$splfileinfo->getExtension()])) {
		// Render it

		// We need to render each file before checking if it exists because a
		// template or rendering function may have changed and there's no way
		// to notice it from modification time alone
		println('Rendering ' . $innerpath . '...');
		$contents = file_get_contents(INPUT . DIRECTORY_SEPARATOR . $innerpath);
		$rendered = $render[$splfileinfo->getExtension()]($innerpath, $contents);
		$rendered_counter++;

		if(already_exists($innerpath, $splfileinfo, $files_in_output_directory)) {
			if(sha1($rendered) === sha1_file(OUTPUT . DIRECTORY_SEPARATOR . $innerpath)) {
				// exact same file, skip some useless operations and go to next file
				// Hashing everything is probably as slow as blindly overwriting
				// the file, but at least we get some meaningful numbers in counters...
				continue;
			}
		}
		mkdir_to($innerpath);
		file_put_contents(OUTPUT . DIRECTORY_SEPARATOR . $innerpath, $rendered);
		$updated_counter++;
	} else {
		// Is it already there?
		if(already_exists($innerpath, $splfileinfo, $files_in_output_directory)) {
			// Yes: skip it
			$not_updated_counter++;
			continue;
		} else {
			// No: copy it
			mkdir_to($innerpath);
			copy(INPUT . DIRECTORY_SEPARATOR . $innerpath, OUTPUT . DIRECTORY_SEPARATOR . $innerpath);
			$copied_counter++;
		}
	}
	touch(OUTPUT . DIRECTORY_SEPARATOR . $innerpath, $splfileinfo->getMTime());

	// Is there a copy\rendered version of this file in OUTPUT directory?


}
unset($input, $path, $splfileinfo);

// $files_in_output_directory only contains files that don't exist in INPUT path. Let's remove them from OUTPUT, too.
if(!empty($files_in_output_directory)) {
	foreach($files_in_output_directory as $path => $mtime) {
		println('Deleting ' . $path . '...');
		unlink(OUTPUT . DIRECTORY_SEPARATOR . $path);
		$removed_counter++;
		// Is the directory empty?
		delete_if_empty_from_output(dirname(OUTPUT . DIRECTORY_SEPARATOR . $path));
	}
	unset($files_in_output_directory, $path, $mtime);
}

if($removed_counter > 0) {
	$removed_string = PHP_EOL . "$removed_counter deleted (not in " . INPUT . " directory anymore)";
} else {
	$removed_string = '';
}

$copied_total_counter = $updated_counter + $copied_counter;
if($copied_total_counter > 0) {
	$copied_string = " ($updated_counter rendered, $copied_counter copied)";
} else {
	$copied_string = '';
}
echo <<<EOT

Build finished.
Rendered: $rendered_counter files.
Updated: $copied_total_counter files$copied_string.
Already up-to-date: $not_updated_counter files.$removed_string
EOT;

/**
 * Get path to a file, recursively make directories in OUTPUT (and copy permissions from INPUT)
 *
 * @param $destination string path to a file (without INPUT/OUTPUT part)
 */
function mkdir_to(string $destination) {
	mkdir_to_recursive(dirname($destination));
}

/**
 * Used internally by mkdir_to(), don't call directly.
 *
 * @see mkdir_to
 * @param string
 */
function mkdir_to_recursive(string $dirname) {
	if($dirname == '.') {
		return;
	} else {
		mkdir_to_recursive(dirname($dirname));
	}
	if(!file_exists(OUTPUT . DIRECTORY_SEPARATOR . $dirname)) {
		mkdir(OUTPUT . DIRECTORY_SEPARATOR . $dirname, fileperms(INPUT . DIRECTORY_SEPARATOR . $dirname));
		touch(OUTPUT . DIRECTORY_SEPARATOR . $dirname, filemtime(INPUT . DIRECTORY_SEPARATOR . $dirname));
	}
}

/**
 * Checks if a directory is empty and deletes it, then recursively calls itself on the parent directory.
 * Won't delete OUTPUT directory or the "relative root" even if they are empty.
 *
 * @param string $directory directory to delete
 */
function delete_if_empty_from_output(string $directory) {
	if($directory == '.' || $directory == OUTPUT) {
		return;
	}
	if(!(new \FilesystemIterator($directory))->valid()) {
		println('Removing empty directory ' . $directory . '...');
		rmdir($directory);
		delete_if_empty_from_output(dirname($directory));
	}
}

/**
 * Checks if a file exists in OUTPUT directory and isn't older than its corresponding INPUT file.
 * Also removes the entry from $files_in_output_directory.
 *
 * @param string $innerpath
 * @param SplFileInfo $splfileinfo Input file
 * @param array $files_in_output_directory passed by reference, the entry corresponding to this file will be removed
 * @return bool true if the file exists and has the same (or newer) modification time
 */
function already_exists(string $innerpath, \SplFileInfo $splfileinfo, array &$files_in_output_directory): bool {
	if(array_key_exists($innerpath, $files_in_output_directory)) {
		// Does the one in OUTPUT have the same modification time (or more recent)?
		if($files_in_output_directory[$innerpath] >= $splfileinfo->getMTime()) {
			// It's identical
			unset($files_in_output_directory[$innerpath]);
			return true;
		}
		// Different
		unset($files_in_output_directory[$innerpath]);
	}
	// Not in the array
	return false;
}

function println(string $text) {
	echo $text . PHP_EOL;
}
