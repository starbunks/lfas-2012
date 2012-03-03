<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sitemap extends Controller {

	
    public function action_index()
    {
		$type = $this->request->param('type');
		echo $type;
		echo Model_Sitemap::factory()->buildMap();
    }


	/**
	*	action_state - list of state
	*		sitemap/state
	*
	**/
    public function action_state()
    {
		echo Model_Sitemap::factory()->buildStateMap();
    }


	/**
	*	action_city - list of state
	*		sitemap/city(/<state>)
	*	Generates one state at a time?
	* 	@todo need something to call this 50 times!
	**/
    public function action_city()
    {
		$state = $this->request->param('state');
		echo Model_Sitemap::factory()->buildCityMap($state);
    }



} // End Controller_Sitemap
