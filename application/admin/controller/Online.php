<?php
namespace app\admin\controller;
use think\Controller;
class Online extends Controller
{
  
	//添加网课
    public function add()
    {
      
    
    	if(request()->ispost()){

    		$data=input('post.');
          
    		$data['ol_addtime']=time();
    	 //  dump($data);die();
    	
    		if($_FILES['ol_pic']['tmp_name']){
    		           $data['ol_pic']=$this->upload();
    		       }
    		$res=db('online')->insert($data);
    		if($res){
    			$this->success('网课添加成功',url('lst'));
    		}else{
    			$this->error('网课添加失败');
    		}
    		
    	}
        return view();
    }

     //图片上传
   public function upload(){
       // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('ol_pic');
       
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
   //网课列表
   public function lst(){
   
   
   	$online=db('online')->paginate(5);
   
   	$this->assign([
   		'online'=>$online,
    
   	]);
   	return view();
   }
 
   //删除网课
   public function del($id){
   	$res=db('online')->delete($id);
   	if($res){
   		$this->success('网课删除成功',url('lst'));
   	}else{
   		$this->error('网课删除失败');
   	}
   }
   //网课信息修改
   public function edit($id){
    //调用函数获取健身卡类型
     
   	$online=db('online')->find($id);
    $this->assign([
    	'online' => $online,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    
    		if($_FILES['ol_pic']['tmp_name']){
    		           $data['ol_pic']=$this->upload();
    		       }
              // dump($data);die();
    		$res=db('online')->update($data);
    		if($res){
    			$this->success('网课信息修改成功',url('lst'));
    		}else{
    			$this->error('网课信息修改失败');
    		}
    		
    	}
   	return view();
   }
 
 }

