<?php
namespace app\index\controller;
use think\Controller;
class Online extends Base
{
    public function index()
    {
    	$online=db('online')->paginate(2);
    	
    	$this->assign([
    		'online'=>$online,
    		
    	]);
    	//dump($index);die();
        return view();
    }

    public function content($id){
        $content=db('online')->find($id);
        $this->assign([
            'content'=>$content,
        ]);
        return view();
    }
}
