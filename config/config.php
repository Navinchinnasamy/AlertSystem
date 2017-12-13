<?php
$environment = "development"; // development, production, demo

switch($environment) {
	case "development":
		define("HOST", "localhost");
		//define("PORT", "3036");
		define("DB_USER", "navin");
		define("DB_PASSWORD", "navin21594");
		define("DATABASE", "alert_system");
		define("DB_TYPE", "mysql"); // mysql, postgres
		break;
	case "production":
		define("HOST", "localhost");
		//define("PORT", "3036");
		define("DB_USER", "navin");
		define("DB_PASSWORD", "navin21594");
		define("DATABASE", "alert_system");
		//define("DB_TYPE", "mysql"); // mysql, postgres
		break;
	case "demo":
		define("HOST", "localhost");
		//define("PORT", "3036");
		define("DB_USER", "navin");
		define("DB_PASSWORD", "navin21594");
		define("DATABASE", "alert_system");
		//define("DB_TYPE", "mysql"); // mysql, postgres
		break;
}
?>