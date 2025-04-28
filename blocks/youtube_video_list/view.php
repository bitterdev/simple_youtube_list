<?php

/**
 * @project:   Simple Youtube List
 *
 * @author     Fabian Bitter (fabian@bitter.de)
 * @copyright  (C) 2020 Fabian Bitter (www.bitter.de)
 * @version    X.X.X
 */

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Page\Page;
use Concrete\Core\Support\Facade\Url;
use Concrete\Package\SimpleYoutubeList\Block\YoutubeVideoList\Controller;

/** @var int $maxResults */
/** @var string $channelId */
/** @var string $apiKey */
/** @var Controller $controller */
/** @var array $results */

?>

<div class="youtube-video-list">
    <?php
    if (!is_array($results) || count($results) === 0) { ?>
        <p class="no-results">
            <?php echo t("No videos found."); ?>
        </p>
    <?php } else { ?>
        <div class="row">
            <?php foreach ($results["items"] as $resultItem) { ?>
                <?php
                $snippet = $resultItem["snippet"];
                $thumbnails = $snippet["thumbnails"];
                $videoId = $resultItem["id"]["videoId"];
                ?>
                <?php if ($videoId !== null) { ?>
                    <div class="col-xs-12 col-md-6 col-lg-4">
                        <div class="youtube-video-entry">
                            <a href="<?php echo (string)Url::to("https://www.youtube.com/watch")->setQuery(["v" => $videoId]); ?>"
                               target="_blank" title="<?php echo h($snippet["title"]); ?>" class="thumbnail">
                                <picture>
                                    <source media="(min-width:<?php echo h($thumbnails["high"]["width"]); ?>px)"
                                            srcset="<?php echo h($thumbnails["high"]["url"]); ?>">
                                    <source media="(min-width:<?php echo h($thumbnails["medium"]["width"]); ?>px)"
                                            srcset="<?php echo h($thumbnails["medium"]["url"]); ?>">
                                    <img src="<?php echo $thumbnails["medium"]["url"]; ?>"
                                         alt="<?php echo h($snippet["title"]); ?>" class="img-fluid">
                                </picture>
                            </a>

                            <a href="<?php echo (string)Url::to("https://www.youtube.com/watch")->setQuery(["v" => $videoId]); ?>"
                               target="_blank" class="title">
                                <?php echo $snippet["title"]; ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <?php if (isset($results["prevPageToken"]) || $results["nextPageToken"]) { ?>
            <div class="text-center">
                <ul class="pagination">
                    <?php if (isset($results["prevPageToken"])) { ?>
                        <li>
                            <a href="<?php echo h((string)Url::to(Page::getCurrentPage(), "display_page", $results["prevPageToken"])); ?>">
                                <?php echo t("Back"); ?>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="disabled">
                            <a href="javascript:void(0);" class="disabled">
                                <?php echo t("Back"); ?>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if (isset($results["nextPageToken"])) { ?>
                        <li>
                            <a href="<?php echo h((string)Url::to(Page::getCurrentPage(), "display_page", $results["nextPageToken"])); ?>">
                                <?php echo t("Next"); ?>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="disabled">
                            <a href="javascript:void(0);" class="disabled">
                                <?php echo t("Next"); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    <?php } ?>
</div>