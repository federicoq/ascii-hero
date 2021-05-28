<?php

namespace AsciiHero;

trait TraitBoundingBoxStandard {

	public function bounding_box() {

		return [
			'w' => mb_strlen(explode("\n", $this->render())[0]),
			'h' => count(explode("\n", $this->render()))
		];

	}

}