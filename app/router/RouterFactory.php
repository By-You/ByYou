<?php

namespace App;
//namespace

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
        $router[] = new Route('<presenter>/<action>', array(
            'module' => 'Front',
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => NULL,
        ));
		return $router;
	}

}
