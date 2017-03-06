<?php

/**
 * Prints a nicely formatted date from a UNIX timestamp.
 * Actually, it returns it instead of printing.
 * UNIX timestamps are always in UTC time zone: if you don't want any time zone calculations to affect the result,
 * pass 'UTC' as the $timezone parameter.
 *
 * @param string $lang
 * @param string|int $timestamp timestamp in UTC time zone
 * @param string $timezone time zone of the returned date
 * @return string formatted date
 * @throws Exception if time zone cannot be set (or if some random exception flies out of nowhere)
 */
function printDate($timestamp, string $lang='', string $timezone='UTC'): string {
	/* Dates in YAML files don't contain a time zone. We should actually use Europe/Rome,
	 * but DST makes everything needlessly complicated.
	 * Writing a time and date in YAML and seeing the same exact time and date seems a more
	 * intuitive solution, and this code already isn't a masterpiece...
	 */
	if(!date_default_timezone_set($timezone)) {
		throw new Exception('Server doesn\'t know about the '.$timezone.' time zone.');
	}

	switch($lang) {
		case 'it':
			$oldLocale = setlocale(LC_TIME, 'it_IT', 'it_IT.UTF-8', 'it-IT', 'it');
			$month = strftime(' %b ', $timestamp);
			setlocale(LC_TIME, $oldLocale);
			break;
		case 'en':
			$oldLocale = setlocale(LC_TIME, 'en_US', 'en_US.UTF-8', 'en-US', 'en');
			$month = strftime(' %b ', $timestamp);
			setlocale(LC_TIME, $oldLocale);
			break;
		default:
			$month = date('-n-', $timestamp);
			break;
	}

	return date('j', $timestamp) . $month . date('Y', $timestamp);
}

function printDateMachineReadable($timestamp) {
	if(!date_default_timezone_set('UTC')) {
		throw new Exception('Server doesn\'t know about the UTC time zone.');
	}

	return date('Y-m-d', $timestamp);
}

function printPostData($timestamp, $lang) {
	return '<div class="postdata"><time datetime="'.printDateMachineReadable($timestamp).'">'.printDate($timestamp, $lang).'</time></div>';
}

function facebookLink($url, $title, $lang) {
	return "<small>Il post <a class=\"icon-facebook\" target=\"blank\" rel=\"nofollow\" href=\"$url\" title=\"$title\">$title</a> è stato pubblicato anche su Facebook.</small>";
}

/**
 * The usual "read more" button, pointing to a URL.
 *
 * @param $href
 * @param $lang
 * @return string HTML code of the button
 */
function printButton($href, $lang): string {
	if($lang !== 'it') {
		throw new \RuntimeException('Not implemented');
	}
	return "<a href=\"$href\">Continua a leggere &rarr;</a>";
};

function unDoubleQuote(string $string): string {
	$open = true;

	$string = preg_replace_callback('#"#', function() use (&$open) {
		if($open) {
			$replacement = '“';
		} else {
			$replacement = '”';
		}
		$open = !$open;
		return $replacement;
	}, $string);
	if(!$open) {
		throw new \RuntimeException('Number of double quotes doesn\'t match!');
	}
	return $string;
}

function printImgEmblematica(array $mdImg): string {
	return '<img class="emblematica" src="' . $mdImg['src'] . '" alt="' . unDoubleQuote($mdImg['alt']) . '" title="' . unDoubleQuote($mdImg['title']) . '">';
}
