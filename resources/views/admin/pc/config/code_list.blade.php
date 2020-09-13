@extends("admin.pc.layout.basic")

@section("title")코드관리@endsection

@section("scripts")
    <script>
        $(function(){
            $(".list-code").click(function(){
                $(".fake-select").text($(this).data("up_text"));
                $.post(
                    "{{route('config.code.call')}}"
                    ,{
                        id: $(this).data("id")
                        , depth: $(this).data("depth")
                    }
                    ,function(data){
                        if(data.code==200){
                            var item = data.info;
                            $("#up_id").val(item.up_id);
                            $("#id").val(item.id);
                            $("#code").val(item.code);
                            $("#code_name").val(item.code_name);
                            $("#simple").val(item.simple);
                            $("input[name=flag_use][value="+item.flag_use+"]").prop("checked",true);
                            $("input[name=flag_view][value="+item.flag_view+"]").prop("checked",true);
                        }
                        else {
                            alert(data.message);
                        }
                    }
                )
            });

            $("select#select_menu").change(function(){
                var sel = $(this).val();
                $("div.accordion__wrap").find("p.type-pink").each(function(){
                    if(sel=="") $(this).parent().show();
                    else if(sel==$(this).data("id")) $(this).parent().show();
                    else $(this).parent().hide();
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
<div class="guide-box" id="i_code_list_blade">
    <div class="guide-wrap clb">

        <div class="guide-wrap__double  fl">
            <div class="table-a noto">
                <div class="table-a__head clb">
                    <p class="table-a__tit fl">코드 관리</p>
                    <div class="ta-r">
                        <button type="button" class="r-calendar-head__btn btn-v1" onclick="frmReset('frmCodeSave'); ">추가</button>
                    </div>
                </div>
                <div class="accordion noto">
					<div class="accordion__line type-main clb">
						<span class="fl">코드명</span>
						<div class="input-wrap fr accordion__select">
						    <div class="select-wrap">
						        <select id="select_menu" class="select-v1 noto">
                                    <option value="" data-depth="0">::전체::</option>
                                    @foreach($codeList as $k => $c)
						            <option value="{{$c['info']->id}}" data-depth="{{$c['info']->depth}}">{{$c['info']->code."::".$c['info']->code_name}}</option>
                                    @endforeach
						        </select>
						    </div>
						</div>
					</div>
                    <div class=" scroll-box type-code js-scroll">
                    {{-- 0차 뎁스 --}}
                    @foreach($codeList as $k => $c)
                    <div class="accordion__wrap">
                        <p class="list-code accordion__line js-acc-btn {{!isset($c['sub'])?"type-none is-none":""}} type-pink" data-depth="{{$c['info']->depth}}" data-id="{{$c['info']->id}}" data-up_id="{{$c['info']->up_id}}" data-up_text="::상위선택::">{{$c['info']->code."::".$c['info']->code_name}}</p>
                        {{-- 1차 뎁스 --}}
                        @if(isset($c['sub']))
                            <div class="accordion__inbox">
                            @foreach($c['sub'] as $k2 => $c2)
                                <p class="list-code accordion__line js-acc-btn {{!isset($c2['sub'])?"type-none is-none":""}} type-grey1" data-depth="{{$c2['info']->depth}}" data-id="{{$c2['info']->id}}" data-up_id="{{$c2['info']->up_id}}" data-up_text="{{$c['info']->code."::".$c['info']->code_name}}">{{$c2['info']->code."::".$c2['info']->code_name}}</p>
                                {{-- 2차 뎁스 --}}
                                @if(isset($c2['sub']))
                                <div class="accordion__inbox type-last">
                                    @foreach($c2['sub'] as $k3 => $c3)
                                    <p class="list-code accordion__line js-acc-btn {{!isset($c3['sub'])?"type-none is-none":""}} type-grey2" data-depth="{{$c3['info']->depth}}" data-id="{{$c3['info']->id}}" data-up_id="{{$c3['info']->up_id}}" data-up_text="{{$c2['info']->code."::".$c2['info']->code_name}}">{{$c3['info']->code."::".$c3['info']->code_name}}</p>
                                        {{-- 3차 뎁스 --}}
                                        @if(isset($c3['sub']))
                                        <div class="accordion__inbox">
                                            @foreach($c3['sub'] as $k4 => $c4)
                                            <p class="list-code accordion__line type-grey2 type-bottom" data-depth="{{$c4['info']->depth}}" data-id="{{$c4['info']->id}}" data-up_id="{{$c4['info']->up_id}}" data-up_text="{{$c3['info']->code."::".$c3['info']->code_name}}">{{$c4['info']->code."::".$c4['info']->code_name}}</p>
                                            @endforeach
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            @endforeach
                            </div>
                        @endif
                    </div>
                    @endforeach
                   </div>

				</div>
            </div>
        </div>
        <div class="guide-wrap__double fl">
            <div class="table-a noto">
                <div class="table-a__head clb">
                    <p class="table-a__tit fl">코드 관리 추가</p>
                    <div class="ta-r"><button type="button" class="r-calendar-head__btn btn-v2" onclick="$('form[name=frmCodeSave]').submit(); ">저장</button></div>
                </div>
                <form class="table-a noto" method="post" name="frmCodeSave" action="{{ route('config.code.save') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" />
                    <input type="hidden" name="up_id" id="up_id" />
                    <table class="table-a__table">
                        <colgroup>
                            <col width="100px">
                            <col width="*">
                        </colgroup>
                        <tr class="table-a__tr type-pink">
                            <td class="table-a__td type-nobd type-right">상위 카테고리</td>
                            <td class="table-a__td type-nobd type-left type-mr10">
                                <div class="input-wrap mt-5" style="width:100%">
                                    <div class="select-wrap">
                                        {{-- 0차 뎁스 --}}
                                        <div class="fake-select">::상위선택::</div>
                                        <div class="fake-select__box">
                                            <div class="accordion__wrap">
                                            @foreach($codeList as $k => $c)
                                                <p class="accordion__line type-pink {{!isset($c['sub'])?"type-none is-none":""}} type-select" data-depth="{{$c['info']->depth}}" data-id="{{$c['info']->id}}" data-up_id="{{$c['info']->up_id}}">{{$c['info']->code."::".$c['info']->code_name}}</p>
                                                {{-- 1차 뎁스 --}}
                                                @if(isset($c['sub']))
                                                <div class="accordion__inbox">
                                                    @foreach($c['sub'] as $k2 => $c2)
                                                        <p class="accordion__line type-grey1 {{!isset($c2['sub'])?"type-none is-none":""}} type-select" data-depth="{{$c2['info']->depth}}" data-id="{{$c2['info']->id}}" data-up_id="{{$c2['info']->up_id}}">{{$c2['info']->code."::".$c2['info']->code_name}}</p>
                                                        {{-- 2차 뎁스 --}}
                                                        @if(isset($c2['sub']))
                                                        <div class="accordion__inbox type-last">
                                                            @foreach($c2['sub'] as $k3 => $c3)
                                                                <p class="accordion__line type-grey2 {{!isset($c3['sub'])?"type-none is-none":""}} type-select" data-depth="{{$c3['info']->depth}}" data-id="{{$c3['info']->id}}" data-up_id="{{$c3['info']->up_id}}">{{$c3['info']->code."::".$c3['info']->code_name}}</p>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @endif
                                            @endforeach
                                            </div>
                                        </div>

{{--
                                        <div class="fake-select">admin_config::개발관리</div>
                                        <div class="fake-select__box">
                                            <div class="accordion__wrap">
                                                <p class="accordion__line type-pink type-select">category_admin::카테고리</p>
                                                <div class="accordion__inbox">
                                                    <p class="accordion__line type-grey1 type-select ">admin_config::개발관리</p>
                                                    <div class="accordion__inbox type-last">
                                                        <p class="accordion__line  type-grey2 type-select">admin_config_code::코드관리</p>
                                                    </div>
                                                    <p class="accordion__line type-grey1 type-select">admin_user::회원관리</p>
                                                    <div class="accordion__inbox">
                                                        <p class="accordion__line type-grey2 type-select">admin_user_staff::직원관리</p>
                                                        <p class="accordion__line type-grey2 type-select">admin_user_staff::직원관리</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
--}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right">코드</td>
                            <td class="table-a__td type-nobd type-left type-mr10">
                                <div class="input-wrap" style="width:80%">
                                    <input type="text" class="input-v1" name="code" id="code" />
                                </div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right">코드명</td>
                            <td class="table-a__td type-nobd type-left type-mr10">
                                <div class="input-wrap " style="width:80%">
                                    <input type="text" class="input-v1" name="code_name" id="code_name" />
                                </div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right">설명</td>
                            <td class="table-a__td type-nobd type-left type-mr10">
                                <div class="input-wrap" style="width:100%">
                                    <input type="text" class="input-v1" name="simple" id="simple" />
                                </div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right">사용여부</td>
                            <td class="table-a__td type-nobd type-left type-mr10">
                                <div class="table-a__inbox type-left">
                                    <input type="radio" id="flag_use_Y" class="radio-v1 dp-ib" name="flag_use" value="Y" />
                                    <label for="flag_use_Y" class="">사용함</label>
                                    <input type="radio" id="flag_use_N" class="radio-v1 dp-ib" name="flag_use" value="N" />
                                    <label for="flag_use_N" class="ml-20">사용안함</label>
                                </div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right">노출여부</td>
                            <td class="table-a__td type-nobd type-left type-mr10">
                                <div class="table-a__inbox type-left">
                                    <input type="radio" id="flag_view_Y" class="radio-v1 dp-ib" name="flag_view" value="0" />
                                    <label for="flag_view_Y" class="">노출</label>
                                    <input type="radio" id="flag_view_N" class="radio-v1 dp-ib" name="flag_view" value="0" />
                                    <label for="flag_view_N" class="ml-20">노출안함(카테고리만 적용중)</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $(".js-acc-btn").click(function(){
            if(!$(this).hasClass("is-none")){
                if($(this).hasClass("type-minus")){//닫을때
                    $(this).removeClass("type-minus");
                    var next = $(this).next();
                    $(next).hide();
                    $(next).find(".accordion__inbox").each(function(){//이하요소 모두 숨기기
                        $(this).hide();
                    });
                    $(next).find(".accordion__line").each(function(){//이하요소 아이콘 변경
                        $(this).removeClass("type-minus");
                    });
                }else{//열때
                    $(this).addClass("type-minus");
                    $(this).next().show();
                }
            }
        });


        $(".fake-select").click(function () {//열때
            $(this).next(".fake-select__box").toggle();
        });

        $(".fake-select__box").click(function () {//선택했을때
            $(this).closest(".fake-select__box").hide();
        });

        $(document).click(function (e) {//그외부분 클릭시 닫기
            if (!$(".fake-select__box").is(e.target) && !$(".fake-select").is(e.target)) {
                $(".fake-select__box").hide();
            }
        });

        //scroll
        $(".js-scroll").mCustomScrollbar({
            theme: "minimal-dark"
        });

        $("p.accordion__line.type-select").click(function(){
            $("#id").val($(this).data("id"));
            $("#up_id").val($(this).data("up_id"));
            $(".fake-select").text($(this).text());

            $("#code").val("");
            $("#code_name").val("");
            $("#simple").val("");
            $("input[name=flag_use][value=Y]").prop("checked",true);
            $("input[name=flag_view][value=N]").prop("checked",true);
        });
    });//로드구역

</script>











<!--
    <div style="float:left; width:400px; ">
        <input type="button" value="추가" onclick="frmReset('frmCodeSave'); " />
        <ul>
        {{-- 0차 뎁스 --}}
        @foreach($codeList as $k => $c)
            <li>
                <span class="list-code" data-depth="{{$c['info']->depth}}" data-id="{{$c['info']->id}}">{{$c['info']->code."::".$c['info']->code_name}}</span>
                {{-- 1차 뎁스 --}}
                @if(isset($c['sub']))
                <ul>
                @foreach($c['sub'] as $k2 => $c2)
                    <li>
                        <span class="list-code" data-depth="{{$c2['info']->depth}}" data-id="{{$c2['info']->id}}">{{$c2['info']->code."::".$c2['info']->code_name}}</span>
                        {{-- 2차 뎁스 --}}
                        @if(isset($c2['sub']))
                            <ul>
                                @foreach($c2['sub'] as $k3 => $c3)
                                    <li>
                                        <span class="list-code" data-depth="{{$c3['info']->depth}}" data-id="{{$c3['info']->id}}">{{$c3['info']->code."::".$c3['info']->code_name}}</span>
                                        {{-- 3차 뎁스 --}}
                                        @if(isset($c3['sub']))
                                            <ul>
                                                @foreach($c3['sub'] as $k4 => $c4)
                                                    <li>
                                                        <span class="list-code" data-depth="{{$c4['info']->depth}}" data-id="{{$c4['info']->id}}">{{$c4['info']->code."::".$c4['info']->code_name}}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                </ul>
                @endif
            </li>
        @endforeach
        </ul>
    </div>

    <div style="float:left; width:400px; ">
        <form method="post" name="frmCodeSave" action="{{ url()->current() }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="id" />
            <div>
                상위카테고리
                <select name="up_id">
                    <option value="">::선택::</option>
                    @foreach($codeList as $k => $c)
                        <option value="{{$c['info']->id}}">{{$c['info']->code."::".$c['info']->code_name}}</option>
                        {{-- 1차 뎁스 --}}
                        @if(isset($c['sub']))
                        @foreach($c['sub'] as $k2 => $c2)
                            <option value="{{$c2['info']->id}}">&nbsp;-&nbsp;{{$c2['info']->code."::".$c2['info']->code_name}}</option>
                            {{-- 2차 뎁스 --}}
                            @if(isset($c2['sub']))
                            @foreach($c2['sub'] as $k3 => $c3)
                                <option value="{{$c3['info']->id}}" style="padding-left:15px; ">&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{$c3['info']->code."::".$c3['info']->code_name}}</option>
                                {{-- 3차 뎁스 --}}
                                @if(isset($c3['sub']))
                                @foreach($c3['sub'] as $k4 => $c4)
                                    <option value="{{$c4['info']->id}}" style="padding-left:15px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{$c4['info']->code."::".$c4['info']->code_name}}</option>
                                @endforeach
                                @endif
                            @endforeach
                            @endif
                        @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
            <div>코드: <input type="text" name="code" id="code" /></div>
            <div>코드명: <input type="text" name="code_name" id="code_name" /></div>
            <div>설명: <input type="text" name="simple" id="simple" /></div>
            <div>
                사용여부:
                <input type="radio" name="flag_use" id="flag_use_Y" value="Y" checked />사용함
                <input type="radio" name="flag_use" id="flag_use_N" value="N" />사용안함
            </div>
            <div>
                노출여부:
                <input type="radio" name="flag_view" id="flag_view_Y" value="Y" checked />노출
                <input type="radio" name="flag_view" id="flag_view_N" value="N" />노출안함
                (카테고리만 적용 중)
            </div>
            <input type="submit" value="저장" />
        </form>
    </div>
-->
@endsection
