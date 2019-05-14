<?php
namespace app\admin\controller;
use think\Controller;
class Member extends Controller
{
	//添加用户
    public function add()
    {
    	if(request()->ispost()){
    		$data=input('post.');
        $data['mem_num']='Y'.time();
    		$data['addtime']=time();
    	//	dump($data);die();
    		//dump($_FILES);die();
    		if($_FILES['mem_pic']['tmp_name']){
    		           $data['mem_pic']=$this->upload();
    		       }
    		$res=db('member')->insert($data);
    		if($res){
    			$this->success('用户添加成功',url('lst'));
    		}else{
    			$this->error('用户添加失败');
    		}
    		
    	}
        return view();
    }

     //图片上传
   public function upload(){
       // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('mem_pic');
       
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
   //用户列表
   public function lst(){
   	$members=db('member')->paginate(2);
   	$this->assign([
   		'members'=>$members,
   	]);
   	return view();
   }
   //用户详情页
   public function content($id){
    $content=db('member')->find($id);
    $this->assign([
    	'content' => $content,
    ]);
   	return view();
   }
   //删除用户
   public function del($id){
   	$res=db('member')->delete($id);
   	if($res){
   		$this->success('用户删除成功',url('lst'));
   	}else{
   		$this->error('用户删除失败');
   	}
   }
   //用户信息修改
   public function edit($id){
   	$content=db('member')->find($id);
    $this->assign([
    	'content' => $content,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    	//	dump($data);die();
    		//dump($_FILES);die();
    		if($_FILES['mem_pic']['tmp_name']){
    		           $data['mem_pic']=$this->upload();
    		       }
    		$res=db('member')->update($data);
    		if($res){
    			$this->success('用户信息修改成功',url('lst'));
    		}else{
    			$this->error('用户信息修改失败');
    		}
    		
    	}
   	return view();
   }
}
