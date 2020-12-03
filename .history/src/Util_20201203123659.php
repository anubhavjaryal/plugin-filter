<?php

namespace Ism\Filter;

class Util {
	const PAGE_NO = 'page_no';
	const PER_PAGE = 'per_page';
	const PAGE_ONE_GET_ALL = 'get_all';
	const PER_PAGE_COUNT = 20;
	public static function getPaginationParams(&$getParams) {
		$result [self::PAGE_NO] = (isset ( $getParams [self::PAGE_ONE_GET_ALL] )) ? null : ((! isset ( $getParams [self::PAGE_NO] ) || $getParams [self::PAGE_NO] <= 0) ? 1 : $getParams [self::PAGE_NO]);
		$result [self::PER_PAGE] = (isset ( $getParams [self::PAGE_ONE_GET_ALL] )) ? null : ((! isset ( $getParams [self::PER_PAGE] ) || $getParams [self::PER_PAGE] <= 0) ? self::PER_PAGE_COUNT : $getParams [self::PER_PAGE]);
		return $getParams;
	}
	public static function getPaginationResult($query, $pageNo = null, $perPage = null, $orderBy = null, $c = true, $select = null) {
		$count = $c ? $query->count () : -1;
		if (! $pageNo || ! $perPage) {
			$pageNo = 1;
			$perPage = $count;
		}
		$pageNo --;
		if ($orderBy) {
			foreach ( $orderBy as $orderArray ) {
				$query = $query->orderBy ( $orderArray [0], $orderArray [1] );
			}
		} 
		$result = $query->skip ( $pageNo * $perPage )->take ( $perPage );
		if($select){
			$result = $result->select($select);
		}
		$result = $result->get();
		return [
				'status' => 'success',
				'metadata'=>[
					'count' => $count,
					'pageNo' => ++ $pageNo,
					'perPage' => ( int ) $perPage,
					'showing' => sizeof ( $result ) 
				],
				'data' => $result
		];
	}
}
