<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sitemap {

	private static $sitemap;
	
	/**
	* factory
	*
	**/
	public static function factory()
	{
		if (self::$sitemap == NULL)
		{
			self::$sitemap = new Model_Sitemap;
		}

		return self::$sitemap;
	}


	/**
	*	buildMap
	*
	**/
	public function buildCityMap($state)
	{
		$results = Factory_State::getCityList($state);
		$node = '';
		$app_url = Service_Pageutility::getApplicationUrl();
		
		foreach($results as $city)
		{
			$node .= $this->buildUrl($app_url . $city['state_name'] . '/' . $city['city_name'] . '/' . $city['zip_code']);
		}		
		
		$node = $this->buildMapHeader() . $node . $this->buildMapFooter();
		$this->buildSitemapFile($node, $state);
		return 'done ' . $state;
	}


	/**
	*	buildMap
	*
	**/
	public function buildStateMap()
	{
		$state = 'us';
		
		$results = Factory_State::getStates();
		
		
		$node = '';
		$app_url = Service_Pageutility::getApplicationUrl();
		
		foreach($results as $column)
		{
			$node .= $this->buildUrl($app_url . $column['value']);
		}
		
		$node = $this->buildMapHeader() . $node . $this->buildMapFooter();
		$this->buildSitemapFile($node, $state);
		return 'done ' . $state;		
	}
	
	/**
	*
	*
	*
	**/
	public function buildSitemapFile($node, $file_name_postfix)
	{
		// $file_name = '/Library/WebServer/Documents/lfascom/public_html/sitemap-' . $file_name_postfix . '.xml';
		$file_name = $_SERVER['DOCUMENT_ROOT'] .'/sitemap-' . $file_name_postfix . '.xml';
		
		$handle = fopen($file_name, "w");
		fwrite($handle, $node);
	  	fclose($handle);
		return;
	}


	public function buildUrl($loc, $lastmod='', $changefreq='monthly', $priority='0.2')
	{
		if($lastmod=='')
		{
			$lastmod = date('Y-m-d') . 'T' . date('H:i:s') . '+00:00';
		}
		
		$xml = '
				<url>
				
				' .
				'<loc>' . $loc . '</loc>
				' .
				'<lastmod>' . $lastmod . '</lastmod>
				' .
				'<changefreq>' . $changefreq . '</changefreq>
				' .
				'<priority>' . $priority . '</priority>
				' . '
				</url>';
		
		return $xml;
	}
	
	
	public function buildMapHeader()
	{		
		$html = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="' .Service_Pageutility::getSiteUrl() . 
				'wp-content/plugins/google-sitemap-generator/sitemap.xsl"?>' . 
		'<!-- generated-on="' . date('F,j Y g:i a') . '" -->' . 
		'
		<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		';
		return $html;
	}
	
	public function buildMapFooter()
	{
		$html = '</urlset>';
		return $html;		
	}
	
}	// End Factory_Sitemap