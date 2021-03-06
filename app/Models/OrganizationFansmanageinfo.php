<?php
/**
 * module_node表的模型
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationFansmanageinfo extends Model
{
    use SoftDeletes;
    protected $table = 'organization_fansmanageinfo';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $dateFormat = 'U';//设置保存的created_at updated_at为时间戳格式
    protected $guarded = [];

    //和organization表一对一的关系
    public function Organization()
    {
        return $this->belongsto('App\Models\Organization', 'fansmanage_id', 'id');//by tang, hasone -->belongsto
    }

    //添加数据
    public static function addOrganizationFansmanageinfo($param)
    {
        $program = new OrganizationFansmanageinfo();//实例化程序模型
        $program->fansmanage_id = $param['fansmanage_id'];//组织id
        $program->fansmanage_owner = $param['fansmanage_owner'];//商户负责人姓名
        $program->fansmanage_owner_idcard = $param['fansmanage_owner_idcard'];//商户负责人身份证
        $program->fansmanage_owner_mobile = $param['fansmanage_owner_mobile'];//商户负责人手机号
        $program->save();
        return $program->id;
    }

    //修改数据
    public static function editOrganizationFansmanageinfo($where, $param)
    {
        $model = self::where($where)->first();
        foreach ($param as $key => $val) {
            $model->$key = $val;
        }
        $model->save();
    }

    //获取单行数据的其中一列
    public static function getPluck($where, $pluck)
    {
        return self::where($where)->value($pluck);
    }

    /**
     * 添加数据
     * @param $param
     * @param $type
     * @param $where
     * @return bool
     */
    public static function insertData($param, $type = "update_create", $where = [])
    {
        switch ($type) {
            case "update_create":
                $res = self::updateOrCreate($where, $param);
                break;
            case "first_create":
                $res = self::firstOrCreate($param);
                break;
        }

        if (!empty($res)) {
            return $res->toArray();
        } else {
            return false;
        }
    }
}
