<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        $fp = fopen("../logs/".date("Ymd").".txt","a+");
        fwrite($fp, "\r\n\r\n====================================================\r\n");
        fwrite($fp, "==== ".url()->current()."\r\n");
        fwrite($fp, "==== ".date("Y-m-d H:i:s")."\r\n");
        fwrite($fp, "====================================================\r\n");
        $arrHeader = ['REMOTE_ADDR','HTTP_REFERER','HTTP_ACCEPT_LANGUAGE','HTTP_ACCEPT','HTTP_USER_AGENT','HTTP_HOST','SERVER_NAME','SERVER_PORT','REQUEST_METHOD','QUERY_STRING','HTTP_TOKEN'];
        foreach ($_SERVER as $k => $v) {
            if (in_array($k,$arrHeader)) fwrite($fp, "==== ".$k." :: ".$v."\r\n");
        }
        if ($_POST) fwrite($fp, "===============================================\r\n==== POST =====================================\r\n");
        foreach ($_POST as $k => $v) {
            fwrite($fp, "==== ".$k." :: ".json_encode($v,JSON_UNESCAPED_UNICODE)."\r\n");
        }
        if ($_GET) fwrite($fp, "================================================\r\n==== GET =======================================\r\n");
        foreach ($_GET as $k => $v) {
            fwrite($fp, "==== ".$k." :: ".json_encode($v,JSON_UNESCAPED_UNICODE)."\r\n");
        }
        fclose($fp);
    }

    static public function getCategory() {
        $category = [];
        $tmp = Code::where(['depth'=>0, 'code'=>'category_admin'])->first();
        $code1 = Code::where(['depth'=>1, 'up_id'=>$tmp->id, 'flag_use'=>'Y', 'flag_view'=>'Y'])->orderBy('order_by','asc')->get();

        foreach($code1 as $k => $c) {
            $category[$k]['depth'] = $c->depth;
            $category[$k]['up_id'] = $c->up_id;
            $category[$k]['code'] = $c->code;
            $category[$k]['name'] = $c->code_name;
            $category[$k]['icon'] = $c->desc_01;

            $code2 = Code::where(['depth' => $c->depth + 1, 'up_id' => $c->id, 'flag_use' => 'Y', 'flag_view' => 'Y'])->get();
            foreach($code2 as $k2 => $c2) {
                $category[$k]['sub'][$k2]['depth'] = $c2->depth;
                $category[$k]['sub'][$k2]['up_id'] = $c2->up_id;
                $category[$k]['sub'][$k2]['code'] = $c2->code;
                $category[$k]['sub'][$k2]['name'] = $c2->code_name;

                $code3 = Code::where(['depth'=>$c2->depth+1, 'up_id'=>$c2->id, 'flag_use'=>'Y', 'flag_view'=>'Y'])->get();

                foreach($code3 as $k3 => $c3) {
                    $category[$k]['sub'][$k2]['sub'][$k3]['depth'] = $c3->depth;
                    $category[$k]['sub'][$k2]['sub'][$k3]['up_id'] = $c3->up_id;
                    $category[$k]['sub'][$k2]['sub'][$k3]['code'] = $c3->code;
                    $category[$k]['sub'][$k2]['sub'][$k3]['name'] = $c3->code_name;
                }
            }
        }

        return $category;
    }

    static public function getCode($tcode, $depth=1) {
        $code = [];
        $tmp = Code::where(['depth'=>0, 'code'=>$tcode])->first();
        $code1 = Code::where(['depth'=>1, 'up_id'=>$tmp->id, 'flag_use'=>'Y', 'flag_view'=>'Y'])->get();

        foreach($code1 as $k => $c) {
            $code[$k]['depth'] = $c->depth;
            $code[$k]['up_id'] = $c->up_id;
            $code[$k]['code'] = $c->code;
            $code[$k]['name'] = $c->code_name;

            if($depth>1) {
                $code2 = Code::where(['depth' => $c->depth + 1, 'up_id' => $c->id, 'flag_use' => 'Y', 'flag_view' => 'Y'])->get();
                foreach ($code2 as $k2 => $c2) {
                    $code[$k]['sub'][$k2]['depth'] = $c2->depth;
                    $code[$k]['sub'][$k2]['up_id'] = $c2->up_id;
                    $code[$k]['sub'][$k2]['code'] = $c2->code;
                    $code[$k]['sub'][$k2]['name'] = $c2->code_name;

                    if($depth>2) {
                        $code3 = Code::where(['depth' => $c2->depth + 1, 'up_id' => $c2->id, 'flag_use' => 'Y', 'flag_view' => 'Y'])->get();
                        foreach ($code3 as $k3 => $c3) {
                            $code[$k]['sub'][$k2]['sub'][$k3]['depth'] = $c3->depth;
                            $code[$k]['sub'][$k2]['sub'][$k3]['up_id'] = $c3->up_id;
                            $code[$k]['sub'][$k2]['sub'][$k3]['code'] = $c3->code;
                            $code[$k]['sub'][$k2]['sub'][$k3]['name'] = $c3->code_name;
                        }
                    }
                }
            }
        }

        return self::array_to_object($code);
    }

    static public function getCodeName($code) {
        $code2 = Code::where('code',$code)->first();
        return $code2->code_name;
    }

    static public function array_to_object(array $array) {
        foreach($array as $key => $value) {
            if(is_array($value))
                $array[$key] = self::array_to_object($value);
        }

        return (object)$array;
    }
}
