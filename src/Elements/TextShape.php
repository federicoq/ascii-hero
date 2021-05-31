<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class TextShape implements \AsciiHero\AreaInterface {

	use \AsciiHero\Traits\Dimensions;
	use \AsciiHero\Traits\BoundingBoxStandard;
	use \AsciiHero\Traits\UsePadding;

	private $replaceChar = true;
	private $text = false;
	private $shape = false;

	function __construct($text, \AsciiHero\AreaInterface $shape, $allNonEmpty = true, $multiline = false) {

		$this->shape = $shape;

		if($multiline == false)
			$this->text = str_replace("\n", ' ', $text);
		else
			$this->text = $text;

		$this->replaceChar = $allNonEmpty;

	}

	function render() {

		$shapeRender = explode("\n", $this->shape->render());
		$consumedRow = 0;

		for($cursor = 0; $cursor < mb_strlen($this->text); $cursor++) {

			$letterToPlace = mb_substr($this->text, $cursor, 1);

			if( mb_strlen(trim($shapeRender[$consumedRow])) == 0 ) {
				$consumedRow++;
				if($consumedRow == count($shapeRender))
					break;
			}

			for($a = 0; $a < mb_strlen($shapeRender[$consumedRow]); $a++) {
				
				$shapeChar = mb_substr($shapeRender[$consumedRow], $a, 1);

				if( $shapeChar == ' ' )
					continue;
				else if ($shapeChar == $this->replaceChar || $this->replaceChar == true) {
					break;
				}


			}

			$shapeRender[$consumedRow][$a] = ' ';
			
			$output[ $consumedRow ][ $a ] = $letterToPlace;

		}

		$out = array_map(function($i) {

			$k = array_keys($i);
			$max = max($k);

			for($k = 0; $k < $max; $k++) {
				if(empty($i[$k]))
					$i[$k] = ' ';
			}

			ksort($i);

			return implode(explode("\n", implode($i)));
		}, $output);

		//$out = ['e'];

		return implode("\n", $out);

	}

}