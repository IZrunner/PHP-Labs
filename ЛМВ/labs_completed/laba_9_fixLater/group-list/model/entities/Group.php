<?php 

namespace Model;

class Group {
	private $id;
	private $number;
	private $starosta;
	private $department;

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getNumber() {
		return $this->number;
	}
	public function setNumber($number) {
		$this->number = $number;
		return $this;
	}

	public function getStarosta() {
		return $this->starosta;
	}
	public function setStarosta($starosta) {
		$this->starosta = $starosta;
		return $this;
	}

	public function getDepartment() {
		return $this->department;
	}
	public function setDepartment($department) {
		$this->department = $department;
		return $this;
	}
}
?>