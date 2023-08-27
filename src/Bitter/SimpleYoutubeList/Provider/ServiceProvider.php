<?php

/**
 * Project: Email Signature
 *
 * @copyright 2019 Fabian Bitter
 * @author Fabian Bitter (fabian@bitter.de)
 * @version X.X.X
 */

namespace Bitter\SimpleYoutubeList\Provider;

use Bitter\SimpleYoutubeList\RouteList;
use Concrete\Core\Foundation\Service\Provider;
use Concrete\Core\Routing\Router;

class ServiceProvider extends Provider
{
    public function register()
    {
        $this->initializeRoutes();
    }

    private function initializeRoutes()
    {
        /** @var Router $router */
        $router = $this->app->make("router");
        $list = new RouteList();
        $list->loadRoutes($router);
    }
}