<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dev_Park extends Controller {

	private $curl_info = '';
	
	/**
	*	action_index
	*
	**/
    public function action_index()
    {   
	
		echo 'hey';
		exit();

		// get url param
		// $state_name = $this->request->param('state');

		// Pagelayout overrides
		// $this->page_name = 'Controller_State.city';
		
		// query string parameters
		// $a_qs = Kohana_Request::current()->query();

			$v = View::factory('default');
		
			// Page specific
			$v->body = 'body stuff';
			$v->page_h1 = 'title';
			
			// instance of sub views
			$v->header = View::factory('header');
			$v->footer = View::factory('footer');
					
			$this->response->body($v);
    }

	public function action_settable()
	{		
		$url = 'http://www.kidsplayparks.com/Location.aspx?LocationID=';
		$i=100;
		// while($i<=300000)
		while($i<=1000)
		{	
			$i = $i + 50;
			$u = $url . $i;
			Factory_Park::insertParkRoll($i,$u);
			
		}
		echo 'done';
	}
	
	public function action_farmer()
	{		
		// set_time_limit(30000);
		
		$mtime = microtime(); 
		$mtime = explode(' ', $mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$starttime = $mtime;
		
		
		$url = 'http://www.kidsplayparks.com/Location.aspx?LocationID=';
		
		$results = Factory_Park::getParkRoll();
		$curl_results = '';
		
		foreach($results as $park_roll)
		{
			print_r($park_roll);
			
			
			echo '<p>before [ '.$this->curl_info.']</p>';

			// $curl_results = $this->getCurl($park_roll['url'].$park_roll['number']);
			// $a_curl_info = $this->curl_info;
			
			// $curl_results = "<html><body><h1>bunk</h1></body></html";
			$curl_results = "bunk";
			$a_curl_info = Array
			( 	'id' => 2,
			    'number' => 300,
			    'url' => 'http://www.kidsplayparks.com/Location.aspx?LocationID=100',
			    'found' => 0,
			    'curl_info' => '',
			    'curl_html' => '',
				'http_code' => 'bunk'
			);
			
			$update_result = Factory_Park::updateParkRoll($park_roll['number'], 
															$a_curl_info['http_code'], 
															'$a_curl_info', 
															$curl_results );
			echo '<p>after [ '.$this->curl_info['http_code'].']</p>';

			
			// $a_city_list[$city['zip_code']]['name'] = $city['city_name'];
			// 			$a_city_list[$city['zip_code']]['first_letter'] = substr($city['city_name'],0,1);
			// 			
			// 			$a_city_first_letter[substr($city['city_name'],0,1)] = $city['city_name'];			
		}


		/**
		*
		*	curl stuff
		*
		**/
		// echo '<p>before [ '.$this->curl_info.']</p>';
		// $curl_results = $this->getCurl($url.'53453');
		// $a_curl_info = $this->curl_info;
		// $results = Factory_Park::updateParkRoll(53453, $a_curl_info['http_code'], $a_curl_info, $curl_results );
		// echo '<p>after [ '.$this->curl_info['http_code'].']</p>';


		
		echo '<p>hey what...done<br /><br />';

		$mtime = microtime(); 
	  	$mtime = explode(" ", $mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$endtime = $mtime; 
	  	$totaltime = ($endtime - $starttime); 

	  echo 'This page was created in ' .round($totaltime, 4) . ' seconds.</p>'; 
		
	}
	
	public function getCurl($curl_url) 
	{
		// $this->curl_info = 'bunk';
		// return;
		libxml_use_internal_errors(true);
		
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
		curl_setopt($ch, CURLOPT_HEADER, 0);

		// grab URL and pass it to the browser
		curl_exec($ch);
		$server_output = curl_exec($ch);

		// set the header response
		$this->curl_info = curl_getinfo($ch);
		
		// close cURL resource, and free up system resources
		curl_close($ch);

		return $server_output;
	}


/**
*
*	Example of curl_getinfo() 
*
**/
/*
Array
(
    [url] => http://www.kidsplayparks.com/Location.aspx?LocationID=54333
    [content_type] => text/html; charset=utf-8
    [http_code] => 200
    [header_size] => 296
    [request_size] => 90
    [filetime] => -1
    [ssl_verify_result] => 0
    [redirect_count] => 0
    [total_time] => 0.121026
    [namelookup_time] => 2.5E-5
    [connect_time] => 2.5E-5
    [pretransfer_time] => 2.6E-5
    [size_upload] => 0
    [size_download] => 36290
    [speed_download] => 299852
    [speed_upload] => 0
    [download_content_length] => 36290
    [upload_content_length] => 0
    [starttransfer_time] => 0.114387
    [redirect_time] => 0
    [certinfo] => Array
        (
        )

)
*/


} // End State
