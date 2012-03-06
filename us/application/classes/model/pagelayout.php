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
		$li_home_page = '<li><a href="' . 
						Service_Pageutility::getSiteUrl() . 
						'" title="Home">Home</a></li>';
						
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
		return '<ul>' . $li_home_page . $li . '</ul>';
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
		$li_home_page = '<li class="current_page_item"><a href="' . 
						Service_Pageutility::getSiteUrl() . 
						'" title="Home">Home</a></li>';
		
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

		return '<div class="menu"><ul>' . $li_home_page . $li . '</ul></div><!-- menu -->';
	}

	/*
	 *	buildCityHtml
	 *
	 *	@todo cache the html results for the view
	 */
	static public function buildCityHtml($state_name)
	{
		$results = Factory_State::getZipByState($state_name);
		// $html_city_list = '';
		$state_list = '';
		$results_count = count($results);
		$set = 0;	// 
		$n = 0;
		$column_count = ($results_count / 3) - 1;


		// echo '<p>results_count [' . $results_count . ']</p>';
		// echo '<p>column_count [' . $column_count . ']</p>';
		
		$state_list .= '<div id="state-list"><ul>';
				
		foreach($results as $zip)
		{
			$state_list .= '<li>' .
								Service_Breadcrumb::getPageBreadCrumbCity($zip['city_name'], 
																		$state_name, 
																		$zip['zip_code'], TRUE) .
								'</li>';										

			
			// $n++;
			// if ($n > $column_count)
			// {
			// 	$n = 0;
			// 	$set++;
			// 	$state_list .= '</ul></div><div id="state-list"><ul>';
			// }
		}
		
		$state_list .= '</ul></div>';
		return $state_list;
	}
	
	
	/*
	 *	buildStateHtml
	 *
	 *	@todo cache the html results for the view
	 * @todo add title to url
	 */
	static public function buildStateHtml()
	{
		$results = Factory_State::getStates();
		$state_list = '';
		$results_count = count($results);
		$set = 0;	// 
		$n = 0;
		$column_count = ($results_count / 3) - 1;
		
		// echo '<p>results_count [' . $results_count . ']</p>';
		// echo '<p>column_count [' . $column_count . ']</p>';
		
		$state_list .= '<div id="state-list"><ul>';
					
		foreach($results as $state)
		{
			$state_list .= '<li><a href="' . url::base() . $state['value'] . 
							'">' . $state['name'] . '</a></li>';
			
		    // $a_state_list[$set][$state['id']]['state_name'] = $state['state_name'];
		    // $a_state_list[$set][$state['id']]['state_url'] = url::base() . $state['state_url'];
			
			$n++;
			if ($n > $column_count)
			{
				$n = 0;
				$set++;
				$state_list .= '</ul></div><div id="state-list"><ul>';
			}
		}

		// $state_list = '<ul>' . $state_list . '</ul>';
		return $state_list;
	}
	
	/*
	 *	buildTableOfContentsHtml
	 *
	 *	@todo cache the html results for the view
	 */
	static public function buildTableOfContentsHtml($state)
	{
		$results = Factory_State::getCityList($state);
		
		$a_city_list = array();
		$a_city_first_letter = array();
		
		$html_city_first_letter = '';
		$html_city_first_letter  .= '<div id="state-results-tableofcontents"><div id="select-location">Select Location</div><ul>';
		
		foreach($results as $city)
		{
			$a_city_list[$city['zip_code']]['name'] = $city['city_name'];
			$a_city_list[$city['zip_code']]['first_letter'] = substr($city['city_name'],0,1);
			
			$a_city_first_letter[substr($city['city_name'],0,1)] = $city['city_name'];			
		}


		foreach($a_city_first_letter as $letter => $name)
		{
			$html_city_first_letter .= '<li><a href="' . 
			 							'#' . $name .
										'" title="link to cities beginning with the letter ' . strtoupper($letter) . '. ">' . $letter . '</a></li>';
			
		}
		$html_city_first_letter .= '</ul></div><div id="state-results-tableofcontents"><ul>';

		return $html_city_first_letter;
	}
	
} // End