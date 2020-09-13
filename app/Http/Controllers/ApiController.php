<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\UserClient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data;
    protected $code;

    public function __construct(Request $request) {
        $fp = fopen("../logs/book_".date("Ymd").".txt","a+");
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

        /** ******************************************************************************************************** **/
        /** ** default Config ************************************************************************************** **/
        $this->code[101] = "토큰에러";
        $this->code[102] = "코드102";
        $this->code[103] = "코드103";
        $this->code[104] = "코드104";
        $this->code[105] = "코드105";
        $this->code[106] = "코드106";
        $this->code[200] = "Success";

        $this->data['code'] = 200;
        $token = $request->input("key",null);
        if($token==null) $token = $request->input("token");

        if(!isset($token)){
            $this->data['code'] = 101;
        }
        else {
            $this->data['client'] = UserClient::where('api_token',$token)->first();
        }
    }


    static public function array_to_object(array $array) {
        foreach($array as $key => $value) {
            if(is_array($value))
                $array[$key] = self::array_to_object($value);
        }

        return (object)$array;
    }
}
