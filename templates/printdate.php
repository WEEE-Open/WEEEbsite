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
			setlocale(LC_TIME, 'it_IT');
			$month = strftime(' %b ', $timestamp);
			break;
		case 'en':
			setlocale(LC_TIME, "en_US");
			$month = strftime(' %b ', $timestamp);
			break;
		default:
			$month = date('-n-', $timestamp);
			break;
	}

	return date('j', $timestamp) . $month . date('Y', $timestamp);
}
