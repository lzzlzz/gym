<?php
namespace app\admin\model;
use think\Model;
class PriOrder extends Model
{
   public function Order(){
    return $this->belongsTo('Order','order_id','id');
   }

   public static function getOrderNumById($id){
    return self::with('Order')->find($id);
   }
}