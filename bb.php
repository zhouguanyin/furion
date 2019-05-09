<?php
namespace app\admin\controller;

use think\Controller;
use think\View;
use think\Config;
use think\Cache;
use think\Db;
use think\Paginator;
use think\Request;
use app\admin\model\ExchangeRecord  as ExchangeRecordModel;

/**
 *活动控制器
 *
 * @author      furion<752254253@qq.com>
 * @version     $Id$
 * @since       1.0
 */
class ExchangeRecord extends AdminBase
{
    public function __construct(){
        parent::__construct();
    }


    public function index(){
        return $this->fetch('index');
    }


    public function list(Request $request)
    {
        dd($request->session());die;
        $query = $request->get();
        $res = ExchangeRecordModel::getListByCond($query);
        $res= $res->visible(['id','goods_barcode','mobile','duihuan_time','rcode','is_huan','staff_sn','gifts'=>['goods_name','original_img'],'staff'=>['name'] ])->toArray();
        foreach ($res['data'] as $key => $value) {
            !isset($value['staff']['name']) && $res['data'][$key]['staff']['name'] = '';
        }
        $data = [
            'code'=>0,
            'msg'=>'获取礼品商品成功！',
            'tiao'=>1,
            'count'=>$res['total'],
            'data'=>$res['data']
        ];
        return json($data);
    }


    public function schedule(){
        return $this->fetch('schedule');
    }

    public function get_schedule(Request $request)
    {
        $query = $request->get();
        $res = ExchangeRecordModel::getSchedule($query);
        $res = $res->toArray();
        $data = [
            'code'=>0,
            'msg'=>'获取礼品商品成功！',
            'tiao'=>1,
            'count'=>$res['total'],
            'data'=>$res['data']['data']
        ];
        return json($data);
    }

}