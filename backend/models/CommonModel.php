<?php
namespace backend\models;
use yii\base\Model;
use Yii;
use yii\db\Query;
/**
 * 公用的增删改模型 所有用db对象创建的语句都需要最后调用execute()方法
 */
class CommonModel extends Model{
    static $db;//连接对象
    
    /**
     * 添加数据
     * @param type $table_name
     * @param type $data
     * @return type
     */
    protected function db(){
        //数据库连接对象只允许实例化一次
       if(!self::$db){
           self::$db = new Query();
       } 
       return self::$db;
    }
    public function addData($table_name,$data){
      return  Yii::$app->db->createCommand()->insert($table_name, $data)->execute();
    }
    /**
     * 批量插入数据
     * @param type $table
     * @param type $column
     * @param type $data
     * @return type
     */
    public function batchAddData($table,$column,$data){
       return Yii::$app->db->createCommand()->batchInsert($table, $column, $data)->execute();
    }
    /**
     * 更新数据
     * @param type $table_name
     * @param type $data
     * @param type $where
     * @return type
     */
    public function updateData($table_name,$data,$where){
        
        $res = Yii::$app->db->createCommand()->update($table_name, $data, $where)->execute();
        
        return $res;
    }
    /**
     * 删除数据
     * @param type $table_name
     * @param type $where
     * @return type
     */
    public function deleteData($table_name,$where){
        return Yii::$app->db->createCommand()->delete($table_name, $where)->execute();
    }
    /**
     * 查找单条数据
     * @param type $table_name
     * @param type $where
     * @param type $field
     * @return type
     */
    public function findOneData($table_name,$where='',$field=''){
        $db = new Query();
        $r =  $db->select($field)
                  ->from($table_name)
                  ->where($where)
                  ->one();
      // echo $db->createCommand()->getRawSql();
        return $r;
    }
    /**
     * $isCalcCount为true的时候计算总量,否则计算结果集
     * @param type $table_name
     * @param type $field
     * @param type $limit
     * @param type $offset
     * @param type $where
     * @return type
     */
    public function findAllData($table_name,$isCalcCount=true,$field='',$limit='',$offset='',$where='',$column=''){
        $db = new Query();
        $base = $db->select($field)
                   ->from($table_name)
                   ->where($where);
        $res =  $isCalcCount ? $base->count() : $base->limit($limit)
                                                    ->offset($offset)
                                                    ->orderBy($column)
                                                    ->all();
       // echo $db->createCommand()->getRawSql();
        
        return $res;        
    }
}
