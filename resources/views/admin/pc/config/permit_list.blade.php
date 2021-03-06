@extends("admin.pc.layout.basic")

@section("title")권한설정@endsection

@section("scripts")
    <script>
        $(function(){
            $("ul.tab-v1__list.clb li").click(function(){
                var type = $(this).data("val");

                //선택탭처리
                $("ul.tab-v1__list.clb li").removeClass("is-active");
                $(this).addClass("is-active");

                //권한목록변경
                $("table#list_permit_menu tbody").find("tr").each(function(){
                    if(type=="all") $(this).show();
                    else if(type==$(this).data("permit")) $(this).show();
                    else $(this).hide();
                });

                //회원목록변경
                var sel_type = type.replace(/user_/gi,'');
                $("table#user_list_menu tbody").find("tr").each(function(){
                    if(sel_type=="all") $(this).show();
                    else if(sel_type==$(this).data("type")) $(this).show();
                    else $(this).hide();
                });
            });
        });


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // function onclickRadio(obj) {
        //     var tmp_permit = $(obj).val();
        //     if(tmp_permit=="all") $("table.user_permit_list tr").show();
        //     else {
        //         $("table.user_permit_list").find("tbody tr").each(function () {
        //             if ($(this).find("td").data("permit") == tmp_permit) $(this).show();
        //             else $(this).hide();
        //         });
        //     }
        // }

        $(function(){
            //권한선택시 목록 체크 권한 체크
            $(".user_permit").click(function(){
                $.post(
                    "{{ route('config.permit.info') }}"
                    , { id: $(this).data("id") }
                    , function(data){
                        $("input[name^='permit[']").each(function(){
                            $(this).prop("checked",false);
                        });
                        $("input[name=permit_id]").val(data.id);
                        $("input[name=permit_name]").val(data.info.permit_name);
                        $("select[name=permit_type]").val(data.info.code_user_type);
                        for(var i=0; i<data.permit.length; i++){
                            if(data.permit[i].list=="Y")   $("#permit_"+data.permit[i].code_admin+"_list").prop("checked",true);
                            if(data.permit[i].write=="Y")  $("#permit_"+data.permit[i].code_admin+"_save").prop("checked",true);
                            if(data.permit[i].view=="Y")   $("#permit_"+data.permit[i].code_admin+"_view").prop("checked",true);
                            if(data.permit[i].delete=="Y") $("#permit_"+data.permit[i].code_admin+"_del").prop("checked",true);
                        }
                    }
                    , "json"
                )
            });

            //권한신규추가
            $("button.add_new").click(function(){
                $("input[name=permit_id]").val("");
                $("input[name=permit_name]").val("");
                $("select[name=permit_type]").val("");
                $("input[name^='permit[']").each(function(){
                    $(this).prop("checked",false);
                });
            });
        });
    </script>
@endsection

@section("styles")
<script src="http://staff.einet.co.kr/asset/js/jquery.mCustomScrollbar.min.js"></script>
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/jquery.mCustomScrollbar.min.css">
@endsection

@section("contents")
    <div class="permit">
        <div class="permit-head clb">
            <p class="permit-head__tit fl">권한설정</p>
            <div class="permit-head__tab tab-v1 type-pd fl">
                <ul class="tab-v1__list clb">
                    <li class="tab-v1__item fl is-active" data-val="all">
                        <button type="button" class="tab-v1__btn">전체</button>
                    </li>
                    <li class="tab-v1__item fl" data-val="user_staff">
                        <button type="button" class="tab-v1__btn">관리자</button>
                    </li>
                    <li class="tab-v1__item fl" data-val="user_agency">
                        <button type="button" class="tab-v1__btn">대행사</button>
                    </li>
                    <li class="tab-v1__item fl" data-val="user_client">
                        <button type="button" class="tab-v1__btn">숙박업체</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="permit-content">
            <ul class="permit-content__list clb">
                <li class="permit-content__item fl" style="width:20%">
                    <div class="permit-content__inbox">
                        <div class="table-a noto">
                            <div class="table-a__head permit-content__head clb">
                                <div class="table-a_inbox type-head fr">
                                    <button type="button" class="btn-v1 add_new">신규추가</button>
                                </div>
                            </div>
                            <table class="table-a__table" id="list_permit">
                                <thead>
                                <tr class="table-a__tr type-th" data-permit="">
                                    <th class="table-a__th ta-c">번호</th>
                                    <th class="table-a__th ta-c">사용자</th>
                                </tr>
                                </thead>
                                 </table>
                               <div class="scroll-box js-scroll">
                                <table class="table-a__table" id="list_permit_menu">
                                <tbody>
                                @foreach($list_permit as $lk => $lp)
                                <tr class="table-a__tr" data-permit="{{$lp->code_user_type}}">
                                    <td class="table-a__td">
                                        <div class="table-a__inbox">
                                            <span>{{sizeof($list_permit)-$lk}}</span>
                                        </div>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <div class="table-a__inbox">
                                            <a href="javascript://" data-id="{{$lp->id}}" class="table-a__span type-line user_permit">{{$lp->permit_name}}</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="permit-content__item fl" style="width:40%">
                    <form method="post" name="frmPermitInfo" onSubmit="return frmConfigPermitCheck()" action="{{url()->current()}}">
                    {{csrf_field()}}
                    <input type="hidden" name="permit_id" />
                    <div class="permit-content__inbox">
                        <div class="table-a noto">
                            <div class="table-a__head permit-content__head clb">
                                <div class="permit-content__inbox type-head fl clb">
                                    <span class="permit-content__sub fl">권한명칭</span>
                                    <div class="input-wrap fl ml-5" style="width:40%">
                                        <input type="text" class="input-v1" name="permit_name" placeholder="권한명칭" />
                                    </div>
                                    <div class="input-wrap fl ml-5" style="width:34%">
                                        <div class="select-wrap">
                                            <select name="permit_type" class="select-v1 noto" style="font-size:14px;">
                                                <option value="">::사용자구분::</option>
                                                <option value="user_staff">관리자</option>
                                                <option value="user_agency">대행사</option>
                                                <option value="user_client">숙박업체</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-a_inbox type-head fr">
                                    <button type="submit" class="btn-v1">저장</button>
                                </div>
                            </div>
                            <table class="table-a__table">
                            <thead>
                                <tr class="table-a__tr type-th">
                                <th class="table-a__th ta-c">메뉴명</th>
                                <th class="table-a__th ta-c">목록</th>
                                <th class="table-a__th ta-c">보기</th>
                                <th class="table-a__th ta-c">저장</th>
                                <th class="table-a__th ta-c">삭제</th>
                            </tr>
                            </thead>
                            </table>
                               <div class="scroll-box js-scroll">
                                <table class="table-a__table">
                                <tbody>
                                @foreach($menu_list as $ml)
                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-nopd">
                                        <div class="layer-box type-a">
                                            <span class="layer-box__span">{{$ml['name']}}</span>
                                        </div>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="checkbox" class="checkbox-v2" name="permit[{{$ml['code']}}][list]" id="permit_{{$ml['code']}}_list" value="Y" />
                                        <label for="permit_{{$ml['code']}}_list">목록</label>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="checkbox" class="checkbox-v2" name="permit[{{$ml['code']}}][view]" id="permit_{{$ml['code']}}_view" value="Y" />
                                        <label for="permit_{{$ml['code']}}_view">보기</label>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="checkbox" class="checkbox-v2" name="permit[{{$ml['code']}}][save]" id="permit_{{$ml['code']}}_save" value="Y" />
                                        <label for="permit_{{$ml['code']}}_save">저장</label>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="checkbox" class="checkbox-v2" name="permit[{{$ml['code']}}][del]" id="permit_{{$ml['code']}}_del" value="Y" />
                                        <label for="permit_{{$ml['code']}}_del">삭제</label>
                                    </td>
                                </tr>
                                @if(isset($ml['sub']))
                                    @foreach($ml['sub'] as $mls)
                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-nopd">
                                            <div class="layer-box type-b">
                                                <span class="layer-box__span">{{$mls['name']}}</span>
                                            </div>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                            <input type="checkbox" class="checkbox-v2" name="permit[{{$mls['code']}}][list]" id="permit_{{$mls['code']}}_list" value="Y" />
                                            <label for="permit_{{$mls['code']}}_list">목록</label>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                            <input type="checkbox" class="checkbox-v2" name="permit[{{$mls['code']}}][view]" id="permit_{{$mls['code']}}_view" value="Y" />
                                            <label for="permit_{{$mls['code']}}_view">보기</label>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                            <input type="checkbox" class="checkbox-v2" name="permit[{{$mls['code']}}][save]" id="permit_{{$mls['code']}}_save" value="Y" />
                                            <label for="permit_{{$mls['code']}}_save">저장</label>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                            <input type="checkbox" class="checkbox-v2" name="permit[{{$mls['code']}}][del]" id="permit_{{$mls['code']}}_del" value="Y" />
                                            <label for="permit_{{$mls['code']}}_del">삭제</label>
                                        </td>
                                    </tr>
                                    @if(isset($mls['sub']))
                                        @foreach($mls['sub'] as $mlss)
                                            <tr class="table-a__tr">
                                                <td class="table-a__td type-nobd type-nopd">
                                                    <div class="layer-box type-c">
                                                        <span class="layer-box__span">{{$mlss['name']}}</span>
                                                    </div>
                                                </td>
                                                <td class="table-a__td type-nobd">
                                                    <input type="checkbox" class="checkbox-v2" name="permit[{{$mlss['code']}}][list]" id="permit_{{$mlss['code']}}_list" value="Y" />
                                                    <label for="permit_{{$mlss['code']}}_list">목록</label>
                                                </td>
                                                <td class="table-a__td type-nobd">
                                                    <input type="checkbox" class="checkbox-v2" name="permit[{{$mlss['code']}}][view]" id="permit_{{$mlss['code']}}_view" value="Y" />
                                                    <label for="permit_{{$mlss['code']}}_view">보기</label>
                                                </td>
                                                <td class="table-a__td type-nobd">
                                                    <input type="checkbox" class="checkbox-v2" name="permit[{{$mlss['code']}}][save]" id="permit_{{$mlss['code']}}_save" value="Y" />
                                                    <label for="permit_{{$mlss['code']}}_save">저장</label>
                                                </td>
                                                <td class="table-a__td type-nobd">
                                                    <input type="checkbox" class="checkbox-v2" name="permit[{{$mlss['code']}}][del]" id="permit_{{$mlss['code']}}_del" value="Y" />
                                                    <label for="permit_{{$mlss['code']}}_del">삭제</label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @endforeach
                                @endif
                                @endforeach

{{--
                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-nopd">
                                        <div class="layer-box type-d">
                                            <span class="layer-box__span">권한설정</span>
                                        </div>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="radio" id="permit1" class="radio-v2" name="permit1" value="1">
                                        <label for="permit1">목록</label>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="radio" id="permit2" class="radio-v2" name="permit2" value="1">
                                        <label for="permit2">보기</label>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="radio" id="permit3" class="radio-v2" name="permit3" value="1">
                                        <label for="permit3">저장</label>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <input type="radio" id="permit4" class="radio-v2" name="permit4" value="1">
                                        <label for="permit4">삭제</label>
                                    </td>
                                </tr>
--}}
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    </form>
                </li>
                <li class="permit-content__item fl" style="width:40%">
                    <form method="post" name="frmPermitUser" action="{{ route('config.permit.user') }}">
                    {{ csrf_field() }}
                    <div class="permit-content__inbox">
                        <div class="table-a noto">
                            <div class="table-a__head permit-content__head clb">
                                <div class="table-a_inbox type-head fr">
                                    <button type="submit" class="btn-v1">저장</button>
                                </div>
                            </div>
                            <table class="table-a__table" id="user_list">
                                <colgroup>
                                </colgroup>
                                <thead>
                                <tr class="table-a__tr type-th">
                                    <th class="table-a__th ta-c">회원구분</th>
                                    <th class="table-a__th ta-c">업체명</th>
                                    <th class="table-a__th ta-c">권한</th>
                                </tr>
                                </thead>
                                 </table>
                               <div class="scroll-box js-scroll">
                                <table class="table-a__table" id="user_list_menu">
                                <tbody>
                                @foreach($user_list as $ui)
                                <tr class="table-a__tr" style="list-style:none; " data-type="{{$ui->type}}">
                                    <td class="table-a__td type-nobd">
                                        <span class="permit-content__span">{{ $ui->type=="staff"?"관리자":($ui->type=="agency"?"대행사":($ui->type=="client"?"숙박업체":"")) }}</span>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <span class="permit-content__span">{{ $ui->user_name }}</span>
                                    </td>
                                    <td class="table-a__td type-nobd">
                                        <div class="input-wrap">
                                            <div class="select-wrap permit-content__select" style="width:150px;">
                                                <select name="user_permit[{{$ui->type}}][{{ $ui->id }}]" class="select-v1 noto">
                                                @foreach($list_permit as $lp)
                                                @if($lp->code_user_type=="user_".$ui->type)
                                                    <option value="{{$lp->id}}" {{$lp->id==$ui->permit_id?"selected":""}}>{{$lp->permit_name}}</option>
                                                @endif
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
<script>
    //scroll
     //scroll
        $(".js-scroll").mCustomScrollbar({
            theme:"minimal-dark"
        });

</script>
   <!--
    <div style="float:left; width:200px; margin-right:10px; ">
        <input type="radio" name="list_user_type" id="list_all" class="small" value="all" onclick="onclickRadio(this)" checked />
        <label for="list_all">전체</label>

        <input type="radio" name="list_user_type" id="list_staff" class="small" value="user_staff" onclick="onclickRadio(this)" />
        <label for="list_staff">관리자</label>

        <input type="radio" name="list_user_type" id="list_agency" class="small" value="user_agency" onclick="onclickRadio(this)" />
        <label for="list_agency">대행사</label>

        <input type="radio" name="list_user_type" id="list_client" class="small" value="user_client" onclick="onclickRadio(this)" />
        <label for="list_client">숙박업체</label>

        <table class="default user_permit_list" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>사용자</td>
            </tr>
            </thead>
            <tbody>
            @foreach($list_permit as $lp)
                <tr>
                    <td data-permit="{{$lp->code_user_type}}"><a href="javascript://" data-id="{{$lp->id}}">{{$lp->permit_name}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
{{--        <input type="button" value="신규추가" class="addNew" />--}}
        <button type="button" class="btn_gray_00 add_new">신규추가</button>
    </div>
    <div style="float:left; width:450px; margin-right:10px; ">
    <form method="post" name="frmPermitInfo" action="{{ url()->current() }}">
        {{ csrf_field() }}
        <input type="hidden" name="permit_id" />
        권한명칭: <input type="text" name="permit_name" class="default" />
        <select name="permit_type" class="default">
            <option value="">::선택::</option>
            <option value="user_staff">관리자</option>
            <option value="user_agency">대행사</option>
            <option value="user_client">숙박업체</option>
        </select>
        <button type="submit" class="btn_gray_00">저장</button>
        <table class="default user_permit_list" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>메뉴명</td>
                <td>목록</td>
                <td>보기</td>
                <td>저장</td>
                <td>삭제</td>
            </tr>
            </thead>
            <tbody>
            @foreach($menu_list as $ml)
            <tr>
                <td>{{$ml['name']}}</td>
                <td>
                    <input type="checkbox" name="permit[{{$ml['code']}}][list]" id="permit_{{$ml['code']}}_list" value="Y" class="small" />
                    <label for="permit_{{$ml['code']}}_list">목록</label>
                </td>
                <td>
                    <input type="checkbox" name="permit[{{$ml['code']}}][view]" id="permit_{{$ml['code']}}_view" value="Y" class="small" />
                    <label for="permit_{{$ml['code']}}_view">보기</label>
                </td>
                <td>
                    <input type="checkbox" name="permit[{{$ml['code']}}][save]" id="permit_{{$ml['code']}}_save" value="Y" class="small" />
                    <label for="permit_{{$ml['code']}}_save">저장</label>
                </td>
                <td>
                    <input type="checkbox" name="permit[{{$ml['code']}}][del]" id="permit_{{$ml['code']}}_del" value="Y" class="small" />
                    <label for="permit_{{$ml['code']}}_del">삭제</label>
                </td>
            </tr>
            @if(isset($ml['sub']))
                @foreach($ml['sub'] as $mls)
                    <tr>
                        <td>-{{$mls['name']}}</td>
                        <td>
                            <input type="checkbox" name="permit[{{$mls['code']}}][list]" id="permit_{{$mls['code']}}_list" value="Y" class="small" />
                            <label for="permit_{{$mls['code']}}_list">목록</label>
                        </td>
                        <td>
                            <input type="checkbox" name="permit[{{$mls['code']}}][view]" id="permit_{{$mls['code']}}_view" value="Y" class="small" />
                            <label for="permit_{{$mls['code']}}_view">보기</label>
                        </td>
                        <td>
                            <input type="checkbox" name="permit[{{$mls['code']}}][save]" id="permit_{{$mls['code']}}_save" value="Y" class="small" />
                            <label for="permit_{{$mls['code']}}_save">저장</label>
                        </td>
                        <td>
                            <input type="checkbox" name="permit[{{$mls['code']}}][del]" id="permit_{{$mls['code']}}_del" value="Y" class="small" />
                            <label for="permit_{{$mls['code']}}_del">삭제</label>
                        </td>
                    </tr>
                    @if(isset($mls['sub']))
                        @foreach($mls['sub'] as $mlss)
                            <tr>
                                <td>--{{$mlss['name']}}</td>
                                <td>
                                    <input type="checkbox" name="permit[{{$mlss['code']}}][list]" id="permit_{{$mlss['code']}}_list" value="Y" class="small" />
                                    <label for="permit_{{$mlss['code']}}_list">목록</label>
                                </td>
                                <td>
                                    <input type="checkbox" name="permit[{{$mlss['code']}}][view]" id="permit_{{$mlss['code']}}_view" value="Y" class="small" />
                                    <label for="permit_{{$mlss['code']}}_view">보기</label>
                                </td>
                                <td>
                                    <input type="checkbox" name="permit[{{$mlss['code']}}][save]" id="permit_{{$mlss['code']}}_save" value="Y" class="small" />
                                    <label for="permit_{{$mlss['code']}}_save">저장</label>
                                </td>
                                <td>
                                    <input type="checkbox" name="permit[{{$mlss['code']}}][del]" id="permit_{{$mlss['code']}}_del" value="Y" class="small" />
                                    <label for="permit_{{$mlss['code']}}_del">삭제</label>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endif
            @endforeach
            </tbody>
        </table>
    </form>
    </div>
    <div style="float:left; width:350px; ">
    <form method="post" name="frmPermitUser" action="{{ route('config.permit.user') }}">
        {{ csrf_field() }}
        <table class="default user_permit_list" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>회원구분</td>
                <td>업체명</td>
                <td>권한</td>
            </tr>
            </thead>
            <tbody>
            @foreach($user_list as $ui)
            <tr style="list-style:none; ">
                <td>{{ $ui->type=="staff"?"관리자":($ui->type=="agency"?"대행사":($ui->type=="client"?"숙박업체":"")) }}</td>
                <td>{{ $ui->user_name }}</td>
                <td>
                    <select name="user_permit[{{$ui->type}}][{{ $ui->id }}]" class="default">
                        <option value="0">::권한없음::</option>
                        @foreach($list_permit as $lp)
                            @if($lp->code_user_type=="user_".$ui->type)
                            <option value="{{$lp->id}}" {{$lp->id==$ui->permit_id?"selected":""}}>{{$lp->permit_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn_gray_00">저장</button>
    </form>
    </div>
    -->
@endsection
