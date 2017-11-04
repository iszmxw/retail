<?php
/**
 * Created by PhpStorm.
 * User: zeo
 * Date: 2017/11/4
 * Time: 22:45
 * 本文件用于学习Redis.
 */
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller{
    public function study(){
        dump("开始学习Redis了");
        //app('redis.connection') 默认连接default
        //app('redis')->connection('zeo') 连接到我定义的redis服务器
        //app('redis')->connection('lingyikeji') //连接到lingyikeji集群对象

        dump("最简单的Redis的存取");
        //$redis = app('zeo');//连接到我的redis服务器
        //$redis->set('test1', '这是第一个Redis示例');
        //$test1 = $redis->get('test1');
        //dump($test1);
        Redis::connection('zeo');//连接到我的redis服务器
        Redis::set('test1', '这是第一个Redis示例');
        $test1 = Redis::get('test1');
        dump($test1);

        dump("同时存储多个key-value");
        $list = array(
            'zeo:0001' => '第一个值',
            'zeo:0002' => '第二个值r',
            'zeo:0003' => '第三个值'
        );
        Redis::mset($list);
        dump(array_keys( $list));
    }
}