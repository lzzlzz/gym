<?php
namespace app\index\controller;
use think\Controller;
class Bulletin extends Base
{
    public function index()
    {
    	$bulletin=db('bulletin')->paginate(2);
    	
    	$this->assign([
    		'bulletin'=>$bulletin,
    		
    	]);
    	//dump($index);die();
        return view();
    }

    public function content($id){
        $content=db('bulletin')->find($id);
        $this->assign([
            'content'=>$content,
        ]);
        return view();
    }
}
