<?php

namespace Ism\Filter;

class FilterTable {
	private $model;
	private $fields;
	public function __construct(FilterModel $model, array $params) {
		$this->setModel ( $model );
		$filteredParams = $this->buildFilterParams ( $params, $this->getModel ()->getFilterFormat () );
		$fields = $this->createFieldData ( $filteredParams );
		$this->setFields ( $fields );
	}
	public function getModel() {
		return $this->model;
	}
	public function setModel( $model) {
		$this->model = $model;
	}
	public function getFields() {
		return $this->fields;
	}
	public function setFields(array $fields) {
		$this->fields = [ ];
		foreach ( $fields as $field ) {
			$this->setField ( $field );
		}
	}
	private function setField(FilterField $field) {
		$this->fields [] = $field;
	}
	public function filterGet($paginationParams=[], $orderBy= null, $select = null) {
		$paginationParams = Util::getPaginationParams($paginationParams);
		$query = $this->addFilterFields ();
		return Util::getPaginationResult ( $query, $paginationParams [Util::PAGE_NO],$paginationParams [Util::PER_PAGE], $orderBy, true, $select );
	}
	private function addFilterFields() {
		$query = $this->model;
		foreach ( $this->fields as $field ) {
			$query = $field->buildQuery ( $query );
		}
		return $query;
	}
	private function createFieldData(array $fieldArray) {
		$array = [ ];
		foreach ( $fieldArray as $field ) {
			$array [] = new FilterField ( $field [0], $field [1], $field [2] );
		}
		return $array;
	}
	private function buildFilterParams($params, $format) {
		$filterParams = [ ];
		foreach ( $params as $k => $v ) {
			if (isset ( $format [$k] )) {
				$filterParams [] = [ 
						$format [$k] [0],
						$format [$k] [1],
						$v 
				];
			}
		}
		return $filterParams;
	}
}
