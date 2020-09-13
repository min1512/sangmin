@extends("admin.pc.layout.basic")

@section("title")룸타입목록@endsection

@section("scripts")
<script>
    $(document).ready(function(e) {
        genRowspan("gubun");
        genRowspan("gubun1");
    });

    function genRowspan(className) {
        $("." + className).each(function() {
            var rows = $("." + className + ":contains('" + $(this).text() + "')");
            if (rows.length > 1) {
                rows.eq(0).attr("rowspan", rows.length);
                rows.not(":eq(0)").remove();
            }
        });
    }

</script>
@endsection

@section("styles")
<!--
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
-->
@endsection


@section("contents")
<div class="table-a noto">
    <div class="table-a__head clb">
        <p class="table-a__tit fl">숙박업소 관리</p>
    </div>
    <table class="table-a__table">
        <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="10%">
            <col width=*>
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
        </colgroup>
        <tr class="table-a__tr type-th">
            <th class="table-a__th">번호</th>
            <th class="table-a__th">대행사</th>
            <th class="table-a__th">펜션명</th>
            <th class="table-a__th">주소지</th>
            <th class="table-a__th">연락처</th>
            <th class="table-a__th">시즌</th>
            <th class="table-a__th">예약수수료</th>
            <th class="table-a__th">카드수수료</th>
        </tr>

        @foreach($user_client as $k => $v)
        <tr class="table-a__tr">
            <td class="table-a__td" rowspan="2">
                <div class="table-a__inbox">
                    <span>{{$user_client->total()-($user_client->currentPage()-1)*$user_client->perPage()-$k}}</span>
                </div>
            </td>
            <td class="table-a__td" rowspan="2">
                <div class="table-a__inbox">
                    <span>{{$v->agency_name!=null||$v->agency_name!=""?$v->agency_name:"-"}}</span>
                </div>
            </td>
            <td class="table-a__td" rowspan="2">
                <div class="table-a__inbox">
                    <span>{{$v->client_name}}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{$v->client_addr_basic}}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{$v->client_hp}}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{$v->season}}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox ta-r">
                    <span>{{$v->client_fee_agency}}{{$v->client_fee_agency_unit}}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox ta-r">
                    <span>{{$v->client_fee_payment}}{{$v->client_fee_payment_unit}}</span>
                </div>
            </td>
        </tr>
        <tr class="table-a__tr">
            <td class="table-a__td" colspan="5">
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-home" onclick="goUrl('{{ route('user.client.save',['id'=>$v->user_id,'check'=>"check"])}}');"><span>숙박업소 관리</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-set" onclick="goUrl('{{ route('client.config',['user_id'=>$v->user_id])}}');"><span>설정</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-room" onclick="goUrl('{{ route('room.list',['user_id'=>$v->user_id])}}');"><span>객실 관리</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-roomclose" onclick="goUrl('{{ route('client.block',['id'=>$v->user_id])}}');"><span>방막기</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-roomset" onclick="goUrl('{{ route('client.over',['id'=>$v->user_id])}}');"><span>연박 설정</span></button>
                </div>
            </td>
        </tr>
        @endforeach
        <tfoot>
            <tr>
                <td colspan="13">{{ $user_client->links('admin.pc.pagination.default') }}</td>
            </tr>
        </tfoot>

    </table>




    <!--

    <table class="default" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td>구분</td>
            <td>대행사</td>
            <td>펜션명</td>
            <td>주소지</td>
            <td>연락처</td>
            <td>시즌</td>
            <td>예약수수료</td>
            <td>카드수수료</td>
            <td colspan="5">관리</td>
        </tr>
        </thead>
        <tbody>
        @foreach($user_client as $k => $v)
            <tr>
                <td>{{$user_client->total()-($user_client->currentPage()-1)*$user_client->perPage()-$k}}</td>
                <td>{{$v->agency_name!=null||$v->agency_name!=""?$v->agency_name:"-"}}</td>
                <td>{{$v->client_name}}</td>
                <td>{{$v->client_addr_basic}}</td>
                <td>{{$v->client_hp}}</td>
                <td>{{$v->season}}</td>
                <td>{{$v->client_fee_agency}}{{$v->client_fee_agency_unit}}</td>
                <td>{{$v->client_fee_payment}}{{$v->client_fee_payment_unit}}</td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('user.client.save',['id'=>$v->user_id,'check'=>"check"])}}');">숙박업소 관리</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('client.config',['user_id'=>$v->user_id])}}');">설정</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('room.list',['user_id'=>$v->user_id])}}');">객실 관리</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('client.block',['id'=>$v->user_id])}}');">방막기</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('client.over',['id'=>$v->user_id])}}');" >연박 설정</button></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="13">{{ $user_client->links('admin.pc.pagination.default') }}</td>
        </tr>
        </tfoot>
    </table>
-->
    @endsection
