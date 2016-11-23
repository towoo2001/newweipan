<?php
namespace Api\Controller;
use Think\Controller;
class BaseController extends Controller{
    /**
     * 返回成功结果,附加成功code
     * @param  type $data
     * @return array
     */    
    public static function formatSuccessResult($data = null){
        return self::formatResult(0, 'ok', $data);
     }
     /**
      * 
      * @param int $errCode
      * @param string $errorMsg
      * @param string $data
      */
    public static function formatResult($errCode, $errorMsg, $data = null){
        $result = [
            'errcode' => $errCode,
            'errmsg' => $errorMsg,
            'data'=>$data,
        ];
        return json_encode($result);
    }
}