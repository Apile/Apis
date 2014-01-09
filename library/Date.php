<?php
namespace Apile;
class Date {
	private $timestamp, $timezone, $timezone_s;
	public function __construct() {
		$this->timestamp = gmmktime();
	}
	public function utc($timezone) {
		$timezone = explode(".", $timezone);
		if (count($timezone) === 2) {
			$this->timezone = $timezone[0] . ":" . ($timezone[1] * 100 / 60);
		}
		else {
			$timezone2 = implode(".", $timezone);
			$timezone2 = explode(":", $timezone2);
			if (count($timezone2) === 1) {
				$this->timezone = $timezone2[0] . ":00";
			}
			else {
				$this->timezone = $timezone2[0] . ":" . (strlen($timezone2[1]) === 1 ? "0" . $timezone2[1] : $timezone2[1]) ;
			}
		}
		$timezone = implode(".", $timezone);
		$minus = false;
		if (substr($timezone, 0, 1) == "-") {
			$minus = true;
			$timezone = substr($timezone, 1);
		}
		else if (substr($timezone, 0, 1) == "+") {
			$minus = false;
			$timezone = substr($timezone, 1);
		}
		else {
			$this->timezone = "+" . $this->timezone;
		}
		
		
		$timezone = explode(":", $timezone);
		if (count($timezone) === 2) {
			$this->timestamp += (intval($minus ? (-$timezone[0]) : $timezone[0]) * 3600);
			$this->timestamp += ((intval($minus ? (-$timezone[1]) : $timezone[1]) * 100 / 60 ) * 60);
			$this->timezone_s = ($minus? "-": "+") . ($timezone[0]*3600 + $timezone[1]*60);
		}
		else {
			$this->timestamp += (floatval($minus ? (-$timezone[0]) : $timezone[0]) * 3600);
			$this->timezone_s = ($minus? "-": "+") . ($timezone[0]*3600);
		}
	}
	public function format($format) {
		$format = str_replace("e", "-_x-x_-" . $this->timezone ,$format);
		$format = str_replace("O", str_replace(":", "", $this->timezone) ,$format);
		$format = str_replace("P", $this->timezone, $format);
		$format = str_replace("Z", $this->timezone_s, $format);
		$format = str_replace("T", "-_x-x_-" . $this->timezone, $format);
		return str_replace("-_x-x_-", "UTC", gmdate($format, $this->timestamp));
	}
}
