<?php

namespace AsciiHero\Traits;

trait BoundingBoxStandard {

	public function bounding_box() {

		return [
			'w' => mb_strlen(explode("\n", $this->render())[0]),
			'h' => count(explode("\n", $this->render()))
		];

	}

}