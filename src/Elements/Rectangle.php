<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Rectangle implements \AsciiHero\AreaInterface {

	use \AsciiHero\Traits\Dimensions;
	use \AsciiHero\Traits\BoundingBoxStandard;
	use \AsciiHero\Traits\UsePadding;

	private $filler = '#';

	public function setFiller($char) {
		$this->filler = $char;
	}

	function __construct($width = false, $height = false, $filler = false) {

		if($width)
			$this->setWidth($width);

		if($height)
			$this->setHeight($height);

		if($filler)
			$this->setFiller($filler);

	}

	function render() {

		$out = [];
		for($i = 0; $i < $this->height(); $i++) {
			for($j = 0; $j < $this->width(); $j++) {
				@ $out[ $i ] .= $this->filler;
			}
		}

		return implode("\n", $out);

	}

}