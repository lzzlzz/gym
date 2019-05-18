<?php
namespace app\admin\controller;
use think\Controller;
class Card extends Controller
{
	//添加健身卡
    public function add(){
      //获取健身卡分类
    	if(request()->ispost()){
    		$data=input('post.');
        $data['cd_num']='A'.time();
    		$res=db('card')->insert($data);
    		if($res){
    			$this->success('添加健身卡成功',url('lst'));
    		}else{
    			$this->error('添加健身卡失败');
    		}
    		
    	}
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
