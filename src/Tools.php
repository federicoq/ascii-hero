<?php

namespace AsciiHero;

class Tools {

	static function decoration($string, $decoration = [], $auto_intersect = false) {

		$lines = explode("\n", $string);
		$lines_length = max(array_map(function($i) {
			return mb_strlen($i);
		}, $lines));

		// Creation of the characters:
		$head = true;
		$bot = true;

		$tl = $decoration['topleft'];
		$tr = $decoration['topright'];
		$t = $decoration['top'];
		
		if(!empty($t) && ( !empty($tl) || !empty($tr) ))
			$head = true;

		$bl = $decoration['bottomleft'];
		$br = $decoration['bottomright'];
		$b = $decoration['bottom'];

		if(!empty($b) && ( !empty($bl) || !empty($br) ))
			$bot = true;

		$l = $decoration['left'] ?: ( $head || $bot ? ' ' : '' );
		$r = $decoration['right'] ?: ( $head || $bot ? ' ' : '' );

		// Fix the lines! :)
		$fixed_lines = implode("\n", array_map(function($line) use ($l, $r, $lines_length, $decoration, $auto_intersect) {

			if($auto_intersect) {
				
				$first_char = mb_substr($line, 0, 1);
				$last_char = mb_substr($line, mb_strlen($line) - 1, 1);

				if($first_char == $last_char && ( $last_char == $decoration['top'] || $last_char == $decoration['bottom'] )) {
					$l = $decoration['joinleft'];
					$r = $decoration['joinright'];
				}

			}


			return $l . self::pad($line, $lines_length, ' ') . $r;

		}, $lines));

		// Create the heading & Footer
		if($head)
			$body_head = $tl . self::pad($t, $lines_length, $t) . $tr;

		if($bot)
			$body_bot = $bl . self::pad($b, $lines_length, $b) . $br;

		return implode("\n", array_values(array_filter([
			$body_head ?: false,
			$fixed_lines ?: false,
			$body_bot ?: false
		])));

	}

	static function wrapSplitting($str, $width = 75, $break = "\n", $cut = true) { // wordwrap, basically, but `mb` oriented.

		$lines = explode($break, $str);

		foreach($lines as &$line) {

			$line = rtrim($line);

			if(mb_strlen($line) <= $width)
				continue;

			$words = explode(' ', $line);
			$line = '';
			$actual = '';

			foreach($words as $word) {

				if(mb_strlen( $actual . $word ) <= $width)
					$actual .= $word.' ';
				else {

					if($actual != '')
						$line .= rtrim($actual).$break;
					$actual = $word;

					if($cut) {

						while (mb_strlen($actual) > $width) {
							$line .= mb_substr($actual, 0, $width).$break;
							$actual = mb_substr($actual, $width);
						}

					}

					$actual .= ' ';

				}

			}

			$line .= trim($actual);

		}

		return implode($break, $lines);

	}

	static function pad_array($array, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT) {

		return array_map(function($item) use ($pad_len, $pad_str, $dir) {
			return self::pad($item, $pad_len, $pad_str, $dir);
		}, $array);

	}

	static function pad($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT) {
		
		$str_len = mb_strlen($str);
		$pad_str_len = mb_strlen($pad_str);

		if(!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT))
			$str_len = 1; // @debug

		if (!$pad_len || !$pad_str_len || $pad_len <= $str_len)
			return $str;

		$result = null;
		if ($dir == STR_PAD_BOTH) {

			$length = ($pad_len - $str_len) / 2;
			$repeat = ceil($length / $pad_str_len);
			$result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length)) . $str . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));

		} else {

			$repeat = ceil($str_len - $pad_str_len + $pad_len);
			if ($dir == STR_PAD_RIGHT) {
				$result = $str . str_repeat($pad_str, $repeat);
				$result = mb_substr($result, 0, $pad_len);
			} else if ($dir == STR_PAD_LEFT) {
				$result = str_repeat($pad_str, $repeat);
				$result = mb_substr($result, 0, $pad_len - (($str_len - $pad_str_len) + $pad_str_len)) . $str;
	        }
	    }

	    return $result;
	    
	}

	static function isChar(string $string) {
		return mb_ereg_match("\w", $string);
	}

	static function wrapExact($str, $width = 75, $break = "\n", $breaker = '-') {

		$lines_original = explode($break, $str);
		$lines = [];

		foreach($lines_original as $line) {

			$line = rtrim($line);
			$length = mb_strlen($line);
			$actual = '';
			$partial = [];

			for($i = 0; $i < $length; $i++) {

				if(mb_strlen($actual) >= $width) {
					$partial[] = trim($actual);
					$actual = '';
				}

				$prev_long = mb_substr($line, $i - 2, 1);
				$next_long = mb_substr($line, $i + 2, 1);

				$prev = mb_substr($line, $i - 1, 1);
				$curr = mb_substr($line, $i, 1);
				$next = mb_substr($line, $i + 1, 1);

				$end_line = mb_strlen($actual) + 1 == $width ? true : false;

				if($end_line) {

					if( mb_ereg_match("\w", $curr) ) {

						if( self::isChar($next) ) {

							if( self::isChar($prev) ) {
								$i--;
								$actual .= '-';
							} else {
								$i--;
								$actual .= ' ';
							}

						} else {
							$actual .= $curr;
						}

					} else 

						$actual .= $curr;

				} else 
					$actual .= $curr;

			}

			if(mb_strlen($actual) > 0)
				$partial[] = $actual;

			$lines[] = implode($break, $partial);

		}

		return implode($break, $lines);

	}

	static function wrap($str, $width = 75, $break = "\n", $cut = false) {

		if($cut == true)
			$raw = self::wrapSplitting($str, $width, $break);
		else
			$raw = self::wrapExact($str, $width, $break);

		return explode($break, $raw);

	}

}