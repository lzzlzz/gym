<?php
namespace app\admin\controller;
use think\Controller;
class Cate extends Controller
{
	//添加课程类别
    public function add(){
      //获取课程分类
      $cateRes=model('Cate')->cateTree();
     // dump($cateRes);die();
      $this->assign([
        'cateRes'=>$cateRes,
      ]);
    	if(request()->ispost()){
    		$data=input('post.');
      
    //	dump($data);die();
    		//dump($_FILES);die();
    		$res=db('cate')->insert($data);
    		if($res){
    			$this->success('添加课程类别成功',url('lst'));
    		}else{
    			$this->error('添加课程类别失败');
    		}
    		
    	}
        return view();
    }

  
   //课程类别列表
   public function lst(){
    $cates=model('Cate')->cateTree();
 
   	$this->assign([
   		'cates'=>$cates,
   	]);
   	return view();
   }
   
   //删除课程类别
   public function del($id){
    $cateChild=model('Cate')->getChildIds($id);
    $cateChild[]=$id;
   	$res=db('cate')->delete($cateChild);
   	if($res){
   		$this->success('删除课程类别成功',url('lst'));
   	}else{
   		$this->error('删除课程类别失败');
   	}
   }
   //课程类别信息修改
   public function edit($id){
    //找到要修改的那条记录 把内容显示出来
   	$cates=db('cate')->find($id);
    //为了实现分类效果 调用了Cate模型中的cateTree()方法
    $cateRes=model('Cate')->cateTree();
    //获取当前id及其子id的数组 为了设置不可选中效果
    $cateChild=model('Cate')->getChildIds($id);
    $cateChild[]=$id;
    $this->assign([
    	'cates' => $cates,
      'cateRes'=>$cateRes,
      'cateChild'=>$cateChild,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    	//dump($data);die();
    		//dump($_FILES);die();
    		$res=db('cate')->update($data);
    		if($res){
    			$this->success('课程类别信息修改成功',url('lst'));
    		}else{
    			$this->error('课程类别信息修改失败');
    		}
    		
    	}
   	return view();
   }
}
