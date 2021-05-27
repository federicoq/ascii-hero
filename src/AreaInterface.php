<?php

namespace AsciiHero;

interface AreaInterface {

	function render();
	function bounding_box();

	function ignorePadding();

}