<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Text implements \AsciiHero\AreaInterface {

	use \AsciiHero\TraitDimensions;
	
	private $align = STR_PAD_RIGHT;
	private $splitting = true;
	private $ignore_padding = false;

	private $text;
	private $row_processed;

	function __construct(string $text, int $w = NULL, $align = STR_PAD_RIGHT, bool $splitting = true) {

		$this->setText($text);
		$this->setAlign($align);
		if($w == false)
			$w = mb_strlen($text);

		$this->setWidth($w);
		$this->setSplitting($splitting);

	}

	public function setIgnorePadding(bool $value) {
		$this->ignore_padding = $value;
	}

	public function ignorePadding() {
		return $this->ignore_padding;
	}

	public function render() {

		$base_text = $this->text;

		// 1: Divide block by new lines..
		$lines = explode("\n", $base_text);

		foreach($lines as $single_line)
			$elaborated_lines[] = Tools::wrap($single_line, $this->w, "\n", $this->splitting);

		// 2: Fill the line gap, based on the align method.
		$padded_lines = array_map(function($line) {
			return implode("\n", array_map(function($single_line) {
				return Tools::pad($single_line, $this->w, ' ', $this->align);
			}, $line));
		}, $elaborated_lines);

		return implode($padded_lines, "\n\n");

	}

	public function bounding_box() {

		return [
			'w' => $this->w,
			'h' => count(explode("\n", $this->render()))
		];

	}

	public function setText(string $text) {
		$this->text = $text;
	}

	public function setSplitting(bool $splitting) {
		$this->splitting = $splitting;
	}

	public function setAlign($align) {
		$this->align = $align;
	}

}