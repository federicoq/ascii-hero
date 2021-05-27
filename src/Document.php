<?php

namespace AsciiHero;

class Document {

	private $name = false;
	private $date = false;
	private $author = false;
	private $config = false;

	private $pages = [];

	function setAuthor(string $author) {
		$this->author = $author;
		return true;
	}

	function setDate(string $date) {
		$this->date = $date;
		return true;
	}

	function setName(string $name) {
		$this->name = $name;
		return true;
	}

	function setConfig(array $config) {
		$this->config = $config;
		return true;
	}

	function addPage(Page $page) {
		$this->pages[] = $page;
	}

	function __construct(string $name, string $author = NULL, string $date = NULL, array $config = []) {

		$this->setName($name);

		if(!empty($author))
			$this->setAuthor($author);

		if(!empty($date))
			$this->setDate($date);

		if(!empty($config))
			$this->setConfig($config);

	}

}