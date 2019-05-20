<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Coach as CoachModel;
use app\admin\model\Cate as CateModel;
class Coach extends Controller
{
	//添加教练
    public function add()
    {
      //找到课程类别中的大类
      $cateRes=db('cate')->where('pid',0)->field(['id','cate_name'])->select();
      $this->assign([
        'cateRes'=>$cateRes,
      ]);
     // dump($cateRes);die();
    	if(request()->ispost()){
    		$data=input('post.');
        $data['co_num']='C'.time();
    		$data['addtime']=time();
    //	dump($data);die();
    		//dump($_FILES);die();
    		if($_FILES['co_pic']['tmp_name']){
    		           $data['co_pic']=$this->upload();
    		       }
    		$res=db('coach')->insert($data);
    		if($res){
    			$this->success('添加教练成功',url('lst'));
    		}else{
    			$this->error('添加教练失败');
    		}
    		
    	}
        return view();
    }

     //图片上传
   public function upload(){
       // 获取表单上传文件 例如上传了001.jpg
       $file = request()->file('co_pic');
       
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
   //教练列表
   public function lst(){
   	$coachs=db('coach')->paginate(5);
   	$this->assign([
   		'coachs'=>$coachs,
   	]);
   	return view();
   }
   //教练详情页
   public function content($id){
    $content=db('coach')->find($id);
    // $coachs=new CoachModel();
    // $coachs->getCateNumById
   // $list = CoachModel::hasWhere('Cate',['id'=>1])->select();//找到了从表中 主表 id=1 对应的所有教练
   // 找从表中 cate_id=1这个类的类名
  //  $cateRes=CateModel::hasWhere('Coach',['cate_id'=>$content['cate_id']])->select();//从CateModel 的id中找  与Coach中 cate_id 相等的值
     $cateRes=CateModel::where('id','=',$content['cate_id'])->select();//这里直接就是从cate表中找id 等于 cate_id 的那个记录就可以
   // dump($cateRes);die();
    $this->assign([
    	'content' => $content,
      'cateRes'=>$cateRes[0],
    ]);
   	return view();
   }
   //删除教练
   public function del($id){
    $coachs=db('coach')->where('id',$id)->field('co_pic')->select();
    $coachSrc=IMG_UPLOADS.$coachs[0]['co_pic'];
    if(file_exists($coachSrc)){
      @unlink($coachSrc);
    }
   	$res=db('coach')->delete($id);
   	if($res){
   		$this->success('删除教练成功',url('lst'));
   	}else{
   		$this->error('删除教练失败');
   	}
   }
   //教练信息修改
   public function edit($id){
   	$content=db('coach')->find($id);//find()返回的是一个数组
 //   $coachs=$content->field('co_pic');
   // dump($content['co_pic']);die();
   
    $this->assign([
    	'content' => $content,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    	//dump($data);die();
    		//dump($_FILES);die();
        $coachSrc=IMG_UPLOADS.$content['co_pic'];
        if(file_exists($coachSrc)){
          @unlink($coachSrc);
        }//
    		if($_FILES['co_pic']['tmp_name']){
    		           $data['co_pic']=$this->upload();
    		       }

    		$res=db('coach')->update($data);
    		if($res){
    			$this->success('教练信息修改成功',url('lst'));
    		}else{
    			$this->error('教练信息修改失败');
    		}
    		
    	}
   	return view();
   }
}
