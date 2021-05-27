<?php

if(true) {
	
	$textBlock_1 = new AsciiHero\Elements\Text($examples['long_text'], 45, STR_PAD_BOTH, true);
	$textBlock_2 = new AsciiHero\Elements\Text($examples['text'], 50, STR_PAD_LEFT, true);
	$textBlock_3 = new AsciiHero\Elements\Text($examples['long_text'], 50, STR_PAD_RIGHT, true);

	$area_1 = new AsciiHero\Elements\Area();
	//$area_1->decoration([ 'bottomleft' => '┼', 'bottomright' => '┼' ]);
	//$area_1->no_decoration();
	$area_1->spacing(1);
	$area_1->padding(2, 4, 2, 4);
	$area_1->append($textBlock_1);
	$area_1->append($textBlock_2);
	$area_1->calculate_size();

	$area_2 = new AsciiHero\Elements\Area();
	$area_2->no_decoration();
	$area_2->spacing(1);
	$area_2->padding(3, 2, 3, 2);
	$area_2->append($textBlock_3);
	$area_2->calculate_size();

	$layout = new AsciiHero\Elements\Layout();
	$layout->equalize(EQUALIZE_BOTH);

	$layout->row([ $area_1->render(), $area_2->render() ]);

	$render = $layout->render();

}

if(false) {

	$textBlock_1 = new AsciiHero\Elements\Text($examples['long_text'], 50, STR_PAD_LEFT, true);
	$textBlock_1_1 = new AsciiHero\Elements\Text($examples['long_text'], 50, STR_PAD_LEFT, true);
	$textBlock_2 = new AsciiHero\Elements\Text($examples['long_text'], 40, STR_PAD_BOTH, true);
	$textBlock_3 = new AsciiHero\Elements\Text($examples['long_text'], 35, STR_PAD_RIGHT, true);
	$textBlock_4 = new AsciiHero\Elements\Text($examples['long_text'], 25, STR_PAD_RIGHT, true);
	$textBlock_5 = new AsciiHero\Elements\Text($examples['long_text'], 25, STR_PAD_RIGHT, true);
	$textBlock_5->inherit_width = true;

	$area_1 = new AsciiHero\Elements\Area();
	$area_1->padding(1,1,1,1);
	$area_1->no_decoration();
	$area_1->append($textBlock_1);
	$area_1->append(new \AsciiHero\Elements\Divider('*', false, 2));
	$area_1->append($textBlock_1_1);
	$area_1->calculate_size();

	$area_2 = new AsciiHero\Elements\Area();
	$area_2->padding(1,1,1,1);
	$area_2->no_decoration();
	$area_2->append($textBlock_2);
	$area_2->calculate_size();

	$area_3 = new AsciiHero\Elements\Area();
	$area_3->padding(1,1,1,1);
	$area_3->no_decoration();
	$area_3->append($textBlock_3);
	$area_3->calculate_size();

	$area_4 = new AsciiHero\Elements\Area();
	$area_4->padding(1,1,1,1);
	$area_4->no_decoration();
	$area_4->append($textBlock_4);
	$area_4->calculate_size();

	$area_5 = new AsciiHero\Elements\Area(150);
	$area_5->padding(1,1,1,1);
	//$area_5->no_decoration();
	$area_5->append($textBlock_5);
	$area_5->calculate_size();

	$layout = new AsciiHero\Elements\Layout();
	$layout->equalize(EQUALIZE_BOTH);

	$layout->row([ $area_1->render(), $area_4->render(), $area_3->render(), $area_2->render() ]);
	$layout->row([ $area_5->render() ]);

	//$layout_render = $layout->render();

	$area_4 = new AsciiHero\Elements\Area();
	$area_4->padding(0, 2, 0, 2);
	$area_4->append($layout);
	$area_4->calculate_size();

	$render = $area_4->render();

}



include 'tpl.php';