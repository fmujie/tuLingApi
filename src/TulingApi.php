<?php

namespace Fmujie\TulingApi;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 图灵Api V2
 * @package Fmujie\TulingApi
 */
class TulingApi{

    /**
     * @return array
     */
    private static function loadConfig()
    {
        $config = [
            'tulingApiKey' => config('laravel-tuling-apikey.tuling_api_key')
        ];
        return $config;
    }

    /**
     * 文本交流
     *
     * @param $text string 合成的文本
     * @param $userId string 用户唯一标识
     * @param $city string 所在城市
     * @param $province string 所在省份
     * @param $street string 所在路段
     * @return response
     */
     public static function txtConversation(Request $request, $text = null, $userId = 1, $city = '淄博', $province = 'province', $street = '新村西路')
     {
         $config = self::loadConfig();
         $tulingApiKey = $config['tulingApiKey'];
         if(!$text)
         {
             $input = $request->all();
             $requestInfo = $request->input('userSendInfo');
             if(!$requestInfo)
             {
                 return response()->json([
                     'code' => 0,
                     'status' => 'error',
                     'msg' => '请求字段为空',
                     'data' => null,
                 ], 200);
             }
         }else {
             $requestInfo = $text;
         }
         $tuLingV2Url = 'http://openapi.tuling123.com/openapi/api/v2';
         $requestData = [
             'reqType' => 0,
             'perception' => [
                     'inputText' => [
                         'text' => "$requestInfo",
                     ],
                     'selfInfo' => [
                         'location' => [
                             'city' => "$city",
                             'province' => "$province",
                             'street' => "$street",
                         ]
                     ]
                 ],
             'userInfo' => [
                 'apiKey' => "$tulingApiKey",
                 'userId' => "$userId"
             ]
         ];
         $client = new Client(['headers' => ['Content-Type'=>'application/json']]);
         $tulingResponse = $client->request('POST', $tuLingV2Url, [
             'body' => json_encode($requestData)
         ]);
         $tuLingResCode = $tulingResponse->getStatusCode();
         if($tuLingResCode != 200)
         {
             return response()->json([
                 'code' => 0,
                 'status' => 'error',
                 'msg' => '获取图灵api响应失败',
                 'data' => null,
             ], 200);
         }
         $tuLingResBodyObj = json_decode($tulingResponse->getBody());
         $tuLingResIntentCode = $tuLingResBodyObj->intent->code;
         if($tuLingResIntentCode != 10004)
         {
             return response()->json([
                 'code' => 0,
                 'status' => 'error',
                 'msg' => '参数出错',
                 'data' => null,
             ], 200);
         }
         $tuLingResInfo = $tuLingResBodyObj->results[0]->values->text;
         return response()->json([
             'code' => 1,
             'status' => 'success',
             'msg' => '请求成功',
             'data' => $tuLingResInfo,
         ], 200);
     }
}