<?php
	class db {
		private static $instance = NULL;
		
		private function __construct() {
		
		}
		
		public static function getInstance() {
			if (!self::$instance) {
				self::$instance = new PDO("mysql:host=localhost;dbname=forum", 'root', '1234');
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
			}
			
			return self::$instance;
		}
		
		private function __clone() {
			
		}
	}