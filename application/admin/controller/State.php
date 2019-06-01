<?php
namespace app\admin\controller;
use think\Controller;
class State extends Controller
{
  
	//添加动态
    public function add()
    {
      
    
    	if(request()->ispost()){

    		$data=input('post.');
          
    		$data['st_addtime']=time();
    	 //  dump($data);die();
    	
    		if($_FILES['st_pic']['tmp_name']){
    		           $data['st_pic']=$this->upload();
    		       }
    		$res=db('state')->insert($data);
    		if($res){
    			$this->success('动态添加成功',url('lst'));
    		}else{
    			$this->error('动态添加失败');
    		}
    		
    	}
        return view();
    }

     //图片上传
   public function upload(){
       // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('st_pic');
       
       // 移动到框架应用根目录/public/uploads/ 目录下
       if($file){
           $info = $file->move(ROOT_PATH . 'public' . DS .'static'. DS . 'uploads');
           if($info){
               // 成功上传后 获取上传信息
               // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
               return $info->getSaveName();
           }else{
               // 上传失败获取错误信息
               echo $file->getError();
               die();
           }
       }
   }
   //动态列表
   public function lst(){
   
   
   	$state=db('state')->paginate(5);
   
   	$this->assign([
   		'state'=>$state,
    
   	]);
   	return view();
   }
 
   //删除动态
   public function del($id){
   	$res=db('state')->delete($id);
   	if($res){
   		$this->success('动态删除成功',url('lst'));
   	}else{
   		$this->error('动态删除失败');
   	}
   }
   //动态信息修改
   public function edit($id){
    //调用函数获取健身卡类型
     
   	$state=db('state')->find($id);
    $this->assign([
    	'state' => $state,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    	
    		if($_FILES['st_pic']['tmp_name']){
    		           $data['st_pic']=$this->upload();
    		       }
    		$res=db('state')->update($data);
    		if($res){
    			$this->success('动态信息修改成功',url('lst'));
    		}else{
    			$this->error('动态信息修改失败');
    		}
    		
    	}
   	return view();
   }
 
 }

