<?php

namespace AsciiHero;

trait TraitDimensions {

	# dimensions
	private $w = 0;
	private $h = 0;
	private $zIndex = 0;

	public function setWidth(int $width) {
		$this->w = $width;
	}

	public function setHeight(int $height) {
		$this->h = $height;
	}

	public function width() {
		return $this->w;
	}

	public function height() {
		return $this->h;
	}

	public function setZIndex(int $value) {
		$this->zIndex = $value;
	}

	public function zIndex() {
		return $this->zIndex;
	}

}