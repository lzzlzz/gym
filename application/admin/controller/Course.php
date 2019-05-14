<?php
namespace app\admin\controller;
use think\Controller;
class Course extends Controller
{
	//添加课程
    public function add(){
      //获取课程分类
      $courseRes=model('Cate')->cateTree();
     // dump($courseRes);die();
      $this->assign([
        'courseRes'=>$courseRes,
      ]);
    	if(request()->ispost()){
    		$data=input('post.');
        $data['kc_num']='K'.time();
    		$res=db('course')->insert($data);
    		if($res){
    			$this->success('添加课程成功',url('lst'));
    		}else{
    			$this->error('添加课程失败');
    		}
    		
    	}
        return view();
    }

   
   //课程列表
   public function lst(){
   	$courses=db('course')->paginate(5);
   	$this->assign([
   		'courses'=>$courses,
   	]);
   	return view();
   }
   //课程详情页
   public function content($id){
    $content=db('course')->find($id);
    $this->assign([
    	'content' => $content,
    ]);
   	return view();
   }
   //删除课程
   public function del($id){
   	$res=db('course')->delete($id);
   	if($res){
   		$this->success('删除课程成功',url('lst'));
   	}else{
   		$this->error('删除课程失败');
   	}
   }
   //课程信息修改
   public function edit($id){
    //获取课程分类
    $courseRes=model('Cate')->cateTree();
  // dump($courseRes);die();
   	$content=db('course')->find($id);
    $this->assign([
    	'content' => $content,
      'courseRes'=>$courseRes,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    	//dump($data);die();
    		//dump($_FILES);die();
    		$res=db('course')->update($data);
    		if($res){
    			$this->success('课程信息修改成功',url('lst'));
    		}else{
    			$this->error('课程信息修改失败');
    		}
    		
    	}
   	return view();
   }
}
