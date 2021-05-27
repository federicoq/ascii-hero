<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Area implements \AsciiHero\AreaInterface {

	private $align = STR_PAD_BOTH;
	private $zIndex = 0;

	function __construct(int $w = 100, int $h = 100, int $x = 0, int $y = 0) {

		$this->setWidth($w);
		$this->setHeight($h);

	}

	/**
	 * IGNORE PADDING!
	 * 
	 * (implemented from \AsciiHero\AreaInterface)
	 * if true, the element should be rendered without the
	 * padding of the container (if any)
	 * 
	 * @return [type] [description]
	 */
	public function ignorePadding() {
		return false;
	}

	# dimensions
	private $w = 0;
	private $h = 0;

	public function calculate_size() {

		$h = 0;
		$w = 0;

		foreach($this->elements as $element) {

			if(!empty($element->inherit_width)) {
				$element->setWidth($this->w + $this->padding['left'] + $this->padding['right']);
			}

			$meta = $element->bounding_box();

			if($meta['w'] > $w)
				$w = $meta['w'];

			$h += $meta['h'];

		}

		if($w)
			$this->w = $w;
		$this->h = $h;

		return true;

	}

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

	public function bounding_box() {

		return [
			'w' => $this->width(),
			'h' => count(explode("\n", $this->render()))
		];

	}


	# spacing
	private $spacing = 0;

	public function spacing(int $value) {
		$this->spacing = $value;
	}

	public function no_spacing() {
		return $this->spacing(0);
	}


	# padding
	private $padding = [
		'top' => 0,
		'left' => 0,
		'right' => 0,
		'bottom' => 0
	];

	public function padding($top, $right, $bottom, $left) {
		$this->padding = compact('top', 'left', 'right', 'bottom');
	}

	public function no_padding() {
		return $this->p(0);
	}

	public function p($top, $side = false) {
		$side = $side ?: $top;
		$this->padding($top, $side, $top, $side);
	}


	# decoration
	private $decoration = [
		'top' => '─',
		'left' => '│',
		'right' => '│',
		'bottom' => '─',
		'topleft' => '┌',
		'topright' => '┐',
		'bottomleft' => '└',
		'bottomright' => '┘'
	];

	public function has_decoration() {
		return !empty(array_values(array_filter($this->decoration)));
	}

	public function decoration(array $value) {
		foreach($value as $k => $v) {
			$this->decoration[$k] = $v;
		}
	}

	public function no_decoration() {
		foreach($this->decoration as $k => $v) {
			$this->decoration[$k] = false;
		}
	}


	# elements
	private $elements = [];

	public function append(\AsciiHero\AreaInterface $element) {
		$this->elements[] = $element;
	}

	public function render() {

		$pre = '';
		for($i = 0; $i < $this->padding['left']; $i++)
			$pre .= ' ';

		$post = '';
		for($i = 0; $i < $this->padding['right']; $i++)
			$post .= ' ';

		$queue = [];
		for($i = 0; $i < $this->padding['top']; $i++)
			$queue[] = $pre . Tools::pad(' ', $this->w, ' ', $this->align) . $post;

		foreach($this->elements as $k => $element) {

			if(!empty($element->inherit_width)) {
				$element->setWidth($this->w + mb_strlen($pre) + mb_strlen($post));
			}

			$relative_render = $element->render();
			$relative_rows = explode("\n", $relative_render);
			$ignorePadding = false;
			$last = $k == count($this->elements) - 1 ? true : false;

			if($element->ignorePadding() == true)
				$ignorePadding = true;

			$fixed_row = array_map(function($row) use ($pre, $post, $ignorePadding) {

				return ($ignorePadding == false ? $pre : '') . Tools::pad($row, $this->w, ' ', $this->align) . ($ignorePadding == false ? $post : '');

			}, $relative_rows);

			if(!$last && !empty($this->spacing)) {
				for($i = 0; $i < $this->spacing; $i++)
					$fixed_row[] = "";
			}

			$queue[] = implode("\n", $fixed_row);

		}

		for($i = 0; $i < $this->padding['bottom']; $i++)
			$queue[] = $pre . Tools::pad(' ', $this->w, ' ', $this->align) . $post;


		$body = implode("\n", $queue);

		if(!$this->has_decoration())
			return $body;
		else {
			return Tools::decoration($body, $this->decoration);
		}

	}

}