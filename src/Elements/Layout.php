<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Layout implements \AsciiHero\AreaInterface {

	public function render() {

		foreach($this->rows as $row) {

			$buffer = [];

			$max_h = max(array_map(function($i) { return count(explode("\n", $i)); }, $row));

			foreach($row as $col => $single_column) {

				$lines = explode("\n", $single_column);

				foreach($lines as $k => $line) {

					if($this->equalize == EQUALIZE_BOTH) {
						$factor = ceil(($max_h - count($lines)) * 0.5);
					} else if($this->equalize == EQUALIZE_BOTTOM) {
						$factor = ceil(($max_h - count($lines)));
					} else if($this->equalize == EQUALIZE_TOP) {
						$factor = 0;
					}


					if($k == 0) {
						for($a = 0; $a < $factor; $a++)
							$buffer[$a][$col] = Tools::pad(' ', mb_strlen($line), ' ');
					}

					if($k == count($lines) - 1) {
						for($h = $k+1; $h < $max_h; $h++) {
							if(empty($buffer[$h][$col]))
								$buffer[$h][$col] = Tools::pad(' ', mb_strlen($line), ' ');
						}
					}

					$buffer[ $k + $factor ][$col] = $line;

				}

			}

			ksort($buffer);

			foreach($buffer as $partecipants)
				$out_buff[] = implode(" ", $partecipants);

		}



		return implode("\n", $out_buff);


	}

	public function ignorePadding() {
		return false;
	}

	public function bounding_box() {
		return false;
	}

	private $rows;
	private $equalize = false;

	function equalize($v) {
		$this->equalize = $v;
	}

	public function row($rows) {
		$this->rows[] = $rows;
	}

}
