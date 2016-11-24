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
        return self::formatResult(0, 'success', $data);
     }
     /**
      * 正常抢矿下调用的方法传入错误信息等
      * @param int $errCode
      * @param string $errorMsg
      * @param string $data
      */
    public static function formatResult($code, $errorMsg, $data = null){
        $result = array('code' => $code,'errmsg' => $errorMsg,'data'=>$data);
         return $result;
    }
    /**
     * 根据用户的手机号码和密码生成一个Token
     * @param string $mobile
     * @param string $pwd
     */
    
    public function set_Token($mobile,$pwd){
        return md5(md5($mobile).$pwd);
    }
    
    public function checkLogin(){
        $token = I('post.token');
        if(session('session_Token')==$token){
             $this->ajaxReturn(self::formatSuccessResult($token));
        }
        $this->ajaxReturn(self::formatResult('111', 'Access token expired'));
    }
    
}