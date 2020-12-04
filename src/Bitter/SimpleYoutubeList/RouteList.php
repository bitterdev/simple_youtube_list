<?php

/**
 * @project:   Simple Youtube List
 *
 * @author     Fabian Bitter (fabian@bitter.de)
 * @copyright  (C) 2020 Fabian Bitter (www.bitter.de)
 * @version    X.X.X
 */

namespace Bitter\SimpleYoutubeList;

use Concrete\Core\Routing\RouteListInterface;
use Concrete\Core\Routing\Router;

class RouteList implements RouteListInterface
{
    public function loadRoutes(Router $router)
    {
        $router
            ->buildGroup()
            ->setNamespace('Concrete\Package\SimpleYoutubeList\Controller\Dialog\Support')
            ->setPrefix('/ccm/system/dialogs/simple_youtube_list')
            ->routes('dialogs/support.php', 'simple_youtube_list');
    }
}