腾讯云PSTN PHP DEMO
===

## 腾讯云PSTN号码保护

目前`腾讯云号码保护`为客户提供`回拨`、`中间号`等功能，腾讯云号码保护DEMO支持以下操作：

### 回拨

回拨支持操作：

- 回拨请求
- 回拨取消
- 拉取回拨话单


> `Note` 回拨回调请自行填写url，post接收json数据

### 中间号

中间号支持操作：

- 获取中间号
- 解绑中间号
- 拉取中间号话单


> `Note` 中间号回调请自行填写url，post接收json数据



## 开发

### 准备

在开始应用之前，需要准备如下信息:

- [x] 获取AppID和id

该数据是对接后腾讯云线下分配的，请自行保存好数据。

- [x] 白名单ip地址

准备需要进行调试的服务器ip，需要进行加入白名单配置后才可以调用测试使用。


## 安装



### 手动

1. 手动下载或clone最新版本qcloudsms_php代码
2. 直接调用app.php文件使用即可，或者放入项目中include使用。

## 用法

查阅app.php文件内容，所需的funtion调用即可使用

- **准备必要参数**

```php
// PSTN AppID
$appId ="65685";  //appId 值测试时由腾讯统一线下分配，回拨跟中间号不一样，请注意填写

// PSTN ID
$id ="changid" ;  //Id 值测试时由腾讯统一线下分配，回拨跟中间号不一样，请注意填写

$url="http://test.pstn.avc.qcloud.com:8080";  //请填写分配的host域名，只需要填写http://host这部分

$src="008613515424875"; //主叫用户，格式0086+手机号

$dst="008613548754854";//被叫用户，格式0086+手机号

$statusUrl="https://xxxxxx:8080";  //状态回调地址，post接收json数据，端口请配置80或者8080

$hangupUrl="https://xxxxxx:8080";  //话单回调地址，post接收json数据，端口请配置80或者8080

$recordUrl="https://xxxxxx:8080";  //录音回调地址，post接收json数据，端口请配置80或者8080


```

- **回拨请求**

```php

try {   
	$requestId="123456";  //数值为案例
	$srcDisplayNum="075561948986";
	$dstDisplayNum="";
	$record="1";
	$maxAllowTime="10";
	$statusFlag="16191";
	$bizId="";
	$orderId="";
	$ringRecognition="";
	
	//下列结构体是要配合按键支持播放使用，如果没有需求可以不用使用
	$readPrompt="您拨打的电话转接中";
	$interruptPrompt="请按1";
	$repeatTimes="2";
	$keyPressUrl="";
	$promptGender="1";
	$key="1";
	$operate="1";
	
	//发送请求
    $result = $callback->send($appId,$id,$requestId,$src,$dst,$srcDisplayNum,$dstDisplayNum,
	$record,$maxAllowTime,$bizId,$statusFlag,$statusUrl,$hangupUrl,$recordUrl,$orderId,$ringRecognition,
	$url,$readPrompt,$interruptPrompt,$repeatTimes,$keyPressUrl,$promptGender,$key,$operate);
	
    $rsp = json_decode($result);
    echo $result;
} catch(\Exception $e) {
    echo var_dump($e);
}
```

> `Note` 


- **回拨呼叫取消**

```php
try {
  
	$callId="12-190123-7f1020da3bf94e19b324a613ccf3e96d";//回拨请求响应中返回的 callId
	$cancelFlag="";
    $result = $callback->cancel($appId,$id,$callId,$cancelFlag,$url);
    $rsp = json_decode($result);
    echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}
```

> `Note` 

- **拉取回拨话单**

```php
try {
	
	$src="008613515424875"; //callId和src选填其一，src为“”时，表示查询开始和结束时间内的所有通话。
	$startTimeStamp="1548223200";
	$endTimeStamp="1548235500";
	$compress="0";
    $result = $callback->GetCdr($appId,$id,$src,$startTimeStamp,$endTimeStamp,$compress,$url);
    $rsp = json_decode($result);
	 echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}
```

> `Note` 

- **获取中间号**

```php
try {
	$requestId="123456";  //数值为案例
	//$accreditList="";$cityId="";$bizId="";这三个非必选参数可以不用填
	$assignVirtualNum="008617080219075";
	$record="1";
	
	$maxAssignTime="30";
	$statusFlag="16191";
	$result = $GetVirtualNum->send($appId,$id,$requestId,$src,$dst,"",
	$assignVirtualNum,$record,"","",$maxAssignTime,$statusFlag,$statusUrl,$hangupUrl,$recordUrl,$url);
    $rsp = json_decode($result);
    echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}
```

> `Note` 

- **解绑中间号**

```php
try {
	$requestId="";
	$bindId="5d891110-ca0a-4f8a-9272-10f86e8ffd7b";
	$result = $GetVirtualNum->delVirtualNum($appId,$id,$requestId,$bindId,"",$url);
    $rsp = json_decode($result);
    echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}
```

> `Note`

- **拉取中间号话单**

```php
try {
	
	$src="008613515424875"; //callId和src选填其一，src为“”时，表示查询开始和结束时间内的所有通话。
	$startTimeStamp="1548240600";
	$endTimeStamp="1548241860";
	$compress="0";
    $result = $GetVirtualNum->get400Cdr($appId,$id,"",$src,$startTimeStamp,$endTimeStamp,$compress,$url);
    $rsp = json_decode($result);
    echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}
```

