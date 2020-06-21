<?php

namespace App\Http\Controllers\Admin\Room;

use App\Http\Controllers\Controller;
use App\Models\ClientSeason;
use App\Models\ClientType;
use App\Models\ClientTypeRoom;
use App\Models\UserAgency;
use App\Models\UserClient;
use App\Models\Users;
use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getList() {
        $this->data['user_client'] = UserClient::leftJoin("user_agency","user_agency.user_id","=","user_client.agency_id")
            ->selectraw('user_client.*, user_agency.agency_name, (select group_concat(season_name separator ",") from client_season where user_id in (0,user_client.user_id)) as season')
            ->paginate(4);

        return view('admin.pc.room.room_list',$this->data);
    }

    public function getSave() {
        return view('admin.room.room_save');
    }

    public function getView() {
        return view('admin.room.room_view');
    }
}
