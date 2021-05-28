<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Stack implements \AsciiHero\AreaInterface {

	use \AsciiHero\TraitDimensions;
	use \AsciiHero\TraitBoundingBoxStandard;
	use \AsciiHero\Traits\UsePadding;

	

	function __construct() {

	}
	
	# elements
	private $elements = [];

	public function append(\AsciiHero\AreaInterface $element, $coordinates) {

		$autoIndex = count($this->elements) + 1;
		$zIndex = $autoIndex;

		if(method_exists($element, 'zIndex') && $element->zIndex()) {
			$zIndex = $element->zIndex();
		}

		$this->elements[] = [ 'zIndex' => $zIndex, 'coordinates' => $coordinates, 'object' => $element ];
	}


	function render() {

		usort($this->elements, function($a, $b) {
			return $a['zIndex'] > $b['zIndex'];
		});

		foreach($this->elements as $element)
			$renders[] = explode("\n", $element['object']->render());

		foreach($this->elements as $index => $element) {

			$render = $renders[$index];
			foreach($render as $lineIndex => $line) {

				$row = $lineIndex + $element['coordinates']['y'];
				$xOffset = $element['coordinates']['x'];

				for($i = 0; $i < mb_strlen($line); $i++) {
					$output[ $row ][ $i + $xOffset ] = mb_substr($line, $i, 1);
				}

			}

		}

		$output = array_map(function($i) {

			$ks = array_keys($i);
			$max = max($ks);

			for($k = 0; $k < $max; $k++) {
				if(empty($i[$k]))
					$i[$k] = ' ';
			}

			ksort($i);

			return $i;

		}, $output);
		
		$collapsed = array_map(function($i) {
			$keys = array_keys($i);
			$diff = min($keys);
			$row = implode($i);
			return Tools::pad($row, mb_strlen($row) + $diff, ' ', STR_PAD_LEFT);
		}, $output);

		$rows_keys = min(array_keys($collapsed));
		for($i = 0; $i < $rows_keys; $i++)
			$collapsed[0] = '';
		
		ksort($collapsed);

		$maxWidth = max(array_map('mb_strlen', $collapsed));
		$finalObject = array_map(function($row) use ($maxWidth) {
			return Tools::pad($row, $maxWidth);
		}, $collapsed);

		return implode("\n", $finalObject);

	}

}