<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Client List</h5>
            <table class="mb-0 table table-hover">
                @php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = str_replace(".einet.co.kr","",$path);
                @endphp
                <thead>
                <tr>
                    <th>순서</th>
                    <th>추가이용명</th>
                    <th>금액</th>
                    <th>기본/최대 수량</th>
                    <th>판매 객실</th>
                    <th>결제방법</th>
                    <th>당일예약</th>
                    <th>판매상태</th>
                    <th><button class="mr-2 btn btn-focus" onclick="goUrl('@if($path=="client") {{route('info.etc.view',['did'=>isset($did)?$did:""])}} @else {{route('price.facility.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""])}} @endif');">추가이용요금 등록</button></th>
                </tr>
                </thead>
                <tbody>
                @foreach($additionetcprice as $k => $c)
                    <tr>
                        <th scope="row">{{ $additionetcprice->total()-$k }}</th>
                        <td>
                            @if($path=="client")
                            <a href="/info/etc/view/{{$c->id}}">
                            @else
                            <a href="/price/facility/view/{{$user_id}}/{{$c->id}}">
                            @endif
                            @if(($c->etc_name)=="" && ($c->code=="spa"))
                                    스파
                            @elseif(($c->etc_name)=="" && $c->code=="privatepool")
                                개별 수영장
                            @elseif(($c->etc_name)=="" && $c->code=="bbq")
                                개별(테라스) 바베큐
                            @elseif(($c->etc_name)=="" && $c->code=="bathroom")
                                욕조
                            @elseif(($c->etc_name)=="" && $c->code=="tv")
                                TV
                            @elseif(($c->etc_name)=="" && $c->code=="conditioner")
                                에어컨
                            @elseif(($c->etc_name)=="" && $c->code=="gas")
                                가스레인지/인덕션
                            @elseif(($c->etc_name)=="" && $c->code=="coffee")
                                커피
                            @elseif(($c->etc_name)=="" && $c->code=="refrigerator")
                                냉장고
                            @elseif(($c->etc_name)=="" && $c->code=="table")
                                식탁
                            @elseif(($c->etc_name)=="" && $c->code=="rice")
                                전기 밥솥
                            @elseif(($c->etc_name)=="" && $c->code=="microwave")
                                전자레인지
                            @elseif(($c->etc_name)=="" && $c->code=="bar")
                                미니바
                            @elseif(($c->etc_name)=="" && $c->code=="bidet")
                                비데
                            @elseif(($c->etc_name)=="" && $c->code=="dry")
                                드라이기
                            @else
                                {{$c->etc_name}}
                            @endif
                            </a>
                        </td>
                        <td>{{ $c->etc_price }}</td>
                        <td>{{ $c->etc_min }}/{{ $c->etc_max }}</td>
                        <td>{{ $c->etc_price }}</td>
                        <td>{{ $c->etc_payment_flag }}</td>
                        <td>{{ $c->etc_reservation_flag }}</td>
                        <td>{{ $c->etc_flag }}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>