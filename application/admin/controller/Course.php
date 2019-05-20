<?php
namespace app\admin\controller;
use think\Controller;
class Course extends Controller
{


 
	//添加课程
    public function add(){
      //获取课程分类
      $cateRes=model('Cate')->cateTree();

      //禁止在父级节点添加文章
      $pids=db('cate')->field(array('pid'))->select();
      static $arr=[];//创建静态数组
      foreach ($pids as $key => $value) {//将数组中数组中的数据放到一个数组中
          $arr[]=$value['pid'];
      }
      $pids=array_unique($arr);//过滤数组中重复数据


      //获得所有教练
      $coachRes=db('coach')->field(['id','co_num','co_name','cate_id'])->select();
     // dump($cateRes);die();
      $this->assign([
        'cateRes'=>$cateRes,
        'coachRes'=>$coachRes,
        'pids'=>$pids,
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
    //获取课程分类 因为课程表中只是存了分类的id 现在想根据课程表中存的分类id从 分类表中找到 这个分类的名称
    $cateRes=db('cate')->where('pid','<>',0)->field(['id','cate_name'])->select();//获取分类表中非一级分类的id和其姓名 因为课程只能在二级分类下添加 
    static $cateTitle=[];//通过循环 将id与其对应的姓名作为键值对存放到一个数组中
    foreach ($cateRes as $k => $v) {//处理返回的结果
      $cateTitle[$v['id']]=$v['cate_name'];
    }

    //如法炮制 我们现在要根据课程表中的教练id去找教练的姓名 做法与找分类的方法是一样的
    $coachRes=db('coach')->field(['id','co_name'])->select();
    static $coachName=[];//通过循环 将id与其对应的姓名作为键值对存放到一个数组中
    foreach ($coachRes as $k => $v) {//处理返回的结果
      $coachName[$v['id']]=$v['co_name'];
    }
    //dump($coachName);die();
   	$courses=db('course')->paginate(5);
   	$this->assign([
   		'courses'=>$courses,
      'cateTitle'=>$cateTitle,
      'coachName'=>$coachName,
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
    $cateRes=model('Cate')->cateTree();

   //禁止在父级节点添加文章
    $pids=db('cate')->field(array('pid'))->select();
    static $arr=[];//创建静态数组
    foreach ($pids as $key => $value) {//将数组中数组中的数据放到一个数组中
        $arr[]=$value['pid'];
    }
    $pids=array_unique($arr);//过滤数组中重复数据


   //获得所有教练
      $coachRes=db('coach')->field(['id','co_num','co_name','cate_id'])->select();
  // dump($courseRes);die();
   	$content=db('course')->find($id);
    $this->assign([
    	'content' => $content,
      'cateRes'=>$cateRes,
      'coachRes'=>$coachRes,
      'pids'=>$pids,

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
