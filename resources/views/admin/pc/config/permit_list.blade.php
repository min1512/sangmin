@extends("admin.pc.layout.basic")

@section("title")권한설정@endsection

@section("scripts")
    <script>
        function onclickRadio(obj) {
            var tmp_permit = $(obj).val();
            if(tmp_permit=="all") $("table.user_permit_list tr").show();
            else {
                $("table.user_permit_list").find("tbody tr").each(function () {
                    if ($(this).find("td").data("permit") == tmp_permit) $(this).show();
                    else $(this).hide();
                });
            }
        }

        $(function(){
            $("table.user_permit_list tbody").find("tr td a").click(function(){
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
            $("input.add_new").click(function(){
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
@endsection

@section("contents")
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
@endsection
