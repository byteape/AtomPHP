<?php

namespace freamwork;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\RedisCache;

/**
 * 缓存处理
 * Class Cache
 * @package freamwork
 */
class Cache {

    /**
     * 获取缓存引擎
     * @return FilesystemCache|RedisCache
     */
    private static function getDriver() {
        $cache_driver = config::get('app', 'cache_driver');
        switch ($cache_driver) {
            case 'file':
                $cacheDriver = new FilesystemCache(__DIR__ . '/../runtime/cache');

                break;
            case 'redis':
                $redis = new Redis();

                $redis->pconnect(getenv('REDIS_URI'), getenv('REDIS_PORT'), getenv('REDIS_DB'));

                $cacheDriver = new RedisCache($redis);

                break;
        }
        return $cacheDriver;
    }

    /**
     * 获取缓存数据
     * @param $id
     * @return false|mixed
     */
    public static function fetch($id) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->fetch($id);
    }

    /**
     * 是否存在缓存数据
     * @param $id
     * @return bool
     */
    public static function contains($id) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->contains($id);
    }

    /**
     * 存储缓存
     * @param $id
     * @param $data
     * @param int $lifeTime 单位秒
     * @return bool
     */
    public static function save($id, $data, $lifeTime = 0) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->save($id, $data, $lifeTime);
    }

    /**
     * 删除缓存
     * @param $id
     * @return bool
     */
    public static function delete($id) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->delete($id);
    }

    /**
     * 获取缓存的状态
     * @return array|null
     */
    public static function getStats() {
        $cacheDriver = self::getDriver();
        return $cacheDriver->getStats();
    }
}