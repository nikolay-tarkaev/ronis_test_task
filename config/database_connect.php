<?php
	
	ActiveRecord\Config::initialize(function($cfg)
	{
		$database    = 'mysql';
		$db_name     = 'ronis_test_task_tarkaev';
		$db_host     = 'localhost';
		$db_user     = 'root';
		$db_password = '';
		
		$cfg->set_model_directory('../application/models');
		$cfg->set_connections(array(
			'development' => $database . '://' . $db_user . ':' . $db_password . '@' . $db_host . '/' . $db_name)); // 'mysql://username:password@hostname/databasename'
	});