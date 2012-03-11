<?php defined('SYSPATH') or die('No direct script access.');

class Controller_State extends Controller_Pagelayout {

	
	/**
	*	action_index
	*
	**/
    public function action_index()
    {    
		$state_name = $this->request->param('state');

	
		
		$found_state_name = Factory_State::isState($state_name);
		if ($found_state_name)
		{

			// Pagelayout overrides
			$this->page_name = 'Controller_State.index';
			$this->tagline = Service_Pageutility::getTageline('', $found_state_name);

			$v = View::factory('state');
		
			// Page specific
			$v->body = Model_Pagelayout::buildCityHtml($found_state_name);
			$v->page_h1 = Service_Breadcrumb::getPageBreadCrumbState($found_state_name);
			$v->page_breadcrumb = Service_Breadcrumb::buildState($found_state_name);
			$v->table_of_contents = Model_Pagelayout::buildTableOfContentsHtml($state_name);			
			
			// instance of sub views
			$v->header = View::factory('header');
			$v->footer = View::factory('footer');
					
			$this->response->body($v);
		
		}
		else
		{
			Request::current()->redirect(Service_Pageutility::getApplicationUrl());
		}
		
    }

	
	/**
	*	action_city
	*	
	*	URL: /us/state
	*	@param state_name
	*   @return list of cities for the given state
	*
	*/
	public function action_city()
	{
		$page_number = 1;

		// URI from bootstrap
		$city_name = $this->request->param('city');
		$state_name = $this->request->param('state');
		$zip_code = $this->request->param('zip');
					
		if (Factory_Zip::isZip($zip_code))
		{
			// Pagelayout overrides
			$this->page_name = 'Controller_State.city';
			$found_state_name = $state_name;
			$this->tagline = Service_Pageutility::getTageline($city_name, $found_state_name, $zip_code);
			
			// query string parameters
			$a_qs = Kohana_Request::current()->query();

			// add the zip_code to the query string
			$a_qs['z'] = $zip_code;

			// set the page number
			if (array_key_exists("p", $a_qs))
			{
				$page_number = $a_qs['p'];
			}
						
			// set location
			$a_location['city'] = $city_name;
			$a_location['state'] = $state_name;
			$a_location['zip'] = $zip_code;

			Factory_Sittercity::factory()->setLocation($a_location);
			
			// validate the query string
			$a_valid_qs = Factory_Sittercity::factory()->validateQueryString($a_qs);
			
			// build the curl url
			$valid_url = Factory_Sittercity::factory()->getBuildUrl($a_valid_qs, 5);

			// use factory pattern
			$curl = new Factory_Curl();
			$curl->setCurlUrl($valid_url);
			$xml = $curl->getCurlData();

			// Sitter Data
			$html_sitter_data = Factory_Sittercity::factory()->getHtml($xml);

			// Pagination
			$sitter_count = $xml->TotalResults;
			$html_pagination = Factory_Sittercity::factory()->getPaginationList($a_location, $a_valid_qs, $page_number, $sitter_count);
			
			//Search facets
			// $html_facet = Factory_Sittercity::factory()->buildSearchOptionsFacets($a_location, $a_valid_qs);
			
			//View
			$v = View::factory('sitter_results');

			$v->page_count = Service_Pageutility::getSitterCount($xml, $city_name, $state_name, $zip_code);
			$v->page_h1 = Service_Pageutility::getSitterPageTitle($city_name, $state_name, $zip_code);
			$v->page_breadcrumb = Service_Breadcrumb::build($city_name, $state_name, $zip_code);
			
			// $v->html_facet_on = $html_facet['on'];
			// $v->html_facet_off = $html_facet['off'];
			
			$v->state_list = $html_sitter_data;
			$v->pagination = $html_pagination;
			
			$v->header = View::factory('header');
			$v->footer = View::factory('footer');
				
			$this->response->body($v);
		}
		else
		{
			Request::current()->redirect(Service_Pageutility::getApplicationUrl() . $state_name);
		}
	}



	/**
	*	action_list
	*	
	*	URL: /us/
	*   @return list of states
	*
	*/
	public function action_list()
	{			
		// Pagelayout overrides
		$this->page_name = 'Controller_State.list';
		$this->tagline = Service_Pageutility::getTageline();
		
		$v = View::factory('state');
				
		// Page specific
		$v->body = Model_Pagelayout::buildStateHtml();
		$v->page_h1 = 'Babysitters Across the U.S.';
		$v->page_breadcrumb = Service_Breadcrumb::getHomePageLink() . ' &gt ' . Service_Breadcrumb::getPageBreadCrumbUs();
		
		// instance of sub views
		$v->header = View::factory('header');
		$v->footer = View::factory('footer');
				
		$this->response->body($v);
	}

} // End State
