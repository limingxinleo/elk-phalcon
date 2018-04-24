<?php
// +----------------------------------------------------------------------
// | ElkClient.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Support\Clients;

use Elasticsearch\Client as ElasticsearchClient;
use Elasticsearch\ClientBuilder;

class ElkClient
{
    public static $_instance;

    /**
     * @desc   获取到ElasticsearchClient单例
     * @author limx
     * @return ElasticsearchClient
     */
    public static function getInstance()
    {
        if (isset(static::$_instance) && static::$_instance instanceof ElasticsearchClient) {
            return static::$_instance;
        }

        $config = di('configCenter')->get('elk')->elasticsearch->host;
        return static::$_instance = ClientBuilder::create()->setHosts($config->toArray())->build();
    }
}