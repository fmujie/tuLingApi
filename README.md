现仅有图灵`Api`的文本交互功能

## 安装

 1. 安装包文件

	``` bash
	$ composer require fmujie/tuling
	```

## 配置

1. 注册 `ServiceProvider`:
	
	```php
	Fmujie\TulingApi\TulingApiServiceProvider::class,
	```

2. 创建配置文件：

	```shell
	php artisan vendor:publish
	```
	
	通常得需要选择`publish`哪一个服务，因为没带参数，选择编号 **[n ]**
	
	~~~bash
	[n ] Provider: Fmujie\TulingApi\TulingApiServiceProvider
	~~~
	
	执行命令后会在 `config` 目录下生成本扩展配置文件：`laravel-tuling-apikey.php`。
	
3. 在 `.env` 文件中增加如下配置：

	- `TULING_API_KEY`：图灵`ApiKey`。

## 使用

1. 文本交流
  
    ```php
    TulingApi::txtConversation(Request $request, $text = null, $userId, $city, $province, $street)
    ```
    
    接口字段：
    
    | 参数  | 类型  | 说明  | 可为空  |
    | ------------ | ------------ | ------------ | ------------ |
    | text | String | 合成的文本 | N |
    | userId | String | 用户唯一标识 | N |
    | city | String | 所在城市 | N |
    | province | String | 所在省份 | Y |
    | street | String | 所在路段 | Y |
    
    接口返回字段详细见 [图灵API V2.0接入文档](https://www.kancloud.cn/turing/www-tuling123-com/718227).
    
    #### 调用示例
    
    ~~~php
    <?php
    
    namespace App\Http\Controllers\Api;
    
    use Illuminate\Http\Request;
    use Fmujie\TulingApi\TulingApi;
    use App\Http\Controllers\Controller;
    
    class TestController extends Controller
    {
        public function test(Request $request)
        {
            $res = TulingApi::txtConversation($request, '我爱你');
            return response()->json([
                'result' => $this->return
            ], $this->statusCode);
        }
    }
    ~~~
    
    #### 返回示例
    
    ~~~json
    {
        "result": {
            "code": 1,
            "status": "success",
            "msg": "请求成功",
            "data": "我也喜欢你啦～"
        }
    }
    ~~~
    
    #### 注：使用`txt`优先级大于`Request`

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
