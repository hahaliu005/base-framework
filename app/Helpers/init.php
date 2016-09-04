<?php
/**
 * 此文件在laravel还未初始化时就已加载, 使用时请注意
 * 也就是说在laravel的任何地方都可以调用此处的常量与函数
 * 全局常量请加上'APP_'前缀
 */

const APP_SERVICE_ADMIN = 'admin';
const APP_SERVICE_PORTAL = 'portal';
const APP_SERVIDE_TRANS = 'transcoder';

const QUEUE_VIDEO_CHECK = 'video_check';
const QUEUE_VIDEO_TRANS = 'video_trans';

function getBaseDir()
{
    static $baseDir;
    if (! $baseDir) {
        $baseDir = realpath(__DIR__ . '/../../');
    }
    return $baseDir;
}

function getCommonConfig()
{
    static $common;
    if (! $common) {
        $common = parse_ini_file(getBaseDir() . '/common.ini', true);
    }
    return $common;
}

function getService()
{
    static $service;
    if (! $service) {
        $service = getCommonConfig()['base']['service'];
    }
    return $service;
}

function getServiceViewPath()
{
    static $serviceViewPath;
    if (! $serviceViewPath) {
        $serviceViewPath = getBaseDir() . '/resources/' . getService() . '/views';
    }
    return $serviceViewPath;
}

function appElixir($dir)
{
    return elixir($dir);
}
