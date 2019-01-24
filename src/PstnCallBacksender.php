<?php

//namespace Qcloud\Sms;

//use Qcloud\Sms\SmsSenderUtil;

/**
 * 中间号接口类
 *
 */
class CallBack
{
    private $url;
    private $appid;
	private $id;


    /**
     * 回拨呼叫请求
     *
     * 
     * @param int    $appId        appId 值测试时由腾讯统一分配
     * @param string $requestId  session buffer，字符串最大长度不超过 48 字节，该 requestId 在后面回拨请求响应和回调中都会原样返回
     * @param string $src     主叫号码(必须为 11 位手机号，号码前加 0086，如 008613631686024)
     * @param string $dst      被叫号码(必须为 11 位手机或固话号码,号码前加 0086，如008613631686024，固话如：0086075586013388)
     * @param string $srcDisplayNum      主叫显示系统分配的固话号码，如不填显示随机分配号码
     * @param string $dstDisplayNum         被叫显示系统分配的固话号码，如不填显示随机分配号码
	 * @param string $record         是否录音，0 表示不录音，1 表示录音。默认为不录音
	 * @param string $maxAllowTime         允许最大通话时间，不填默认为 30 分钟（单位：分钟）
	 * @param string $bizId         业务应用 key
	 * @param string $statusFlag         主叫发起呼叫状态
	 * @param string $statusUrl         状态回调通知地址，正式环境可以配置默认推送地址
	 * @param string $hangupUrl         话单回调通知地址，正式环境可以配置默认推送地址
	 * @param string $recordUrl         录音回调通知地址，正式环境可以配置默认推送地址
     * @return string 应答json字符串，详细内容参见腾讯云协议文档
     */
    public function send($appId,$id,$requestId,$src,$dst,$srcDisplayNum,$dstDisplayNum,
	$record,$maxAllowTime,$bizId,$statusFlag,$statusUrl,$hangupUrl,$recordUrl,$orderId,$ringRecognition,
	$url,$readPrompt,$interruptPrompt,$repeatTimes,$keyPressUrl,$promptGender,$key,$operate)
    {
        
        $wholeUrl = $url."/201511v3/callBack?id=".$id;

        // 按照协议组织 post 包体
        $data = new \stdClass();
		$preCallerHandle = new \stdClass();
		
        $data->appId =$appId;
        $data->requestId = $requestId;
        $data->src = $src;
        $data->dst = $dst;
        $data->srcDisplayNum = $srcDisplayNum;
		$data->dstDisplayNum = $dstDisplayNum;
		$data->record = $record;
		$data->maxAllowTime = $maxAllowTime;
		$data->bizId = $bizId;
		$data->statusFlag = $statusFlag;
		$data->statusUrl = $statusUrl;
		$data->hangupUrl = $hangupUrl;
		$data->recordUrl = $recordUrl;
		$data->recordUrl = $recordUrl;
		$data->orderId = $orderId;
		$data->ringRecognition = $ringRecognition;
		$data->preCallerHandle=$preCallerHandle;
		//preCallerHandle结构体
		$preCallerHandle->readPrompt=$readPrompt;
		$preCallerHandle->interruptPrompt=$interruptPrompt;
		$preCallerHandle->keyList=[["key"=>$key,"operate"=>$operate]];
		$preCallerHandle->repeatTimes=$repeatTimes;
		$preCallerHandle->keyPressUrl=$keyPressUrl;
		$preCallerHandle->promptGender=$promptGender;
		// $rs=json_encode($data);
		// echo "$rs";
		// echo $wholeUrl;
		$PstnSenderUtil=new PstnSenderUtil();
		
        return $PstnSenderUtil->sendCurlPost($wholeUrl, $data);
    }

    /**
     * 回拨呼叫取消
     *
     * @param string $appId  appId 值测试时由腾讯统一分配
     * @param string $callId 回拨请求响应中返回的 callId
     * @param int    $cancelFlag     0：不管通话状态直接拆线（默认) 1：主叫响铃以后状态不拆线 2：主叫接听以后状态不拆线 3：被叫响铃以后状态不拆线 4：被叫接听以后状态不拆线
     * @return string 应答json字符串，详细内容参见腾讯云协议文档
     */
    public function cancel($appId,$id,$callId,$cancelFlag,$url)
    {
     
       $wholeUrl = $url . "/201511v3/callCancel?id=" . $id;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $data->appId = $appId;
        $data->callId = $callId;
        $data->cancelFlag = $cancelFlag;
		$PstnSenderUtil=new PstnSenderUtil();
        return $PstnSenderUtil->sendCurlPost($wholeUrl, $data);
    }
	
	    /**
     * 获取回拨话单
     *
     * @param string $appId  appId 值测试时由腾讯统一分配
     * @param string $callId 回拨请求响应中返回的 callId，按 callId 查询该话单详细信息
     * @param int    $src     查询主叫用户产生的呼叫话单，如填空表示拉取这个时间段所有话单
     * @param array  $startTimeStamp      话单开始时间戳
     * @param string $endTimeStamp        话单结束时间戳
     * @param string $compress      是否压缩（0：不压缩 1：使用 zlib 压缩）默认不压缩
     * @return string 应答json字符串，详细内容参见腾讯云协议文档
     */
    public function GetCdr($appId,$id,$src,$startTimeStamp,$endTimeStamp,$compress,$url)
    {
     
       $wholeUrl = $url . "/201511v3/getCdr?id=" . $id;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $data->appId = $appId;
        //$data->callId = $callId;
        $data->src = $src;
        $data->startTimeStamp = $startTimeStamp;
		$data->endTimeStamp = $endTimeStamp;
		$data->compress = $compress;
		$PstnSenderUtil=new PstnSenderUtil();
        return $PstnSenderUtil->sendCurlPost($wholeUrl, $data);
    }
}
