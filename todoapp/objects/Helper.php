<?php 

class Helper
{
	public static function htmlout($param)
	{
		echo htmlspecialchars($param, ENT_QUOTES, 'UTF-8');
	}

	public static function notification($var)
	{
        echo $var;     
	}

	public static function dateFormat($date)
	{
		$newDate = date_create($date);
		echo date_format($newDate,"Y/m/d");
	}

	public static function getVisits()
	{
		if (!isset($_COOKIE['visits'])){
		 $_COOKIE['visits'] = 0;
		}
		$visits = $_COOKIE['visits'] + 1;
		setcookie('visits', $visits, time() + 3600 * 24 * 365);
		return $visits;
	}

	static function redirect()
	{
		if (!isset($_SESSION['user'])){
			header("Location:http://" . $_SERVER['HTTP_HOST'] .  "/todoapp/login");
		}
		
	}

	public static function checkRoute()
	{
		if (!in_array($_GET['url'], Route::$validRoutes)){
		   include $_SERVER['DOCUMENT_ROOT'] . "/todoapp/include/404.php";
		}
	}

	public static function logout()
	{
		session_start();
		session_destroy();

		header("Location: http://" . $_SERVER['HTTP_HOST'] . "/todoapp/login");
	}
}