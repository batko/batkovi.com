<?php

namespace App;

use Nette,
    Nette\Application\Routers\RouteList,
    Nette\Application\Routers\Route,
    Nette\Application\Routers\SimpleRouter;

/**
 * Router factory.
 */
class RouterFactory {

    /**
     * @return \Nette\Application\IRouter
     */
    public static function createRouter() {
        $router = new RouteList();
//        $router[] = new Route('<action>[/<id>]', [
//            "presenter" => "Homepage",
//            "action" => "default"
//                ]);
 
        $router[] = new Route('<action>[/<id>]', array(
            "presenter" => "Homepage",
            "action" => "default"
                ));
        return $router;
    }

}
