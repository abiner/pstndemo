<?php

//require __DIR__ . "/vendor/autoload.php";

//use Qcloud\Sms\SmsSingleSender;
//use Qcloud\Sms\SmsMultiSender;
//use Qcloud\Sms\SmsVoiceVerifyCodeSender;
//use Qcloud\Sms\SmsVoicePromptSender;
//use Qcloud\Sms\SmsStatusPuller;
//use Qcloud\Sms\SmsMobileStatusPuller;
include "src/PstnCallBacksender.php";
include "src/PstnGetNumsender.php";
include "src/PstnSenderUtil.php";

// PSTN AppID
$appId ="65685";  //appId 值测试时由腾讯统一线下分配，回拨跟中间号不一样，请注意填写
// PSTN ID
$id ="changid" ;  //Id 值测试时由腾讯统一线下分配，回拨跟中间号不一样，请注意填写

$url="http://test.pstn.avc.qcloud.com:8080";  //请填写分配的host域名，只需要填写http://host这部分

$src="008613515424875"; //主叫用户

$dst="008613548754854";//被叫用户

$statusUrl="";  //状态回调地址，post接收json数据，端口请配置80或者8080

$hangupUrl="";  //话单回调地址，post接收json数据，端口请配置80或者8080

$recordUrl="";  //录音回调地址，post接收json数据，端口请配置80或者8080

$callback=new CallBack();
$GetVirtualNum=new GetVirtualNum();

// 回拨呼叫请求
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
	
	
	$readPrompt="您拨打的电话转接中";//结构体是要配合按键支持播放，如果没有需求可以不用使用
	$interruptPrompt="请按1";
	$repeatTimes="2";
	$keyPressUrl="";
	$promptGender="1";
	$key="1";
	$operate="1";
	
	
    $result = $callback->send($appId,$id,$requestId,$src,$dst,$srcDisplayNum,$dstDisplayNum,
	$record,$maxAllowTime,$bizId,$statusFlag,$statusUrl,$hangupUrl,$recordUrl,$orderId,$ringRecognition,
	$url,$readPrompt,$interruptPrompt,$repeatTimes,$keyPressUrl,$promptGender,$key,$operate);  //发送请求
    $rsp = json_decode($result);
    echo $result;
} catch(\Exception $e) {
    echo var_dump($e);
}

//回拨呼叫取消
try {
  
	$callId="12-190123-7f1020da3bf94e19b324a613ccf3e96d";//回拨请求响应中返回的 callId
	$cancelFlag="";
    $result = $callback->cancel($appId,$id,$callId,$cancelFlag,$url);
    $rsp = json_decode($result);
    echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}


//拉取回拨话单
try {
	
	$src="008613537644647"; //callId和src选填其一，src为“”时，表示查询开始和结束时间内的所有通话。
	$startTimeStamp="1548223200";
	$endTimeStamp="1548235500";
	$compress="0";
    $result = $callback->GetCdr($appId,$id,$src,$startTimeStamp,$endTimeStamp,$compress,$url);
    $rsp = json_decode($result);
	 echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}


//获取中间号
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

//解绑中间号
try {
	$requestId="";
	$bindId="5d891110-ca0a-4f8a-9272-10f86e8ffd7b";
	$result = $GetVirtualNum->delVirtualNum($appId,$id,$requestId,$bindId,"",$url);
    $rsp = json_decode($result);
    echo $result;
} catch (\Exception $e) {
    echo var_dump($e);
}

//拉取中间号话单
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

echo "\n";


