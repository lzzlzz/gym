<?php
namespace app\index\controller;
use think\Controller;
class Index extends Base
{
    public function state()
    {
    	$state=db('state')->paginate(2);
    	
    	$this->assign([
    		'state'=>$state,
    		
    	]);
    	//dump($state);die();
        return view();
    }

    public function content($id){
        $content=db('state')->find($id);
        $this->assign([
            'content'=>$content,
        ]);
        return view();
    }
}
