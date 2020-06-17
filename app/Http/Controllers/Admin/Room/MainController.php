<?php

namespace App\Http\Controllers\Admin\Room;

use App\Http\Controllers\Controller;
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
        $this->data['user_client'] = UserClient::all();

        return view('admin.pc.room.room_list',$this->data);
    }

    public function getSave() {
        return view('admin.room.room_save');
    }

    public function getView() {
        return view('admin.room.room_view');
    }
}
