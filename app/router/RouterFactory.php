<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList();

        $member = new RouteList('Admin');
        $member[] = new Route('admin/<presenter>/<action>', 'Homepage:default');
        $router[] = $member;

        $public = new RouteList('Front');
        $public[] = new Route('<presenter>/<action>', 'Homepage:default');
        $router[] = $public;

		return $router;
	}

}
