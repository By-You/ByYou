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
        /*$router[] = new Route('admin/<module (?!Front)[^/]+>/<presenter>/<action>', array(
            'module' => 'Front',
            'presenter' => 'Homepage', 'Product', 'About', 'Kontakt',
            'action' => 'default',*/
        $member = new RouteList('Admin');
        $member[] = new Route('admin/<presenter>/<action>', 'Homepage:default');
        $router[] = $member;

        $public = new RouteList('Front');
        $public[] = new Route('<presenter>/<action>', 'Homepage:default');
        $router[] = $public;

		return $router;
	}

}
