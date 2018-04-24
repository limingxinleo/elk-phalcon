<?php
// +----------------------------------------------------------------------
// | ElkTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Units;

use App\Core\Support\Clients\ElkClient;
use App\Core\Support\Reporters\ElkAsyncReporter;
use Tests\UnitTestCase;

/**
 * Class UnitTest
 */
class ElkTest extends UnitTestCase
{
    public function testConfig()
    {
        $config = di('configCenter')->get('elk')->elasticsearch->host;
        $this->assertNotEmpty($config->toArray());
    }

    public function testReporter()
    {
        ElkAsyncReporter::getInstance()->log('debug', 'xxxxx{test}', ['test' => 'yyy']);
    }
}