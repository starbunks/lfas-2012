<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dev_Zipfile extends Controller {

	private $curl_info = '';
	
	/**
	*	action_index
	*
	**/
    public function action_index()
    {   
		// set_time_limit(30000);
		
		$mtime = microtime(); 
		$mtime = explode(' ', $mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$starttime = $mtime;
	
		$insert = 'INSERT INTO `ziptest` (`zip_code`, `city`, `state`, `county`, `area_code`, `city_type`, `city_alias_abbrev`, `city_alias_name`,`latitude`, `longitude`, `time_zone`, `elevation`, `county_fips`, `day_light_savings`, `preferred_last_line_key`, `classification_code`, `multi_county`, `state_fips`, `city_state_key`, `city_alias_code`, `primary_record`, `city_mixed_case`, `city_alias_mixed_case`, `state_ansi`, `county_ansi`, `facility_code`, `city_delivery_indicator`, `carrier_route_rate_sortation`, `finance_number`, `unique_zip_name`) VALUES 
		';
		
		// $handle = @fopen("zip-codes-database-STANDARD.csv", "r");

		// $file = '/Library/WebServer/Documents/lfascom/public_html/us/application/classes/controller/dev/ziptest.txt';
		$file = '/Library/WebServer/Documents/lfascom/public_html/us/application/classes/controller/dev/zip-codes-database-STANDARD.csv';
		$row = 0;
		$insert_data = '';
		$end_variable = '';		
		
		if (($handle = fopen($file, "r")) !== FALSE) 
		{
			$total_rows = count(file($file)) - 1;
			
			echo '<p>count rows ' . $total_rows . '</p>';
			
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
			{
				if ($row != 0)
				{
			        $num = count($data);
			        // echo "<p> $num fields in line $row: <br /></p>\n";
			        
					$insert_data .= ' (';
				
			        for ($c=0; $c < $num; $c++) 
					{
			            // echo $c . ') ' . $data[$c] . "<br />\n";
		
						if ($c==($num-1))
						{
							$end_variable = '';
						}
						else
						{
							$end_variable = ', ';						
						}
		        
						if ($c==8 || $c == 9)
						{
							$insert_data .= $data[$c] . $end_variable;
						}
						else
						{
							$insert_data .= '"' . $data[$c] . '"' . $end_variable;
						}
			        }
					
					if ( $row < $total_rows )
					{
						$insert_data .= '), ';
					}
					else
					{
						$insert_data .= '';
					}
				}
				$row++;
		    }
		    fclose($handle);
		}
		
		$write_data = $insert . $insert_data . ');';
		
		// echo '<p>' . $write_data . '</p>';
        
		$write_handle = fopen('/Library/WebServer/Documents/lfascom/public_html/us/application/classes/controller/dev/out.sql', "w+");
		
		if (!fwrite($write_handle, $write_data)) 
		{
			echo '<p>hey what...done. false<br /><br />';
		} 
		else 
		{
			echo '<p>hey what...done. true<br /><br />';
        }
			


			$mtime = microtime(); 
		  	$mtime = explode(" ", $mtime); 
			$mtime = $mtime[1] + $mtime[0]; 
			$endtime = $mtime; 
		  	$totaltime = ($endtime - $starttime); 

		  	echo 'This page was created in ' .round($totaltime, 4) . ' seconds.</p>';
    }




} // End Zipfile
