<?php

namespace ISM\Filters;

interface FilterModel {
	const PAGE_NO = 'page_no';
	const PER_PAGE = 'per_page';
	const PAGE_ONE_GET_ALL = 'get_all';
	const PER_PAGE_COUNT = 20;
	public function getFilterFormat();
}
