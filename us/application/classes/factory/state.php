<?php defined('SYSPATH') or die('No direct script access.');

class Factory_State {


	/**
	*	isState - validation for state name from url. 
	*			see also: bootstrap
	*
	*
	*/
	static function isState($state_name)
	{
		$query = DB::select()->from('state')->where('state_url', 'LIKE', $state_name);

		$results = $query->execute();
		$found = FALSE;
		foreach($results as $state)
		{
		    //$found = TRUE;
			// Need to return the state name without the hyphen
			$found = $state['state_name'];
		}
		return $found;
	}
	
	
	/**
	*	getZipByState
	*
	*	todo: cache this query large table
	*/
	static function getZipByState($state_name, $order_by='city_name', $order_direction='ASC')
	{
		// return DB::select()->from('zip_info_state')->where('state_name', 'LIKE', '%'.$state_name.'%')->order_by($order_by, $order_direction);
		$query = DB::select()->from('zip_info_state')->where('state_name', 'LIKE', '%'.$state_name.'%')->order_by($order_by, $order_direction);
		$results = $query->execute();
		return $results;
	}


	/**
	*	getStates
	*
	*	state VALUES (id, state_name, state_abbv, state_url)
	*
	*	todo: use orm
	*/
	static function getStates()
	{
		// return DB::select()->from('state')->order_by('state_name', 'ASC');
		$query = DB::select()->from('state')->order_by('state_name', 'ASC');
		$results = $query->execute();
		return $results;
	}


	/**
	*	getFooterCity - Query results object of important SEO cities
	* 		Query example here
	*
	* 	name_value VALUES (id, type, name, value)
	*	todo: use orm
	*/	
	static function getFooterCity()
	{	
		$query =  DB::select()->from('name_value')->where('type', '=', 'city')->order_by('name');
		$results = $query->execute();
		return $results;
	}
	

	/**
	*	getFooterLast
	*		select ID, post_name, post_title, guid  from lfas_posts where post_parent=0 and post_type='page';
	*
	*/
	static function getPageList()
	{
		$a_select = array('ID','post_name','post_title', 'guid');

		$query =  DB::select_array($a_select)->from('lfas_posts')->where('post_type', '=', 'page')->and_where('post_parent', '=', '0')->and_where('post_status', '=', 'publish');
		// echo $query;
		return $query->execute();
	}

	
} // End