<?php defined('SYSPATH') or die('No direct script access.');

class Model_Pagelayout {

	protected $footer_html = '';
	
	public $page_title;
	
	/**
	* __construct
	*
	*/
	function __construct() 
	{

	}

	/*
	 *	buildFooterCityHtml
	 *
	 *	@todo cache the html results for the view
	 */
	static public function buildFooterCityHtml() 
	{

		$results = Factory_State::getFooterCity();
		$li = '';
		
		foreach($results as $city)
		{
			$li .= '<li><a href="' . 
				Service_Pageutility::getApplicationUrl() . 
				$city['value'] . 
				'" title="' . $city['name'] . 
				'">' . 
				$city['name']  . 
				'</a></li>';
				
			//$a_city[$city['id']]['name'] = $city['name'];
			//$a_city[$city['id']]['value'] = $city['value']
			
		}
		return '<ul>' . $li . '</ul>';
	}	


	/*
	 *	buildFooterLastHtml
	 * 
	 *	@todo cache the html results for the view
	 */
	static public function buildFooterLastHtml() 
	{

		$results = Factory_State::getPageList();

		$li = '';
		
		foreach($results as $list)
		{
			$li .= '<li><a href="' . 
				Service_Pageutility::getApplicationUrl() . 
				$list['post_name'] . 
				'" title="' . $list['post_title'] . 
				'">' . 
				$list['post_title']  . 
				'</a></li>';
			
		}
		return '<ul>' . $li . '</ul>';
	}

	/*
	 *	buildFooterLastHtml
	 * 
	 *	@todo cache the html results for the view
	 */
	static public function buildHeaderMenuHtml() 
	{

		$results = Factory_State::getPageList();

		$li = '';
		
		
		
		foreach($results as $list)
		{
			$li_class = ( $list['post_name']=='sitter-search'? 'current_page_item' : 'page_item');
			$li .= '<li class="' . $li_class . '"><a href="' . 
				Service_Pageutility::getApplicationUrl() . 
				$list['post_name'] . 
				'" title="' . $list['post_title'] . 
				'">' . 
				$list['post_title']  . 
				'</a></li>';
			
		}
		return '<div class="menu"><ul>' . $li . '</ul></div><!-- menu -->';
	}

	/*
	 *	buildCityHtml
	 *
	 *	@todo cache the html results for the view
	 */
	static public function buildCityHtml($state_name)
	{
		$results = Factory_State::getZipByState($state_name);
		$html_city_list = '';
		
		foreach($results as $zip)
		{
			$html_city_list .= '<li>' .
								Service_Breadcrumb::getPageBreadCrumbCity($zip['city_name'], 
																		$state_name, 
																		$zip['zip_code'], TRUE) .
								'</li>';										
		}
		return $html_city_list;
	}
	
	
	/*
	 *	buildStateHtml
	 *
	 *	@todo cache the html results for the view
	 */
	static public function buildStateHtml()
	{
		$results = Factory_State::getStates();
		$state_list = '';
		$results_count = count($results);
		$set = 0;
		$n = 0;
		$column_count = $results_count / 3;
		
		foreach($results as $state)
		{
			$state_list .= '<li><a href="' . url::base() . $state['state_url'] . '">' . $state['state_name'] . '</a></li>';
			
		    $a_state_list[$set][$state['id']]['state_name'] = $state['state_name'];
		    $a_state_list[$set][$state['id']]['state_url'] = url::base() . $state['state_url'];
			
			$n++;
			if ($n > $column_count)
			{
				$n = 0;
				$set++;
			}
		}

		$state_list = '<ul>' . $state_list . '</ul>';
		return $state_list;
	}
	
	
	
} // End