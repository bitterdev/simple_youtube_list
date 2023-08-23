<?php

/**
 * @project:   Simple Youtube List
 *
 * @author     Fabian Bitter (fabian@bitter.de)
 * @copyright  (C) 2020 Fabian Bitter (www.bitter.de)
 * @version    X.X.X
 */

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Form\Service\Form;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\View\View;

/** @var int $maxResults */
/** @var string $channelId */
/** @var string $apiKey */

$app = Application::getFacadeApplication();
/** @var Form $form */
$form = $app->make(Form::class);

?>

    <div class="form-group">
        <?php echo $form->label("apiKey", t('API Key')); ?>
        <?php echo $form->text("apiKey", $apiKey, ["max-length" => 64]); ?>

        <div class="help-block">
            <?php echo t(
                "Learn more about how to %s.",
                sprintf(
                    "<a href=\"https://developers.google.com/places/web-service/get-api-key\" target=\"_blank\">%s</a>",
                    t("get an API Key")
                )
            ); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->label("channelId", t('Channel Id')); ?>

        <div class="input-group">
            <div class="input-group-text">
                <?php echo t("https://www.youtube.com/channel/"); ?>
            </div>

            <?php echo $form->text("channelId", $channelId, ["max-length" => 24]); ?>
        </div>

        <div class="help-block">
            <?php echo t(
                "Learn more about how to %s.",
                sprintf(
                    "<a href=\"https://support.google.com/youtube/answer/3250431\" target=\"_blank\">%s</a>",
                    t("get the Channel Id")
                )
            ); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->label("maxResults", t('Max Results per page')); ?>
        <?php echo $form->number("maxResults", $maxResults, ["min" => 1, "max" => 50, "step" => 1]); ?>
    </div>
