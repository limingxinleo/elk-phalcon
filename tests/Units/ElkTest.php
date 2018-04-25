<?php
// +----------------------------------------------------------------------
// | ElkTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Units;

use App\Common\Enums\SystemCode;
use App\Core\Support\Clients\ElkClient;
use App\Core\Support\Reporters\ElkAsyncReporter;
use limx\Support\Collection;
use Tests\UnitTestCase;

/**
 * Class UnitTest
 */
class ElkTest extends UnitTestCase
{
    protected function getElasticSearchInfoById($id)
    {
        $client = ElkClient::getInstance();
        $res = $client->search([
            'index' => SystemCode::ELK_INDEX,
            'type' => SystemCode::ELK_TYPE,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['term' => ['context.id' => $id]],
                        ],
                    ]
                ],
                'size' => 1,
            ],
        ]);

        return $res['hits'];
    }

    public function testConfig()
    {
        $config = di('configCenter')->get('elk')->elasticsearch->host;
        $this->assertNotEmpty($config->toArray());
    }

    public function testReporterSimpleString()
    {
        $id = uniqid();
        ElkAsyncReporter::getInstance()->log('debug', 'id:{id}, I am {name}', ['name' => 'limx', 'id' => $id]);
        sleep(5);

        $res = $this->getElasticSearchInfoById($id);
        $this->assertEquals(1, $res['total']);
    }

    public function testReporterCollection()
    {
        $id = uniqid();
        ElkAsyncReporter::getInstance()->log('debug', 'id:{id}, My info is {info}', ['id' => $id, 'info' => new Collection([
            'name' => 'limx',
            'age' => 28
        ])]);
        sleep(5);

        $res = $this->getElasticSearchInfoById($id);
        $this->assertEquals(1, $res['total']);
    }
}