<?php

class Task
{
	private $db;
	private $table_name = "task";
	private $column_name = "prioritet";

	private $ime_taska;
	private $prioritet;
	private $rok;

	public function __construct($db){
		$this->db = $db;
	}

	public function setImeTask($ime_taska){
		$this->naziv_taska = $naziv_taska;
	}

	public function setPrioritet($prioritet){
		$this->prioritet = $prioritet;
	}

	public function setRok($rok){
		$this->rok = $rok;
	}
}