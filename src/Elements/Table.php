<?php

namespace AsciiHero\Elements;

use \AsciiHero\Tools;

class Table implements \AsciiHero\AreaInterface {

	use \AsciiHero\Traits\Dimensions;
	
	private $align = STR_PAD_RIGHT;
	private $splitting = true;
	private $ignore_padding = false;

	private $text;
	private $row_processed;

	function __construct(array $table, int $w = 0, $align = STR_PAD_RIGHT, bool $splitting = true) {

		$this->setTable($table);
		$this->setAlign($align);
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

		$keys = $this->table['head'];
		$clean_rows = $this->table['rows'];

		// 1: Calculate the max width for each column!
		for($i = 0; $i < count($keys); $i++) {
			$value_bucked[$i] = max(array_map('mb_strlen', array_column($clean_rows, $i)));
		}

		// 2: Check if the key itself is bigger than the maximum.
		foreach($value_bucked as $index => $max) {
			if(mb_strlen($keys[$index]) > $max)
				$value_bucked[$index] = mb_strlen($keys[$index]);
		}

		// 3: Fill the spaces!
		foreach($keys as $index => $single)
			$head[] = Tools::pad($single, $value_bucked[$index], ' ', STR_PAD_BOTH);
		
		foreach($keys as $index => $single) {
			$column[$index] = Tools::pad_array(array_column($clean_rows, $index), $value_bucked[$index], ' ', STR_PAD_LEFT);
		}

		// We, now, have all the dimensions in order to create the table! we'll do in that order:
		// 1: Create all the needed chars/patterns
		// 2: Create the table rows ..
		// 3: Create the top & bottom lines ..

		# 1

		$left_column_char = '│';
		$right_column_char = '│';

		$left_column_char_head = '├';
		$right_column_char_head = '┤';

		$left_column_char_foot = '└';
		$right_column_char_foot = '┘';

		$column_separator = '│';
		$header_line_char = '─';
		$header_intersect_line = '┼';
		$foot_intersect_line = '┴';

		$top = '─';
		$top_intersect = '┬';
		$top_intersect_left = '┌';
		$top_intersect_right = '┐';

		$bottom = '-';
		$bottom_intersect = '+';
		$bottom_intersect_left = '_';
		$bottom_intersect_right = '@';

		$extra_char = ' ';
		$extra_left = 0;
		$extra_right = 0;

		$padding_char = ' ';
		$padding_left = 1;
		$padding_right = 1;

		$header_separate = true;

		// Chars for all lines:
		$extra_string_left = $extra_left > 0 ? Tools::pad($extra_char, $extra_left, $extra_char) : '';
		$extra_string_right = $extra_right > 0 ? Tools::pad($extra_char, $extra_right, $extra_char) : '';

		// Chars for each column
		$padding_string_left = $padding_left > 0 ? Tools::pad($padding_char, $padding_left, $padding_char) : '';
		$padding_string_right = $padding_right > 0 ? Tools::pad($padding_char, $padding_right, $padding_char) : '';

		# 2 > Header Rows
		$head_closing = false;

		$raw_row = [];
		foreach($head as $value)
			$raw_row[] = Tools::pad('', mb_strlen($padding_string_right) + mb_strlen($padding_string_left) + mb_strlen($value), $header_line_char);

		$table_closing = $left_column_char_foot . Tools::pad('', mb_strlen($extra_string_left), $header_line_char) . implode($foot_intersect_line, $raw_row) . Tools::pad('', mb_strlen($extra_string_left), $header_line_char) . $right_column_char_foot;
		$table_rows[] = $top_intersect_left . Tools::pad('', mb_strlen($extra_string_left), $header_line_char) . implode($top_intersect, $raw_row) . Tools::pad('', mb_strlen($extra_string_left), $header_line_char) . $top_intersect_right;
		
		if($header_separate) {
			$head_closing = $left_column_char_head . Tools::pad('', mb_strlen($extra_string_left), $header_line_char) . implode($header_intersect_line, $raw_row) . Tools::pad('', mb_strlen($extra_string_left), $header_line_char) . $right_column_char_head;
		}

		$raw_row = [];
		foreach($head as $value)
			$raw_row[] = $padding_string_left . $value . $padding_string_right;

		$table_rows[] = $left_column_char . $extra_string_left . implode($column_separator, $raw_row) . $extra_string_right . $right_column_char;

		if($head_closing) $table_rows[] = $head_closing;

		# 2 > Body Rows
		foreach($clean_rows as $index => $row) {

			$raw_row = [];
			for($i = 0; $i < count($column); $i++)
				$raw_row[] = $padding_string_left . $column[$i][$index] . $padding_string_right;

			$table_rows[] = $left_column_char . $extra_string_left . implode($column_separator, $raw_row) . $extra_string_right . $right_column_char;

		}

		if($table_closing) $table_rows[] = $table_closing;

		return implode("\n", $table_rows);

		/*$base_text = $this->text;

		// 1: Divide block by new lines..
		$lines = explode("\n", $base_text);

		foreach($lines as $single_line)
			$elaborated_lines[] = Tools::wrap($single_line, $this->w, "\n", $this->splitting);

		// 2: Fill the line gap, based on the align method.
		$padded_lines = array_map(function($line) {
			return implode("\n", array_map(function($single_line) {
				return Tools::pad($single_line, $this->w, ' ', $this->align);
			}, $line));
		}, $elaborated_lines);*/

		// return implode($padded_lines, "\n\n");

	}

	public function bounding_box() {

		return [
			'w' => mb_strlen(explode("\n", $this->render())[0]),
			'h' => count(explode("\n", $this->render()))
		];

	}

	public function setTable(array $table) {

		$keys = array_keys($table[0]);
		$clean_columns = array_map('array_values', $table);

		$this->table = [
			'head' => $keys,
			'rows' => $clean_columns
		];

	}

	public function setSplitting(bool $splitting) {
		$this->splitting = $splitting;
	}

	public function setAlign($align) {
		$this->align = $align;
	}

}