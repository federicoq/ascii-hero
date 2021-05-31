<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Plain implements \AsciiHero\AreaInterface {

	use \AsciiHero\Traits\Dimensions;
	use \AsciiHero\Traits\BoundingBoxStandard;
	use \AsciiHero\Traits\UsePadding;

	private $rows = [];

	function __construct($rows) {

		$this->rows = explode("\n", $rows);

	}

	function render() {

		$max_width = max(array_map('mb_strlen', $this->rows));

		$out = array_map(function($r) use ($max_width) {
			return Tools::pad($r, $max_width, ' ');
		}, $this->rows);

		return implode("\n", $out);

	}

}