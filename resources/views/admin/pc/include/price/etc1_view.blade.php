@extends("admin.pc.layout.basic")

@section("title")할인 판매 추가/수정@endsection

@section("scripts")
    <script>
        $(function () {
            @if(!isset($AdditionEtcPrice)){
                $('.right_now').hide();
            }
            @else{
                @if(isset($AdditionEtcPrice)&&$AdditionEtcPrice->etc_name==""){
                    $('.right_now').hide();
                }@elseif(isset($AdditionEtcPrice)&&$AdditionEtcPrice->etc_name!=""){
                    $('.right_now').show();
                    $(":input:radio[name=etc_name][value=Right]").prop("checked", true);
                }
                @endif
            }
            @endif
        })

        $(function () {
            $("input[name^='etc_name']").change(function () {
                console.log($(this).val());
                if($(this).val() =="Right"){
                    $('.right_now').show();
                    $('.right_now').html("<div class='position-relative form-group'>" +
                        "<label for='clientName'style='color: blue'>직접입력</label>" +
                        "<input type='text' name='right_now_value'>" +
                        "</div>");
                }else{
                    $('.right_now').hide();
                }
            });
            $('#room_id_all').change(function () {
                console.log($(this).val());
                if($(this).is(":checked")){
                    $("input[name^='room_id']").each(function () {
                        $(this).prop("checked",true);
                    });
                }else{
                    $("input[name^='room_id']").each(function () {
                        $(this).prop("checked",false);
                    });
                }
            })
        });
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Discount List</h5>
                @php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = str_replace(".einet.co.kr","",$path);
                @endphp
                @if($path=="client")
                <form method='post' name='teewetwer' class='client_form' action='/info/etc/save/{{isset($did)?$did:""}}'>
                @else
                    <form method='post' name='teewetwer' class='client_form' action='{{url()->current()}}'>
                @endif
                    {{csrf_field()}}
                    @if($isset == "")
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">추가이용명</label>
                            @foreach($Code as $v)
                                <input type="radio" name="etc_name" value="{{isset($Code)?$v->code:""}}"/>{{$v->code_name}}
                            @endforeach
                            <input type="radio" name="etc_name" value="Right"/>직접입력
                        </div>
                    @else
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">추가이용명</label>
                            @foreach($Code as $c)
                                <input type="radio" name="etc_name" value="{{$c->code}}" @if(($c->code)==($AdditionEtcPrice->code)) checked @endif/>{{$c->code_name}}
                            @endforeach
                            <input type="radio" name="etc_name" value="Right" @if(isset($AdditionEtcPrice->etc_name)) checked @endif/>직접입력
                        </div>
                    @endif



                    <div class="right_now">
                        <div class='position-relative form-group'>
                            <label for='clientName'style='color: blue'>직접입력</label>
                            <input type='text' name='right_now_value' value="{{isset($AdditionEtcPrice->etc_name)?$AdditionEtcPrice->etc_name:"" }}">
                        </div>
                    </div>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">상세 설명</label>
                    </div>
                    <textarea cols="30" rows="10" name="content" >{{isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_content:""}}
                    </textarea>


                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">기본 금액</label>
                        <input type="text" name="price" value="{{isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_price:""}}">원
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">단위</label>
                        <input type="text" name="dan" value="{{isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_dan:""}}">
                    </div>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">기본/최대 수량</label>
                        기본 : <input type="text" name="etc_min" value="{{isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_min:""}}">
                        최대 : <input type="text" name="etc_max" value="{{isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_max:""}}">
                    </div>
                    @if($isset=="")
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">판매 객실</label>
                            <input type="checkbox" id="room_id_all" value="Y">전체 객실 선택
                            @php
                                $ClientTypeRooms = \App\Models\ClientTypeRoom::where('user_id',$user_id)->get();
                            @endphp
                            @foreach($ClientTypeRooms as $v)
                                <input type="checkbox" name="room_id[]" value="{{$v->id}}">{{$v->room_name}}
                            @endforeach
                        </div>
                    @else
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">판매 객실</label>
                            <input type="checkbox" id="room_id_all" value="Y">전체 객실 선택
                            @php
                                $ClientTypeRooms = \App\Models\ClientTypeRoom::where('user_id',$user_id)->get();
                                $room_id = \App\Models\AdditionEtcPriceRoom::where('user_id',$user_id)->value('room_id');
                            @endphp
                            @foreach($ClientTypeRoom as $v)
                                <input type="checkbox" name="room_id[]" value="{{$v->id}}" @if(isset($v->room_id)) checked @endif />{{$v->room_name}}
                            @endforeach
                        </div>
                    @endif

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">결제 방법</label>
                        <input type="radio" name="etc_payment_flag" value="Y" @if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_payment_flag)=="Y") checked @endif/>예약시 결제
                        <input type="radio" name="etc_payment_flag" value="N" @if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_payment_flag)=="N") checked @endif/>현장 결제
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">당일 예약</label>
                        <input type="radio" name="etc_reservation_flag" value="Y" @if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_reservation_flag)=="Y") checked @endif/>가능
                        <input type="radio" name="etc_reservation_flag" value="N" @if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_reservation_flag)=="N") checked @endif/>불가능
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">판매 상태</label>
                        <input type="radio" name="etc_flag" value="Y" @if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_flag)=="Y") checked @endif/>판매
                        <input type="radio" name="etc_flag" value="N" @if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_flag)=="N") checked @endif/>비공개
                    </div>
                    <div><button class="mr-2 btn btn-focus" >저장</button></div>
                </form>
            </div>
        </div>
    </div>

@endsection


