<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Order as OrderModel;//将模型类引入 因为名字冲突 用as起一个别名
use app\admin\model\PubOrder as PubOrderModel;//将模型类引入 因为名字冲突 用as起一个别名
use app\admin\model\MonthOrder as MonthOrderModel;//将模型类引入 因为名字冲突 用as起一个别名
use app\admin\model\YearOrder as YearOrderModel;//将模型类引入 因为名字冲突 用as起一个别名
use app\admin\model\PriOrder as PriOrderModel;//将模型类引入 因为名字冲突 用as起一个别名

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
	//添加健身卡
    public function add(){
 

      //获取健身卡分类并分配
    	$this->getCardType();
      //获取用户编号和信息
      $members=db('member')->field(['id','mem_num','mem_name'])->select();
      //获取私教课信息  只有私教课的信息才能被找出
      $courses=db('course')->where(['kc_type'=>1])->select();
      $this->assign([
        'members'=>$members,
        'courses'=>$courses,
      ]);
      if(request()->ispost()){
        $data=input('post.');//前端提交的订单数据
      
       $order=new OrderModel;
       $order->order_time=time();
       $order->order_num='O'.time();
       $order->card_type=$data['card_type'];
       $order->mem_id=$data['mem_id'];
       if($data['order_times']!=null){
           $porder=new PubOrderModel;
           $porder->order_times=$data['order_times'];
           $order->pubOrder=$porder;
           $res= $order->together('pubOrder')->save();//之前疑惑的一点就是 主表中的主键是自增的 害怕在插入时外键不能同时得到主键的值 可见是多虑了 使用together()方法 外键也同时被写入
         }else if($data['order_months']!=null){
          $morder=new MonthOrderModel;
          $morder->order_months=$data['order_months'];
          $month=intval($data['order_months']);
          $morder->order_deadline=strtotime("+$month month",time());
          $order->monthOrder=$morder;
          $res= $order->together('monthOrder')->save();
         }else if($data['order_years']!=null){
          $morder=new YearOrderModel;
          $morder->order_years=$data['order_years'];
          $year=intval($data['order_years']);
          $morder->order_deadline=strtotime("+$year year",time());
          $order->yearOrder=$morder;
          $res= $order->together('yearOrder')->save();
         }else if($data['order_lessons']!=null){
          $morder=new PriOrderModel;
          $morder->order_lessons=$data['order_lessons'];
          $morder->order_course_id=$data['course_id'];
          $order->priOrder=$morder;
          $res= $order->together('priOrder')->save();
         }

        if($res){
          $this->success('订单信息添加成功',url('lst'));
        }else{
          $this->error('订单信息添加失败');
        }
       
      }

       return view();
    }


   //订单列表
   public function lst(){
   //获取所有订单的公有内容 并进行分页展示
   	$orders=db('order')->paginate(5);
    //获取用户的信息 根据订单中记录的用户id去显示用户的信息
    $members=db('member')->field(['id','mem_num','mem_name'])->select();
    static $memArr=[];
    foreach ($members as $k => $v) {
      $memArr[$v['id']][0]=$v['mem_num'];
      $memArr[$v['id']][1]=$v['mem_name'];
    }
  
    //dump($orders[0]['mem_id']);die();
    //dump($memArr);die();
   	$this->assign([
   		'orders'=>$orders,
      'memArr'=>$memArr,
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

   public function content($id,$type){
    $orderRes=db('order')->find($id);
    if($type=='次卡'){
        $pubRes=db('pub_order')->where('order_id','=',$id)->select();
      //做差 计算剩余次数 where 返回来的是记录的数组 因为只有一条记录就后边[0]
        $pubRes[0]['order_bala']=$pubRes[0]['order_times']-$pubRes[0]['order_use'];
        
        // dump($data);die();
      }else if($type=='月卡'){
         $pubRes=db('month_order')->where('order_id','=',$id)->select();//找月卡订单中的信息
         $pubRes[0]['current_time']=time();
      }else if($type=='年卡'){
         $pubRes=db('year_order')->where('order_id','=',$id)->select();//找月卡订单中的信息
         $pubRes[0]['current_time']=time();
       //  dump(date("Y-m-d",$pubRes[0]['order_deadline']));die();
      }else if($type=='私教卡'){
        $pubRes=db('pri_order')->where('order_id','=',$id)->select();
        $courseRes=db('course')->field('kc_title')->find($pubRes[0]['order_course_id']);
        $pubRes[0]['order_course']=$courseRes['kc_title'];
     //   dump($pubRes[0]['order_course']);die();
      //做差 计算剩余次数 where 返回来的是记录的数组 因为只有一条记录就后边[0]
        $pubRes[0]['order_bala']=$pubRes[0]['order_lessons']-$pubRes[0]['order_used'];
        
        // dump($data);die();
      }
    $data=json_encode($pubRes[0]);
    $this->assign([
      'orderRes'=>$orderRes,
      'data'=>$data,
    ]);
   // dump($pubRes);die();
     return view();
   }
}
