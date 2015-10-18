<?php 

/**
 * 发送信鸽
 * $account 手机号码
 * $send_type    1 客服后台司机状态认证成功和失败发送 title identify    $content(driver_type) 司机认证状态 1 认证通过 3 认证失败
 *               2 公版发送消息 title public_driver_message
 */
if ( ! function_exists('push_xingeapp'))
{
    function push_xingeapp($account, $send_type = 1, $content = 1)
    {
        $pattern = '#^1([3578][0-9]|45|47)[0-9]{8}$#';
        if (!preg_match($pattern, $account)) {
            $error = '无效的手机号码';

            return $error;
        }

        $CI =& get_instance();
        
        require_once FCPATH.'application/libraries/XingeApp.php';

        // 发送消息
        if ($send_type == 1) {
            $accessId = '2100078639';
            $secretKey = '044a8221781eae8b50271f419a64cf6c';
            $push = new XingeApp($accessId, $secretKey);
            $mess = new Message();

            $mess->setType(Message::TYPE_MESSAGE);
            $mess->setTitle('identify');
            $mess->setContent($content);
            $res = $push->PushSingleAccount(0, $account, $mess);
        } elseif ($send_type == 2) {
            $accessId = '2100125550';
            $secretKey = 'cd847e25372faeb9cfd5d1a54dd5ab61';
            $push = new XingeApp($accessId, $secretKey);
            $mess = new Message();

            $mess->setType(Message::TYPE_MESSAGE);
            $mess->setTitle('public_driver_message');
            $mess->setContent($content);
            $res = $push->PushSingleAccount(0, $account, $mess);
        }

        if ($res['ret_code'] === 0) {
            return 'success';
        }

        if (empty($res['err_msg'])) {
            $rets = $res['ret_code'];
        } else {
            $rets = $res['ret_code']."=>".$res['err_msg'];
        }
        
        return $rets;
    }
}