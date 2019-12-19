<?php

namespace util;

class DateTimeUtil {

	public static function getReadableDateTime($time, $format) {
		return $time->format($format);
	}

	public static function getMonth($time, $type = 'numeric') {
		$format = null;
		switch ($type) {
			case 'numeric':
				$format = 'n';
				break;
			case 'name':
				$format = 'F';
				break;
			
			default:
				# do nothing
				break;
		}
		return $time->format($format);
	}

	public static function getMonthsBefore($time, $count, $type = 'numeric') {
		$datestring = DateTimeUtil::getReadableDateTime($time, "Y-m") . ' -' . $count . ' month';
		$dateTime = date_create($datestring);
		return DateTimeUtil::getMonth($dateTime, $type);
	}

	public static function stringToDateTime(string $dateTimeString) {
		return date_create($dateTimeString);
	}

	public static function dateTimeToString($dateTimeObject, $format = "Y-m-d H:i:s") {
		return $dateTimeObject->format($format);
	}

}