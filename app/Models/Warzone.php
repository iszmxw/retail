<?php
/**
 * program表的模型
 *
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Warzone extends Model{
    use SoftDeletes;
    protected $table = 'warzone';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $dateFormat = 'U';//设置保存的created_at updated_at为时间戳格式

    //和proxyappy表一对多的关系
    public function proxyapply(){
        return $this->hasMany('App\Models\ProxyApply', 'zone_id');
    }
    //和WarzoneProxy表一对多的关系
    public function warzoneProxy(){
        return $this->hasMany('App\Models\WarzoneProxy', 'zone_id');
    }

    //和战区表一对一的关系
    public function warzoneprovince(){
        return $this->belongsTo('App\Models\WarzoneProvince', 'zone_id');
    }

    //获取单行数据的其中一列
    public static function getPluck($where,$pluck){
        return self::where($where)->pluck($pluck);
    }




    /*
     * New
     */
    //和战区节点关联，多对多
    public function province()
    {
        return $this->belongsToMany('App\Models\Province','warzone_province','zone_id','province_id');
    }

    //获取战区分页列表
    public static function getPaginage($where,$paginate,$orderby,$sort='DESC'){
        return self::with('province')->where($where)->orderBy($orderby,$sort)->paginate($paginate);
    }

}
?>