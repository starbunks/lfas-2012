<?php
return array
  (
  	'default' => array
  	(
  		'type'       => 'mysql',
  		'connection' => array(
  			'hostname'   => '127.0.0.1',
  			'username'   => 'root',
  			'password'   => 'password1',
  			'persistent' => FALSE,
  			'database'   => 'lfas',
  		),
  		'table_prefix' => '',
  		'charset'      => 'utf8',
  		'caching'      => FALSE,
  		'profiling'    => TRUE,
  	),
  );
?>