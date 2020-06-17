<!-- <link rel="stylesheet" href="http://api.einet.co.kr/asset/blade.css"> -->

<div class="row fl between-32" style="width:48%; min-width:460px">
    <div class="" >
        <div class="card-body">
            <div class="table-a noto">
                <div class="table-a__head clb">
                    <h5 class="table-a__tit fl">Client List</h5>
                    <div class="table-a__inbox type-head fr">
                        <button class="btn-v1" onclick="goUrl('{{ isset($staffList_user_id)&&($staffList_user_id>0) ? route('etc.room_insert',['user_id'=>$staffList_user_id]) : route('etc.room_insert')}}');">룸타입등록</button>
                        <button class="btn-v2 ml_10" onclick="goUrl('{{ isset($staffList_user_id)&&($staffList_user_id>0) ? route('client') : route('etc.room')}}');">뒤로가기</button>
                    </div>
                </div>

                <table class="table-a__table">
                    <colgroup>
                        <col width="11%">
                        <col width="37%">
                        <col width="18%">
                        <col width="15%">
                        <col width="19%">
                    </colgroup>
                    <tr class="table-a__tr type-th">
                        <th class="table-a__th">번호</th>
                        <th class="table-a__th">그룹명</th>
                        <th class="table-a__th">판매객실수</th>
                        <th class="table-a__th">기준/최대</th>
                        <th class="table-a__th">객실정보</th>
                    </tr>
                    @foreach($clientList as $k => $c)
                    <tr>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $clientList->total()-$k }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $c->type_name }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $c->num }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $c->room_cnt_basic }}/{{ $c->room_cnt_max }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <button type="button" class="table-a__btn type-info btn-v2" onclick="goUrl('{{ isset($staffList_user_id) && ($staffList_user_id>0) ? route('etc.room_insert',['type_id'=>$c->id,'user_id'=>$staffList_user_id]) : route('etc.room_insert',['type_id'=>$c->id])}}');">객실 정보</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
