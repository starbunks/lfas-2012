<?php defined('SYSPATH') or die('No direct script access.');

class Factory_Park {


	
	
	/**
	*	getZipByState
	*
	*	todo: cache this query large table
	*/
	static function getParkRoll($limit=10, $offset=0)
	{
		$query = DB::select()->from('park_roll')->where('found','=',' ')->limit($limit)->offset($offset);

		$results = $query->execute();
		return $results;
	}


	static function insertParkRoll($number, $url)
	{
		$query = DB::insert('park_roll', array('number', 'url'))->values(array($number, $url));
		$results = $query->execute();
		return $results;
	}

	static function updateParkRoll($number, $found, $curl_info='', $curl_html='' )
	{
		
		$query = DB::update('park_roll')->set(array('found' => $found, 'curl_info' => $curl_info, 'curl_html' => $curl_html))->where('number', '=', $number);
		echo '[]'.$query.'[]';
		$results = $query->execute();
		return $results;
	}
}	//End Factory_Park