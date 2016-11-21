<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $buttonList = R('Server/PrivServer/getButton');
        $this->assign('buttonList',$buttonList);
        $this->display();
    }
    
    public function main(){
        $this->display();
    }
}