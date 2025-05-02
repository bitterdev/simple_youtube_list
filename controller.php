<?php

/**
 * @project:   Simple Youtube List
 *
 * @author     Fabian Bitter (fabian@bitter.de)
 * @copyright  (C) 2020 Fabian Bitter (www.bitter.de)
 * @version    X.X.X
 */

namespace Concrete\Package\SimpleYoutubeList;

use Bitter\SimpleYoutubeList\Provider\ServiceProvider;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected $pkgHandle = 'simple_youtube_list';
    protected $pkgVersion = '1.6.2';
    protected $appVersionRequired = '9.0.0';
    protected $pkgAutoloaderRegistries = [
        'src/Bitter/SimpleYoutubeList' => 'Bitter\SimpleYoutubeList',
    ];

    public function getPackageDescription()
    {
        return t('Contains a block type to display all videos from a YouTube-channel.');
    }

    public function getPackageName()
    {
        return t('Simple Youtube List');
    }

    public function on_start()
    {
        /** @var $serviceProvider ServiceProvider */
        $serviceProvider = $this->app->make(ServiceProvider::class);
        $serviceProvider->register();
    }

    public function install()
    {
        parent::install();
        $this->installContentFile('install.xml');
    }

}