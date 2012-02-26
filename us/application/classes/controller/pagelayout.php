<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pagelayout extends Controller {

   
	/*
	 *
	 */
    public function before()
    {
        parent::before();


        View::bind_global('page_name', $this->page_name);
        View::bind_global('tagline', $this->tagline);
        View::bind_global('header', $this->header);
        View::bind_global('header_menu', $this->header_menu);


        View::bind_global('footer_header', $this->footer_header);
        View::bind_global('footer_city_list', $this->footer_city_list);
        View::bind_global('footer_last_list', $this->footer_last_list);


		// set footer
		$this->footer_header = 'Find Caregivers in Your City';
		$this->footer_city_list = Model_Pagelayout::buildFooterCityHtml();
		$this->footer_last_list = Model_Pagelayout::buildFooterLastHtml();
		
		// set header
		$this->header = 'something';
		$this->header_menu = Model_Pagelayout::buildHeaderMenuHtml();
		$this->tagline = 'I know beans';
	}

} // End Controller_Pagelayout
