<?php
$environment = "development"; // development, production, demo

switch($environment) {
	case "development":
		define("HOST", "10.100.9.44");
		define("PORT", "3306");
		define("DB_USER", "navin");
		define("DB_PASSWORD", "navin21594");
		define("DATABASE", "alert_system");
		define("DB_TYPE", "mysql"); // mysql, postgres
		define("BASE_FOLDER", "alert");
		break;
	case "production":
		define("HOST", "localhost");
		define("PORT", "3306");
		define("DB_USER", "navin");
		define("DB_PASSWORD", "navin21594");
		define("DATABASE", "alert_system");
		define("DB_TYPE", "mysql"); // mysql, postgres
		define("BASE_FOLDER", "alert");
		break;
	case "demo":
		define("HOST", "localhost");
		define("PORT", "3306");
		define("DB_USER", "navin");
		define("DB_PASSWORD", "navin21594");
		define("DATABASE", "alert_system");
		define("DB_TYPE", "mysql"); // mysql, postgres
		define("BASE_FOLDER", "alert");
		break;
}

define("PROTOCOL", "http://");
define("CURRENT_DATE", date('Y-m-d'));
define("CURRENT_DATE_TIME", date('Y-m-d H:i:s'));

// >>>> FOR MOBILE APPLICATION
$salt = "PVR-TechStudio";
$key = "SOSMobileApplication";
$hashed = md5($salt.$key); //>>>> 1013162e8367be25042d930e24190a4b
define("APIKEY", $hashed);

// INSERT INTO `roles` (`id`, `role_name`, `role_desc`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES ('1', 'Admin', 'Having full rights over the project', '1', CURRENT_TIMESTAMP, NULL, NULL);

// INSERT INTO `users` (`id`, `display_name`, `username`, `password`, `mobile`, `email`, `door_no`, `address`, `role_id`, `all_alert_receiver`, `authendicated`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES ('1', 'Admin', 'admin', 'admin@123', NULL, NULL, '', NULL, NULL, '0', '0', 'active', '1', CURRENT_TIMESTAMP, NULL, NULL);
?>