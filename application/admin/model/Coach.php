<?php
namespace app\admin\model;
use think\Model;
class Coach extends Model
{
   public function Cate(){
    return $this->belongsTo('Cate','cate_id','id');//教练中的cate_id  参考分类表中 id
   }

   public static function getCateNumById($id){
    return self::with('Cate')->find($id);
   }
}