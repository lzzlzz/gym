<?php
namespace app\index\controller;
use think\Controller;
class Base extends Controller
{
    public function _initialize()
    {
        // if (Session::has('username')) {
        //     //已登陆，不做任何操作
        //    // dump(Session::get('username'));die();
        //    // 在基础控制器中安排的值 只要继承这个类的子类都可以使用这个值
        //    $username=Session::get('username');
        //    $this->assign([
        //     'username'=>$username,
        //    ]);
        // }else{
        //     // $this->redirect('Login/login');
        //     $this->error('请先登录!',url('Login/index'));
        // }
        $arem=db('state')->where('st_recommend',1)->select();
        $this->assign([
            'arem' =>$arem,
        ]);
    }
}
