<?php
namespace app\admin\controller;
use think\Controller;
class Member extends Controller
{
  //获取会员卡类型
  public function getCardType(){
       //获取会员卡类型
       $cardType=db('card')->field('cd_name')->select();
    //  dump($cardType);die();
      // $cardType=array_unique($cardType);
      //将获取数据拿到一个数组$arr中
      static $arr=[];
      foreach ($cardType as $k => $v) {
        $arr[]=$v['cd_name'];
      }
       $this->assign([
         'cardType'=> array_unique($arr),//把数组中重复的值去重 返回到前台
       ]);
  }
	//添加用户
    public function add()
    {
      //调用函数获取健身卡类型
      $this->getCardType();
    	if(request()->ispost()){

    		$data=input('post.');
          
        $data['mem_type']=substr($data['mem_type'], 0,-6);//只取会员的类型 删掉会员两个字
          //dump($data['mem_type']);die();
        $data['mem_num']='Y'.time();
    		$data['addtime']=time();
    	dump($data);die();
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
    //调用函数获取健身卡类型
    
    $this->getCardType();
   	$members=db('member')->paginate(5);
    $selectedType[0]='全部';//当为列表功能时就是显示全部
   	$this->assign([
   		'members'=>$members,
      'selectedType'=> $selectedType,//让前端的分类等于 全部
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
    //调用函数获取健身卡类型
      $this->getCardType();
   	$content=db('member')->find($id);
    $this->assign([
    	'content' => $content,
    ]);
    if(request()->ispost()){
    		$data=input('post.');
    	//	dump($data);die();
    		//dump($_FILES);die();
         $data['mem_type']=substr($data['mem_type'], 0,-6);//只取会员的类型 删掉会员两个字
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
   //按类型的不同显示会员
   public function selectType(){
     $this->getCardType();
     if(request()->isGet()){
       $data=input('get.');
       $typeStr=substr($data['cardType'], 0,-6);//只取会员的类型
       if($typeStr!='全部'){
        $typeRes=db("member")->where('mem_type',$typeStr)->paginate(2,false,['query'=>request()->param()]);//将特定类型的查询结果返回 并分页显示 为了再每一页中都能有会员类型 用query参数将查询的get参数也带上 实现对查询结果的分页
         // $typeRes=db('member')->where('mem_type',$typeStr)->paginate(2);
       }else{
        $typeRes=db('member')->paginate(5,false,['query'=>request()->param()]);
       }
       $selectedType[0]=$typeStr;//将查询的类型传到前端
       $this->assign([
        'members'=>$typeRes,
        'selectedType'=> $selectedType,//被查询的类型
       ]);
      // dump($selectedType);die();
       return view('lst');
     }
   }
}
