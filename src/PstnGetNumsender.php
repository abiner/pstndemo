<?php

//namespace Qcloud\Sms;

//use Qcloud\Sms\SmsSenderUtil;

/**
 * 中间号接口类
 *
 */
class GetVirtualNum
{
    private $url;
    private $appid;



    /**
     * 获取中间号
     *
     * 
     *
     * @param int    $appId        xxx，appId 值测试时由腾讯统一分配
     * @param string $requestId  session buffer，字符串最大长度不超过 42 字节，该 requestId 在后面回拨请求响应和回调中都会原样返回
     * @param string $src     主叫号码(号码前加 0086，如 008613631686024)，xb 模式下是不用填写，axb 模式下是必选
     * @param string $dst      被叫号码(号码前加 0086，如 008613631686024)
     * @param string $accreditList      {“accreditList”:[“008613631686024”,”008612345678910”]}，主要用于 N-1 场景，号码绑定非共享是独占型，指定了 dst 独占中间号绑定，accreditList 表示这个列表成员可以拨打 dst 绑 定的中间号，默认值为空，表示所有号码都可以拨打独占型中间号绑定，最大集合不允许超过 30 个，仅适用于xb模式。
     * @param string $assignVirtualNum         指定中间号，如果该中间号已被使用返回绑定失败，如果不带该字段由腾讯侧从号码池里自动分配
	 * @param string $record         是否录音，0 表示不录音，1 表示录音。默认为不录音，注意如果需要录音回调，通话完成后需要等待一段时间，收到录音回调之后，再解绑中间号。
	 * @param string $cityId         主被叫号码归属地，详见《腾讯-中间号-城市id.xlsx》
	 * @param string $bizId         应用二级业务 ID，bizId 需保证在该 appId 下全局唯一，最大长度不超过 16 个字节。
	 * @param string $maxAssignTime       号码最大绑定时间，不填默认为 24 小时，最长绑定时间是168小时，单位秒
	 * @param string $statusFlag         呼叫状态
	 * @param string $statusUrl         请填写statusFlag并设置值，状态回调通知地址，正式环境可以配置默认推送地址
	 * @param string $hangupUrl         话单回调通知地址，正式环境可以配置默认推送地址
	 * @param string $recordUrl         录单 URL 回调通知地址，正式环境可以配置默认推送地址
     * @return string 应答json字符串，详细内容参见腾讯云协议文档
     */
    public function send($appId,$id,$requestId,$src,$dst,$accreditList,$assignVirtualNum,$record,$cityId,$bizId,$maxAssignTime,$statusFlag,$statusUrl,$hangupUrl,$recordUrl,$url)
    {
        
        $wholeUrl = $url . "/201511v3/getVirtualNum?id=" . $id;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $data->appId =$appId;
        $data->requestId = $requestId;
        $data->src = $src;
        $data->dst = $dst;
        //$data->accreditList = $accreditList;
		$data->assignVirtualNum = $assignVirtualNum;
		$data->record = $record;
		//$data->cityId = $cityId;
		//$data->bizId = $bizId;
		$data->maxAssignTime = $maxAssignTime;
		$data->statusFlag = $statusFlag;
		$data->statusUrl = $statusUrl;
		$data->hangupUrl = $hangupUrl;
		$data->recordUrl = $recordUrl;
		$PstnSenderUtil= new PstnSenderUtil();
        return $PstnSenderUtil->sendCurlPost($wholeUrl, $data);
    }

    /**
     * 解绑中间号
     *
     * @param string $appId  xxx，appId 值测试时由腾讯统一分配
     * @param string $requestId session buffer，字符串最大长度不超过 42 字节，该 requestId 在后面回拨请求响应和回调中都会原样返回
     * @param int    $bindId     双方号码 + 中间号绑定 ID，该 ID 全局唯一
     * @param array  $bizId      应用二级业务 ID，bizId 需保证在该 appId 下全局唯一，最大长度不超过 16 个字节。
     * @return string 应答json字符串，详细内容参见腾讯云协议文档
     */
    public function delVirtualNum($appId,$id,$requestId,$bindId,$bizId,$url)
    {
     
       $wholeUrl = $url . "/201511v3/delVirtualNum?id=" . $id;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $data->appId = $appId;
        $data->requestId = $requestId;
        $data->bindId = $bindId;
        //$data->bizId = $bizId;
		$PstnSenderUtil= new PstnSenderUtil();
        return $PstnSenderUtil->sendCurlPost($wholeUrl, $data);
    }
	
	    /**
     * 获取话单
     *
     * @param string $appId   xxx，appId 值测试时由腾讯统一分配
     * @param string $callId 通话唯一标识 callId
     * @param int    $src     查询主叫用户产生的呼叫话单，如填空表示拉取这个时间段所有话单
     * @param array  $startTimeStamp      话单开始时间戳
     * @param string $endTimeStamp        话单结束时间戳
     * @param string $compress      是否压缩（0：不压缩 1：使用 zlib 压缩）默认不压缩
     * @return string 应答json字符串，详细内容参见腾讯云协议文档
     */
    public function get400Cdr($appId,$id,$callId,$src,$startTimeStamp,$endTimeStamp,$compress,$url)
    {
     
       $wholeUrl = $url . "/201511v3/get400Cdr?id=" . $id;

        // 按照协议组织 post 包体
        $data = new \stdClass();
        $data->appId = $appId;
        //$data->callId = $callId;
        $data->src = $src;
        $data->startTimeStamp = $startTimeStamp;
		$data->endTimeStamp = $endTimeStamp;
		$data->compress = $compress;
		
		$PstnSenderUtil= new PstnSenderUtil();
        return $PstnSenderUtil->sendCurlPost($wholeUrl, $data);
    }
}
