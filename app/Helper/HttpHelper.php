<?php declare(strict_types=1);

namespace App\Helper;


/**
 * Class HttpHelper
 * @package App\Helper
 * @author congge
 */
class HttpHelper
{
    /**
     * Retrieve Client Remote Address
     *
     * @return string
     */
    public static function getRemoteAddr()
    {
        $request = context()->getRequest();
        $ip = '';
        if (isset($request->getHeader('x-client-ip')[0])) {
            $ip = $request->getHeader('x-client-ip')[0];
        }

        if (!$ip && isset($request->getHeader('x-forwarded-for')[0])) {
            $ip = $request->getHeader('x-forwarded-for')[0];
        }

        if (!$ip && isset($request->getHeader('x-remote-ip')[0])) {
            $ip = $request->getHeader('x-remote-ip')[0];
        }

        if (!$ip && isset($request->getHeader('remote_addr')[0])) {
            $ip = $request->getHeader('remote_addr')[0];
        }

        return $ip;
    }

    /**
     * 解析 URL
     * @param $baseUrl
     * @return array
     */
    public static function parseBaseUrl($baseUrl): array
    {
        $urlinfo = parse_url($baseUrl);
        $ssl = false;
        $port = 80;
        if ('https' == $urlinfo['scheme']) {
            $ssl = true;
            $port = 443;
        }
        isset($urlinfo['port']) && $port = $urlinfo['port'];

        return [$urlinfo['host'], $port, $ssl];
    }

    /**
     * 获取  Accept-Language
     * @param string $default
     * @return string
     * @throws \Swoft\Exception\SwoftException
     */
    public static function getAcceptLanguage(string $default = 'zh-cn'): string
    {
        $acceptLanguage = current(context()->getRequest()->getHeader('accept-language'));
        if (empty($acceptLanguage)) {
            return $default;
        }
        preg_match('/^([a-z\d\-]+)/i', $acceptLanguage, $matches);
        if (!isset($matches[1])) {
            return $default;
        }
        $lang = strtolower($matches[1]);
        if ('en' == $lang) {
            $lang = 'en-us';
        } elseif ('zh' == $lang) {
            $lang = 'zh-cn';
        }
        return $lang;
    }

    /**
     * 获取请求头
     *
     * @param $key
     * @return string
     * @throws \Swoft\Exception\SwoftException
     */
    public static function getRequestHeader($key): string
    {
        return (string)current(context()->getRequest()->getHeader($key));
    }
}
