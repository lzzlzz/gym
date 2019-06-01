<?php
namespace app\admin\controller;
use think\Controller;
class Bulletin extends Controller
{
  
	//添加公告
    public function add()
    {
      
    
    	if(request()->ispost()){

    		$data=input('post.');
          
    		$data['bu_addtime']=time();
    	 //  dump($data);die();
    	
    		if($_FILES['bu_pic']['tmp_name']){
    		           $data['bu_pic']=$this->upload();
    		       }
    		$res=db('bulletin')->insert($data);
    		if($res){
    			$this->success('公告添加成功',url('lst'));
    		}else{
    			$this->error('公告添加失败');
    		}
    		
    	}
        return view();
    }

     //图片上传
   public function upload(){
       // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('bu_pic');
       
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
   //公告列表
   public function lst(){
   
   
   	$bulletin=db('bulletin')->paginate(5);
   
   	$this->assign([
   		'bulletin'=>$bulletin,
    
   	]);
   	return view();
   }
 
   //删除公告
   public function del($id){
   	$res=db('bulletin')->delete($id);
   	if($res){
   		$this->success('公告删除成功',url('lst'));
   	}else{
   		$this->error('公告删除失败');
   	}
   }
   //公告信息修改
   public function edit($id){
    //调用函数获取健身卡类型
     
   	$bulletin=db('bulletin')->find($id);
    $this->assign([
    	'bulletin' => $bulletin,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    
    		if($_FILES['bu_pic']['tmp_name']){
    		           $data['bu_pic']=$this->upload();
    		       }
              // dump($data);die();
    		$res=db('bulletin')->update($data);
    		if($res){
    			$this->success('公告信息修改成功',url('lst'));
    		}else{
    			$this->error('公告信息修改失败');
    		}
    		
    	}
   	return view();
   }
 
 }

