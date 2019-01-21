# AtomPHP

* 这是一款超级简洁的PHP框架，麻雀虽小，五脏俱全。
* 该框架集合了目前国内外主流的工具。更多用法会逐步翻译整理文档。
* MVC设计模式，精简的核心引擎。
* 环境要求：PHP5.6+
### 目录结构
```
- app 应用目录
  |-Controllers 控制器目录
  |-Helper 自定义函数目录
  |-Models 数据模型目录
  |-Views 模板文件目录
- config 配置文件目录
- freamwork 框架库文件目录
- public 入口目录
- resources 系统资源目录
- runtime  运行文件目录
  |-cache 缓存目录
  |-log 日志目录
  |-temp 模板缓存目录
```
### 安装方法
```
配置.env
composer install
```
### 基本应用
```
//获取参数
//var_dump(Request::all());
//var_dump(Request::get('c'));

//获取链接
//var_dump(url('index/test', array('test' => 1)));

//输出日志
//Log::notice('这是一个日志信息');
//……

//获取数据库数据
//$user = new User();
//$user = $user->getname(2);
//var_dump($user);
//var_dump(Model::db()->select('user','*'));

//输出自定义函数信息
//var_dump(testFunction());

//定义与获取数据缓存
//Cache::set('key','data',60);
//var_dump(Cache::get('key'));
//var_dump(Cache::remember('key','data',60));

//获取语言包文件
//var_dump(language('Home'));
```

### 未完待续