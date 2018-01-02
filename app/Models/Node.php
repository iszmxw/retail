<?php
/**
 * node表的模型
 *
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Node extends Model{
    protected $table = 'node';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $dateFormat = 'U';//设置保存的created_at updated_at为时间戳格式

    //和功能模块关联，多对多
    public function modules()
    {
        return $this->belongsToMany('App\Models\Module','module_node','node_id','module_id');
    }

    //和功能模块关联，多对多
    public function program_modules()
    {
        return $this->belongsToMany('App\Models\Module','program_module_node','node_id','module_id');
    }

    //和程序的关联，多对多
    public function programs()
    {
        return $this->belongsToMany('App\Models\Program','program_module_node','node_id','program_id');
    }

    //获取总数
    public static function getCount($where=[]){
        return self::where($where)->where('is_delete','0')->count();
    }

    //查询获取列表
    public static function getList($where,$limit=0,$orderby,$sort='DESC'){
        $model = self::where($where)->where('is_delete','0')->orderBy($orderby,$sort);
        if(!empty($limit)){
            $model = $model->limit($limit);
        }
        return $model->get();
    }

    //添加节点
    public static function addNode($param){
        $node = new Node();//重新实例化模型，避免重复
        if(!empty($param['node_name'])) {
            $node->node_name = $param['node_name'];//节点名称
        }
        if(!empty($param['route_name'])) {
            $node->route_name = $param['route_name'];//路由名称
        }
        $node->save();//添加账号
    }

    //修改数据
    public static function editNode($where,$param){
        $model = self::where($where)->first();
        foreach($param as $key=>$val){
            $model->$key=$val;
        }
        $model->save();
    }

    //查询数据是否存在（仅仅查询ID增加数据查询速度）
    public static function checkRowExists($where){
        $row = self::getPluck($where,'id')->toArray();
        if(empty($row)){
            return false;
        }else{
            return true;
        }
    }
    //获取单行数据的其中一列
    public static function getPluck($where,$pluck){
        return self::where($where)->where('is_delete','0')->pluck($pluck);
    }
    //获取分页数据
    public static function getPaginage($where,$paginate,$orderby,$sort='DESC'){
        return self::where($where)->where('is_delete','0')->orderBy($orderby,$sort)->paginate($paginate);
    }

    //查询已被某个模块选中的节点
    public static function node_selected($module_id){
        return Node::whereIn('id',function($query) use ($module_id){
            $query->select('node_id')->from('module_node')->where('module_id',$module_id)->get();
        })->get();
    }

    //查询未被摸个模块选中的节点
    public static function node_unselected($module_id){
        return Node::whereNotIn('id',function($query) use ($module_id){
            $query->select('node_id')->from('module_node')->where('module_id',$module_id)->get();
        })->get();
    }

    //彻底删除节点
    public static function removeNode($where){
        return self::where($where)->delete();
    }
}
?>