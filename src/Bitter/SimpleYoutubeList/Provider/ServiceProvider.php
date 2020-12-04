<?php

/**
 * @project:   Simple Youtube List
 *
 * @author     Fabian Bitter (fabian@bitter.de)
 * @copyright  (C) 2020 Fabian Bitter (www.bitter.de)
 * @version    X.X.X
 */

namespace Bitter\SimpleYoutubeList\Provider;

use Bitter\SimpleYoutubeList\RouteList;
use Concrete\Core\Entity\Package;
use Concrete\Core\Foundation\Service\Provider;
use Concrete\Core\Http\Response;
use Concrete\Core\Http\ResponseFactory;
use Concrete\Core\Package\PackageService;
use Concrete\Core\Routing\Router;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Support\Facade\Route;
use Concrete\Package\SimpleYoutubeList\Controller;

class ServiceProvider extends Provider
{

    public function register()
    {
        $this->initializeRoutes();
        $this->initializeServiceRoutes();
    }

    private function initializeRoutes()
    {
        /** @var Router $router */
        $router = $this->app->make("router");
        $list = new RouteList();
        $list->loadRoutes($router);
    }

    private function initializeServiceRoutes()
    {
        /** @var PackageService $packageService */
        $packageService = $this->app->make(PackageService::class);
        /** @var Package $packageEntity */
        $packageEntity = $packageService->getByHandle("simple_youtube_list");
        /** @var Controller $package */
        $package = $packageEntity->getController();

        /** @noinspection PhpUndefinedMethodInspection */
        Route::register("/bitter/" . $packageEntity->getPackageHandle() . "/hide_did_you_know", function () use ($package) {
            $package->getConfig()->save('did_you_know.hide', true);
            $app = Application::getFacadeApplication();
            /** @var $responseFactory ResponseFactory */
            $responseFactory = $app->make(ResponseFactory::class);
            $responseFactory->create("", Response::HTTP_OK)->send();
            $app->shutdown();
        });
    }
}