<?php

function responseData($data = [])
{
    return context()->getResponse()->withHeaders(['Content-Type' => 'application/json'])->withContent(json_encode($data,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}

function responseSuccess()
{
    return context()->getResponse()->withHeaders(['Content-Type' => 'application/json'])->withContent('');
}

function initListResult($params)
{
    $params['page_num'] = (int)($params['page_num'] ?? 1);
    $params['page_size'] = (int)($params['page_size'] ?? 10);

    $params['page_num'] = (0 < $params['page_num'] ? $params['page_num'] : 1);
    $params['page_size'] = (0 < $params['page_size'] ? $params['page_size'] : 10);

    return [
        'page_num' => $params['page_num'],
        'page_size' => $params['page_size'],
        'total' => 0,
        'list' => []
    ];
}

function translate(string $key, array $params = []): string
{
    return \Swoft::t($key, $params, \App\Helper\HttpHelper::getAcceptLanguage());
}