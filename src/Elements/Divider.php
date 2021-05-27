<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Divider implements \AsciiHero\AreaInterface {

	use \AsciiHero\TraitFlexWidth;

	private $base = false;
	private $padder = false;
	private $w = false;

	private $top = false;
	private $bottom = false;

	public function ignorePadding() {
		return true;
	}

	public function render() {

		for($i = 0; $i < $this->top; $i++)
			$out[] = Tools::pad(' ', $this->w, ' ');

		$out[] = Tools::pad($this->base, $this->w, $this->padder);

		for($i = 0; $i < $this->bottom; $i++)
			$out[] = Tools::pad(' ', $this->w, ' ');

		return implode("\n", $out);

	}

	public function setWidth($val) {
		$this->w = $val;
	}

	public function width() {
		return $this->w;
	}

	public function bounding_box() {

		return [
			'w' => $this->width(),
			'h' => count(explode("\n", $this->render()))
		];

	}

	function __construct($base, $divider = false, $top = 0, $bottom = 0) {
		$this->base = $base;
		$this->padder = $divider ?: $base;
		$this->top = $top;
		$this->bottom = $bottom ?: $top;
	}

}