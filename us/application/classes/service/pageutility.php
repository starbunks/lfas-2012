<?php defined('SYSPATH') or die('No direct script access.');

class Service_Pageutility {

	/**
	* getSiteUrl() - used for absolute path for css, js and theme images
	*
	*
	**/
	public static function getSiteUrl()
	{
		//postfix is needed b/c WP only stores the http....to.....com
		$siteurl = Factory_Utility::getSiteUrl() . '/';
		// echo '<br /> siteurl ['.$siteurl.']';
		return $siteurl;
	}


	/**
	* 
	* getApplicationUrl() - This is the absolute path to the kohana application
	*
	**/
	public static function getApplicationUrl()
	{
		return self::getSiteUrl() . 'us/';
	}
	

	/**
	* 
	* getTageline() - 
	*
	* @param $city_name='', $state_name=''
	*
	**/
	public static function getTageline($city_name='', $state_name='', $zip_code='')
	{
		$pre_tagline = "Helping Parents Find Child Care";
		$in = ' in ';
		
		if ($city_name == '' && $state_name == '')
		{
			$tagline = $pre_tagline;
		}
		elseif ($city_name == '')
		{
			$tagline = $pre_tagline . $in . ucfirst($state_name);
		}
		else
		{
			$tagline = $pre_tagline . $in . ucfirst($city_name) . ', ' . ucfirst($state_name) . '  ' . $zip_code;
		}
		
		return $tagline;
		
	}


	/**
	* 
	* getSitterCount() - 
	*
	* @param $dom, $city_name, $state_name, $zip_code
	*
	**/
	public static function getSitterCount($dom, $city_name, $state_name, $zip_code)
	{
		//41,350 Babysitters Found in 60645
		
		$total_results = number_format(intval($dom->TotalResults));
		$copy = ' Found';
		return $total_results . $copy;
	}


	/**
	* 
	* getSitterPageTitle() - 
	*
	* @param $city_name, $state_name, $zip_code
	*
	**/
	public static function getSitterPageTitle($city_name, $state_name, $zip_code)
	{
		//Babysitters in <city> <state> <zip>
		$copy = ' Babysitters in ';
		$location = ucfirst($city_name) . ', ' . ucfirst($state_name) . ' ' . $zip_code;

		return $copy . $location;
	}
	

	/**
	*	getZipSearchForm - used by the header
	*
	*	@return zipcode search box in html
	*/
	public static function getZipSearchForm() 
	{
		$html_form = '<form method="get" id="searchform" action="' . self::getApplicationUrl() . 'search">'  .
			'<label for="zip" class="">Find babysitters, nannies near you</label>
			<input type="text" class="field" name="zip" id="zip" placeholder="in your ZIP code" />
			<input type="submit" class="submit" name="submit" id="searchsubmitzip" value="Search" />
		</form>';

		return $html_form;
	}
	
	
}
?>