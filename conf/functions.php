<?php
	use Module\Router\Router;

	function path($routeName, $params=null)
	{
		$router = new Router();
		echo $router->routeHandler($routeName, $params);
	}

	function isGranted(array $role) {
		return $user->hasRole($role);
	}
 ?>