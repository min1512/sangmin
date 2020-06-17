<?php

namespace App\Http\Controllers\Api\Payment\Nice;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class NiceLog extends ApiController
{
    public $handle;
    public $type;
    public $log;
    public $debug_mode;
    public	$array_key;
    public $debug_msg;
    public $starttime;

    public function __construct($log, $mode, $type ) {
        $this->debug_msg = array( "", "CRITICAL", "ERROR", "NOTICE", "4", "INFO", "6", "DEBUG", "8"  );
        $this->debug_mode = $mode;
        $this->type = $type;
        $this->log = $log;
        $this->starttime= $this->GetMicroTime();
    }

    public function StartLog($dir, $mid) {
        if( $this->log == "false" ) return true;

        $logfile = $dir. "/".PROGRAM."_".$this->type."_".$mid."_".date("ymd").".log";
        $this->handle = fopen( $logfile, "a+" );
        if( !$this->handle )
        {
            return false;
        }

        $this->WriteLog("START ".PROGRAM." ".$this->type." (V".VERSION."B".BUILDDATE."(OS:".php_uname('s').php_uname('r').",PHP:".phpversion()."))" );
        return true;
    }

    public function CloseNiceLog($msg){
        $laptime=$this->GetMicroTime()-$this->starttime;
        $this->WriteLog( "END ".$this->type." ".$msg ." Laptime:[".round($laptime,3)."sec]" );
        $this->WriteLog("===============================================================" );
        fclose( $this->handle );
    }

    public function WriteLog($data) {
        if( !$this->handle || $this->log == "false" ) return;
        $pfx = " [" . date("Y-m-d H:i:s") . "] <" . getmypid() . "> ";
        fwrite( $this->handle, $pfx . $data . "\r\n" );

    }

    public function GetMicroTime() {
        list($usec, $sec) = explode(" ", microtime());
        return (float)$usec + (float)$sec;
    }

    public function SetTimestamp() {
        $m = explode(' ',microtime());
        list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0]*1000,3));
        return date("Y-m-d H:i:s", $totalSeconds) . ":$extraMilliseconds";
    }

    public function SetTimestamp1() {
        $m = explode(' ',microtime());
        list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0]*10000,4));
        return date("ymdHis", $totalSeconds) . "$extraMilliseconds";
    }

}
