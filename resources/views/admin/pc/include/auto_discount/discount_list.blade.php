<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Season List</h5>
            <table class="mb-0 table table-hover" style="width: 1000px;" >
                <tr>
                    <th>&nbsp;</th>
                    <th>할인 적용일</th>
                    <th>할인 내용</th>
                    <th>기간</th>
                    <th>객실</th>
                    <th><a id="delete_discount" name="delete_discount" class="mr-2 btn btn-info" style="color: white;">할인 삭제</a></th>
                    <th><button class="mr-2 btn btn-focus" onclick="goUrl('{{ isset($client) && $client=="client" ? route('info.autoset.view',['did'=>isset($did)?$did:""]) : route('price.autoset.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""]) }}');">자동 할인 추가</button></th>
                </tr>
                @foreach($discountList as $k=> $s)
                    <tr>
                        @php
                            $date_array = explode(',',$s->day);
                            $date_list="";
                            for ($i=0; $i<sizeof($date_array); $i++){
                                if($date_array[$i]==1){
                                    $date_list = $date_list."월,";
                                }elseif ($date_array[$i]==2){
                                    $date_list = $date_list."화,";
                                }elseif ($date_array[$i]==3){
                                    $date_list = $date_list."수,";
                                }elseif ($date_array[$i]==4){
                                    $date_list = $date_list."목,";
                                }elseif ($date_array[$i]==5){
                                    $date_list = $date_list."금,";
                                }elseif ($date_array[$i]==6){
                                    $date_list = $date_list."토";
                                }elseif ($date_array[$i]==0){
                                    $date_list = $date_list."일,";
                                }
                            }
                        @endphp
                        <td>{{$k+1}}</td>
                        <td>
                            @if($client=="client")
                                <a href="/info/auto_discount/view/{{$s->id}}">{{$date_list}}</a>
                            @else
                                <a href="/price/autoset/view/{{$user_id}}/{{$s->id}}">{{$date_list}}</a>
                            @endif
                        </td>
                        <td>
                            @php
                                $aaaa = \App\Models\AutosetDiscountHowmuch::where('autoset_id',$s->id)->orderBy('date','asc')->get();
                            @endphp
                            @foreach($aaaa as $a)
                                @if($a->date=="0")
                                    <p>입실 당일: {{ $a->autoset_discount_howmuch }}</p>
                                @else
                                    <p>입실 {{$a->date}}일전: {{ $a->autoset_discount_howmuch }}</p>
                                @endif
                            @endforeach
                        </td>
                        <td>@if($s->term_check=="N")상시@elseif($s->term_check=="Y"){{$s->discount_start}} ~ {{$s->discount_end}}@endif</td>
                        <td>
                            @foreach($Client_type_room as $v)
                                @if($v->autoset_id==$s->id)
                                    <p>{{$v->room_name}}</p>
                                @endif
                            @endforeach
                        </td>
                        <td colspan="2"></td>
                    </tr>
                @endforeach
                <tr>
                    <th id="add_discount_list"></th>
                </tr>
            </table>
        </div>
    </div>
</div>
