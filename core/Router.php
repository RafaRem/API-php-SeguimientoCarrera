<?php

/**
* Router
*/
class Router
{
	private static $routes = [];

	// private function __construct(argument) {}

	public static function get($route='index', $controller, $method)
	{
		static::$routes[$route] = ['controller' => $controller, 'method' => $method];
	}


	public static function getAction($route='index')
	{
		if (array_key_exists($route, static::$routes)):
			return static::$routes[$route];
		else:
			throw new Exception("Ruta ($route) no encontrada.");
		endif;
	}
}