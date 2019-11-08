<?php

namespace Ism\Filter;

class FilterField {
	private $name;
	private $compare;
	private $value = null;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function getCompare() {
		return $this->compare;
	}
	public function setCompare($compare) {
		$this->compare = $compare;
	}
	public function getValue() {
		return $this->value;
	}
	public function setValue($value) {
		$this->value = $value;
	}
	public function __construct($name, $compare, $value) {
		$this->setName ( $name );
		$this->setCompare ( $compare );
		$this->setValue ( $value );
	}
	public function buildQuery($modelObj) {
		switch (strtolower ( $this->compare )) {
			case "in" :
				if(gettype($this->getValue ()) != 'array'){
					$this->setValue([$this->getValue ()]);
				}
				return $modelObj->whereIn ( $this->getName (), $this->getValue () );
			case "between" :
				return $modelObj->whereBetween ( $this->getName (), $this->getValue () );
			case "notbetween" :
				return $modelObj->whereNotBetween ( $this->getName (), $this->getValue () );
			case "like" :
				return $modelObj->where ( $this->getName (), 'like', "%" . $this->getValue () . "%" );
			case "llike" :
				return $modelObj->where ( $this->getName (), 'like', "%" . $this->getValue () );
			case "rlike" :
				return $modelObj->where ( $this->getName (), 'like', $this->getValue () . "%" );
			case "xlike" :
        return $modelObj->where ( $this->getName (), 'like', $this->getValue ()  );
      case "with" :
        return $modelObj->with($this->getName ());
			case "=" :
			case "!=" :
			case ">" :
			case ">=" :
			case "<" :
			case "<=" :
				return $modelObj->where ( $this->name, $this->compare, $this->value );
			default :
				return $modelObj;
		}
	}
}