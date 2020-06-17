<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientSeasonTerm extends Model
{
    protected $table = "client_season_term";

    public function ClientSeasonTerm($user_id, $data=[]) {
        $season_name = $data['season_name'];
        $season_start = $data['season_start'];
        $season_end = $data['season_end'];

        $ClientSeason = ClientSeason::where('user_id',$user_id)->where('season_name',$season_name)->first();
        if($ClientSeason==""){
            $ClientSeason = new ClientSeason();
            $ClientSeason->user_id = $user_id;
            $ClientSeason->season_name = $season_name;
        }
        $ClientSeason->save();
        $id = $ClientSeason->id;

        $tmp =[];
        foreach ($season_start as $k=>$v){
            foreach ($season_end as $e=>$t){
                if($k==$e){
                    $isset = ClientSeasonTerm::where('user_id',$user_id)->where('season_start',$v)->where('season_end',$t)->first();
                    if($isset==""){
                        $ClientSeasonTerm = new ClientSeasonTerm();
                        $ClientSeasonTerm->user_id = $user_id;
                        $ClientSeasonTerm->season_id = $id;
                    }else{
                        $ClientSeasonTerm = ClientSeasonTerm::where('user_id',$user_id)->where('season_start',$v)->where('season_end',$t)->first();
                    }
                    $ClientSeasonTerm->season_start = $v;
                    $ClientSeasonTerm->season_end = $t;
                    $ClientSeasonTerm->save();
                    $tmp[] = $ClientSeasonTerm->id;
                }
            }
        }
        ClientSeasonTerm::WhereNotIn('id',$tmp)->where('user_id',$user_id)->where('season_id',$id)->delete();
    }

}
