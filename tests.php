<?php

include 'examples.php';

define('EQUALIZE_TOP', 1);
define('EQUALIZE_BOTTOM', 2);
define('EQUALIZE_BOTH', 3);

include __DIR__ . '/vendor/autoload.php';

if(false) {
	
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

	$layout->row([ $area_1, $area_2 ]);

	$render = $layout->render();

}

if(false) {

	$textBlock_1 = new AsciiHero\Elements\Text($examples['long_text'], 50, STR_PAD_LEFT, true);
	$textBlock_1_1 = new AsciiHero\Elements\Text($examples['long_text'], 50, STR_PAD_LEFT, true);
	$textBlock_2 = new AsciiHero\Elements\Text($examples['text'], 40, STR_PAD_BOTH, true);
	$textBlock_3 = new AsciiHero\Elements\Text($examples['long_text'], 35, STR_PAD_RIGHT, true);
	$textBlock_4 = new AsciiHero\Elements\Text($examples['long_text'], 25, STR_PAD_RIGHT, true);
	$textBlock_5 = new AsciiHero\Elements\Text($examples['text'], 2, STR_PAD_RIGHT, true);
	$textBlock_5->inherit_width = true;

	$area_1 = new AsciiHero\Elements\Area();
	$area_1->padding(1,1,1,1);
	$area_1->no_decoration();
	$area_1->append($textBlock_1);
	$area_1->append(new \AsciiHero\Elements\Divider('*-', false, 2));
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

	$area_5 = new AsciiHero\Elements\Area(70);
	$area_5->padding(1,1,1,1);
	//$area_5->no_decoration();
	$area_5->append($textBlock_5);
	$area_5->calculate_size();

	$layout = new AsciiHero\Elements\Layout();
	$layout->equalize(EQUALIZE_BOTH);

	$layout->row([ $area_1, $area_4, $area_3 ]);
	$layout->row([ $area_5, $area_2 ]);

	//$layout_render = $layout->render();

	$area_4 = new AsciiHero\Elements\Area();
	$area_4->padding(0, 2, 0, 2);
	$area_4->append($layout);
	$area_4->calculate_size();

	$render = $area_4->render();

}

if(false) {

	$table_data = [
		[ 'sku' => 'AA001', 'name' => 'Computer', 'price' => 4000, 'qty' => 1, 'amount' => rand() ],
		[ 'sku' => 'AA002', 'name' => 'Super Duper Mouse', 'price' => 5, 'qty' => 10, 'amount' => rand() ],
	];

	$table = new AsciiHero\Elements\Table($table_data);
	$text = new AsciiHero\Elements\Text("Look at that table!", 0, STR_PAD_BOTH, true);
	$text->inherit_width = true;

	$text2 = new AsciiHero\Elements\Text(date('r'), NULL, STR_PAD_BOTH, true);
	$text2->inherit_width = true;

	$area_4 = new AsciiHero\Elements\Area(80);
	$area_4->padding(0, 0, 0, 0);
	$area_4->append($table);
	$area_4->append($text);
	$area_4->append(new AsciiHero\Elements\Divider('*-'));
	$area_4->append($text2);
	$area_4->calculate_size();

	$textBlock_3 = new AsciiHero\Elements\Text($examples['long_text'], 35, STR_PAD_RIGHT, true);
	$area = new AsciiHero\Elements\Area();
	$area->padding(0,0,0,1);
	$area->no_decoration();
	$area->append($textBlock_3);
	$area->calculate_size();

	$layout = new AsciiHero\Elements\Layout();
	$layout->equalize(EQUALIZE_BOTH);

	$layout->row([ $area_4, $area ]);

	$area3 = new AsciiHero\Elements\Area();
	$area3->append($layout);

	$render = $area3->render();

}

if(false) {

	/* Stack */

	$rectangle_1 = new \AsciiHero\Elements\Rectangle(20,10); // 2:1 looks like square ^_^
	$rectangle_2 = new \AsciiHero\Elements\Rectangle(10,5, 'o');

	$text = new AsciiHero\Elements\Text("Look at that table!", 0, STR_PAD_BOTH, true);
	$text_area = new AsciiHero\Elements\Area();
	$text_area->p(1, 2);
	$text_area->append($text);
	$text_area->calculate_size();

	$stack = new \AsciiHero\Elements\Stack();
	$stack->append($rectangle_1, [ 'x' => 1, 'y' => 1]);
	$stack->append($rectangle_2, [ 'x' => 5, 'y' => 0]);
	$stack->append($text_area, [ 'x' => 7, 'y' => 3]);

	$area = new AsciiHero\Elements\Area();
	$area->append($stack);

	$render = $area->render();


}

if(false) {

	$plain_1 = new \AsciiHero\Elements\Plain(file_get_contents(__DIR__ . '/examples/art2.txt'));
	$plain_2 = new \AsciiHero\Elements\Plain(file_get_contents(__DIR__ . '/examples/art1.txt'));
	$text_o = new AsciiHero\Elements\Text("AsciiHero", 0, STR_PAD_BOTH, true);
	$text = new AsciiHero\Elements\Area();
	$text->padding(0, 2, 0, 2);
	$text->append($text_o);

	$stack = new \AsciiHero\Elements\Stack();
	$stack->append($plain_1, [ 'x' => 0, 'y' => 0]);
	$stack->append($text, [ 'x' => 0, 'y' => 2]);

	$stack_2 = new \AsciiHero\Elements\Stack();
	$stack_2->append($plain_2, [ 'x' => 0, 'y' => 0]);
	$stack_2->append($text, [ 'x' => 0, 'y' => 2]);
	
	$area = new AsciiHero\Elements\Area();
	$area->p(0, 5);
	$area->append($stack);

	$area_2 = new AsciiHero\Elements\Area();
	$area_2->p(0, 5);
	$area_2->append($stack_2);

	$layout = new \AsciiHero\Elements\Layout();
	$layout->equalize(EQUALIZE_BOTH);
	$layout->row( [ $area, $area_2 ] );

	$render = $layout->render();

}

if(true) {

	$render = '';

	$rectangle_1 = new \AsciiHero\Elements\Rectangle(10,5);
	$rectangle_2 = new \AsciiHero\Elements\Rectangle(20,5);
	$rectangle_3 = new \AsciiHero\Elements\Rectangle(10,25);
	
	$plain_2 = new \AsciiHero\Elements\Plain(file_get_contents(__DIR__ . '/examples/art2.txt'));

	$stack = new \AsciiHero\Elements\Stack();
	$stack->append($rectangle_1, [ 'x' => 0, 'y' => 0 ]);
	$stack->append($rectangle_2, [ 'x' => 16, 'y' => 0 ]);
	$stack->append($rectangle_3, [ 'x' => 8, 'y' => 2 ]);

	$text_shape = new \AsciiHero\Elements\TextShape($examples['long_text'], $plain_2, '#', true);

	$render = $text_shape->render();

}

//header('Content-type: text/plain');
echo $render;
echo "\n\n";

die();