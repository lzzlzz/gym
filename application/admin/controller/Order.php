<?php
namespace app\admin\controller;
use think\Controller;
class Order extends Controller
{
  //获取会员卡类型
  public function getCardType(){
       //获取会员卡类型的名称
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
  public function qw($arr){
    dump($arr);die();
  }
	//添加健身卡
    public function add(){
      //获取健身卡分类
    	$this->getCardType();
      $members=db('member')->field(['mem_num','mem_name'])->select();
      //$this->qw($members);
      $this->assign([
        'members'=>$members,
      ]);
        return view();
    }


   //健身卡列表
   public function lst(){
   
   	$cards=db('card')->paginate(5);
   	$this->assign([
   		'cards'=>$cards,
   	]);
   	return view();
   }
 
   //删除健身卡
   public function del($id){
   	$res=db('card')->delete($id);
   	if($res){
   		$this->success('删除健身卡成功',url('lst'));
   	}else{
   		$this->error('删除健身卡失败');
   	}
   }
   //健身卡信息修改
   public function edit($id){
    //获取id值为$id的健身卡信息
    $cardRes=db('card')->find($id);
  // dump($cardRes);die();
    $this->assign([
      'cardRes'=>$cardRes,
    ]);
  //  dump($cardRes);die();
    if(request()->ispost()){
    		$data=input('post.');
    	//dump($data);die();
    		//dump($_FILES);die();
    		$res=db('card')->update($data);
    		if($res){
    			$this->success('健身卡信息修改成功',url('lst'));
    		}else{
    			$this->error('健身卡信息修改失败');
    		}
    		
    	}
   	return view();
   }
}
