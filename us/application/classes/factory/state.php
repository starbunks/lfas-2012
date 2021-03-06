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
		$query =  DB::select_array()->from('name_value')->where('type', '=', 'state-url')->and_where('value', 'LIKE', $state_name);
		
		$results = $query->execute();
		$found = FALSE;
		foreach($results as $state)
		{
		    //$found = TRUE;
			// Need to return the state name without the hyphen
			$found = $state['name'];
		}
		return $found;
	}
	
	
	/**
	*	getZipByState
	*
	*	@todo cache this query large table
	*
	*	@todo deprecate this because of getCityList
	*
	*/
	static function getZipByState($state_name, $order_by='city_name', $order_direction='ASC')
	{
		$query = DB::select()->from('zip_info_state')->where('state_name', 'LIKE', '%'.$state_name.'%')->order_by($order_by, $order_direction);

		$results = $query->execute();
		return $results;
	}


	/**
	*	getStates
	*
	*	state VALUES (state name, state url)
	*
	*	@todo use orm
	*/
	static function getStates()
	{
		$query = DB::select()->from('name_value')->where('type', '=', 'state-url')->order_by('name', 'ASC');
		$results = $query->execute();
		return $results;
	}


	/**
	*
	*
	*	@todo implement me
	*
	*	list of states
	*	SELECT zip_id, zip_code, substring(city_name,1,1), city_name, state_name 
	*	FROM `zips` WHERE `state_name` LIKE *	'%Alaska%' ORDER BY `city_name` ASC 
	*
	*
	*	list of states BY FIRST INITIAL
	*	SELECT zip_id, zip_code, substring(city_name,1,1) as first_letter, city_name, state_name 
	*	FROM `zip_info_state` WHERE `state_name` LIKE '%Alaska%' GROUP BY first_letter ORDER BY `city_name` ASC
	*
	*
	*	list of states by proper name, pretty url, abreviation
	*	select nv1.name AS 'state', nv1.value AS 'state-url', nv2.value AS 'stateabrev' 
	*	from name_value nv1, name_value nv2 
	*	where nv1.type = 'state-url' 
	*	AND nv2.type = 'stateabrev' 
	*	AND nv1.name = nv2.name;
	*
	*
	*/
	static function getCityList($state)
	{
		$a_select = array('zip_id', 'zip_code', 'city_name', 'state_name');
		
		$query =  DB::select_array($a_select)->from('zips')->where('state_name', 'LIKE', '%'.$state.'%')->order_by('city_name', 'ASC');
				
		return $query->execute();
	}



	/**
	*	getFooterCity - Query results object of important SEO cities
	* 		Query example here
	*
	* 	name_value VALUES (id, type, name, value)
	*	@todo use orm
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