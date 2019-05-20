<?php
namespace app\admin\model;
use think\Model;
class Order extends Model
{
    public function PubOrder(){
        return $this->hasOne('PubOrder','order_id','id');//解释 我 有一个 从表 名字叫PubOrder 它通过order_id这个字段(这个字段在数据库中就是一个普通的字段不必一定为主键,但是类型一定要相同) 关联了 我的 id字段
    }

    public function MonthOrder(){
        return $this->hasOne('MonthOrder','order_id','id');
    }
    public function YearOrder(){
        return $this->hasOne('YearOrder','order_id','id');
    }
    public function PriOrder(){
        return $this->hasOne('PriOrder','order_id','id');
    }
    public static function getOrder($id)
    {
        return self::with('PubOrder')->find($id);//必须通过数据库中设定的主键进行查找
    }
   
}