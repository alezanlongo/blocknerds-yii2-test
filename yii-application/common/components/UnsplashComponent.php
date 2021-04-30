<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

class UnsplashComponent extends Component
{
    public function get($query = null)
    {
        $dt = new \DateTime();

        $key = 'HxQzenO99ZGmXEIQ0Tgk4JHV5P3bRhH84LMnbkglDPA';

        $url = 'https://api.unsplash.com/';

        $client = new Client(['baseUrl' => $url]);

        $data = ['client_id' => $key];

        if ($query) {
            $data['query'] = $query;
        }

        try {
            $response = $client->get('search/photos', $data)
                ->setOptions([
                    'timeout' => 3,
                ])
                ->send();
        } catch (\Throwable $th) {
            return false;
        }

        return $response->getData();
    }
}
