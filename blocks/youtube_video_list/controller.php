<?php
/**
 * @project:   Simple Youtube List
 *
 * @author     Fabian Bitter (fabian@bitter.de)
 * @copyright  (C) 2020 Fabian Bitter (www.bitter.de)
 * @version    X.X.X
 */

namespace Concrete\Package\SimpleYoutubeList\Block\YoutubeVideoList;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Error\ErrorList\ErrorList;
use Concrete\Core\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class Controller extends BlockController
{
    protected $btTable = "btYoutubeVideoList";
    /** @var int */
    protected $maxResults = 5; // 1 to 50
    /** @var string */
    protected $channelId = '';
    /** @var string */
    protected $playlistId = '';
    /** @var string */
    protected $apiKey = '';

    public function getBlockTypeDescription()
    {
        return t('Display all videos from a YouTube-channel.');
    }

    public function getBlockTypeName()
    {
        return t('Youtube Video List');
    }

    public function validate($args)
    {
        $errorList = new ErrorList();

        if (!isset($args["apiKey"]) || strlen($args["apiKey"]) < 1) {
            $errorList->add(t("You need to enter a valid API Key."));
        }

        if (!isset($args["channelId"]) || strlen($args["channelId"]) < 1) {
            $errorList->add(t("You need to enter a valid channel id."));
        }

        if (!isset($args["maxResults"]) || !is_numeric($args["maxResults"]) || $args["maxResults"] < 1 || $args["maxResults"] > 50) {
            $errorList->add(t("Max results must between 1 and 50"));
        }

        $r = Request::getInstance();

        if (!$errorList->has()) {
            try {
                $client = new Client();

                $client->request('GET', 'https://www.googleapis.com/youtube/v3/search', [
                    'query' => [
                        'key' => $args["apiKey"],
                        'channelId' => $args["channelId"],
                        'maxResults' => $args["maxResults"]
                    ],
                    'headers' => [
                        "Referer" => sprintf(
                            '%s://%s',
                            $r->getScheme(),
                            $r->getHost()
                        )
                    ]
                ]);

            } catch (ClientException $e) {
                $response = $e->getResponse();
                $raw = $response->getBody()->getContents();
                /** @noinspection PhpComposerExtensionStubsInspection */
                $json = json_decode($raw, true);

                foreach ($json["error"]["errors"] as $error) {
                    $errorList->add(t($error["message"]));
                }

            } catch (GuzzleException $e) {
                $errorList->add($e);
            }
        }

        return $errorList;
    }

    public function add()
    {
        $this->set('apiKey', "");
        $this->set('channelId', "");
        $this->set('playlistId', "");
        $this->set('maxResults', 5);
    }

    /** @noinspection PhpUnused */
    public function action_display_page($pageToken = null)
    {
        $results = [];

        try {
            $client = new Client();

            $r = Request::getInstance();

            if (isset($this->playlistId) && strlen($this->playlistId) > 0) {
                $response = $client->request('GET', 'https://www.googleapis.com/youtube/v3/playlistItems', [
                    'query' => [
                        'part' => 'snippet',
                        'type' => 'video',
                        'key' => $this->apiKey,
                        'playlistId' => $this->playlistId,
                        'maxResults' => $this->maxResults,
                        'pageToken' => $pageToken
                    ],
                    'headers' => [
                        "Referer" => sprintf(
                            '%s://%s',
                            $r->getScheme(),
                            $r->getHost()
                        )
                    ]
                ]);
            }   else {
                $response = $client->request('GET', 'https://www.googleapis.com/youtube/v3/search', [
                    'query' => [
                        'part' => 'snippet',
                        'type' => 'video',
                        'key' => $this->apiKey,
                        'channelId' => $this->channelId,
                        'maxResults' => $this->maxResults,
                        'pageToken' => $pageToken
                    ],
                    'headers' => [
                        "Referer" => sprintf(
                            '%s://%s',
                            $r->getScheme(),
                            $r->getHost()
                        )
                    ]
                ]);
            }

            $raw = $response->getBody()->getContents();
            /** @noinspection PhpComposerExtensionStubsInspection */
            $results = json_decode($raw, true);

        } catch (GuzzleException $e) {
            // Ignore
        }

        $this->set('results', $results);
    }

    public function view()
    {
        $this->action_display_page();
    }
}
