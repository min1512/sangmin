@php
    $path = $_SERVER["HTTP_HOST"];
    $path = explode(".", $path);
@endphp
<script>
    function delete1(season,user_id) {
        var path;
        if(confirm("정말 삭제 하시겠습니까?")) {
            if ("client" == {{ $path[0] }}) path = "/info/season_del_all";
            else if ("staff" == {{ $path[0] }}) path = "/price/season/del_all";

            $.ajax({
                url:path,
                data: {
                    season: season,
                    _token: '{{ csrf_token() }}'
                },
                type: "POST",
                success:function (data) {
                    location.href="";
                }
            })
        }
    }

    function saveSeason() {
        var data_season_start = new Array();
        var data_season_end = new Array();
        @foreach($season_term_all as $v)
        data_season_start.push('{{$v->season_start}}');
        data_season_end.push('{{$v->season_end}}');
        @endforeach
        var tcnt1 = 0;
        var tcnt3 = 0;
        $("input[name^='season_start']").each(function(index) {
            if (
                ($("input[name^='season_start']").eq(index).val() >= $("input[name^='season_end']").eq(index).val())
            ) {
                if (tcnt3 < 1) alert("날짜 입력이 잘못 되었습니다.");
                tcnt3++;
            } else if (
                ($("input[name^='season_start']").eq(index).val() == "" || $("input[name^='season_end']").eq(index).val() == "")
            ) {
                if (tcnt3 < 1) alert("날짜를 입력해주세요");
                tcnt3++;
            }
        });

        if ("client" == {{ $path[0] }}) {
            if (tcnt1 < 1 && tcnt3 < 1) {
                $("form[name=season_table]").attr("action", '/info/season_delete').submit();
                return true;
            } else {
                return false;
            }
        } else if ("staff" == {{ $path[0] }}) {
            if (tcnt1 < 1 && tcnt3 < 1) {
                $("form[name=season_table]").attr("action", '/price/season/del').submit();
                return true;
            } else {
                return false;
            }
        }
    };

    $(function() {
        var size_check = {{ isset($season_term_check)?sizeof($season_term_check):0 }};
        $(".btn-v1").click(function(){
            var tt = $(this).data("season");
            var html = "<div class='table-a__inbox type-line'>";
            html += "<p class='dp-wrap dp-ib type-able disable-wrap'><input type='text' class='datepicker va-m noto' name='season_start["+tt+"]["+size_check+"]' value='' /></p>";
            html += "</div>";
            $("td#test_"+tt+"_1").append(html);
            var html = "<div class='table-a__inbox type-line'>";
                html += "<p class='dp-wrap dp-ib type-able disable-wrap'><input type='text' class='datepicker va-m noto' name='season_end["+tt+"]["+size_check+"]' value='' /></p>";
                html += "<input type=\"checkbox\" name=\"season_delete["+tt+"]["+size_check+"]\" id=\"chk3_"+tt+"_"+size_check+"\" class=\"checkbox-v1 va-m\" value="+size_check+" ><label for=\"chk3_"+tt+"_"+size_check+"\" class=\"ml-10\" id=\"chk3_"+tt+"_"+size_check+"\">삭제</label>"
            html += "</div>";
            $("td#test_"+tt+"_2").append(html);
            size_check++;
            pickerReload();

        });
    });
</script>

<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body content__wrap">
            <div class="table-a noto">
                @php
                   $path = $_SERVER["HTTP_HOST"];
                   $path = explode(".",$path);
                   if($path[0]=="staff"){
                       $PATH= $curPathstaff."/".$user_id;
                       $SubmitPath= '/price/season/del';
                   }else{
                       $PATH = $curPath;
                       $SubmitPath = '/info/season_delete';
                   }
                @endphp
                <form name="season_table" method="post" >
                <input type="hidden" name="user_id" value="{{isset($user_id)?$user_id:""}}" />
                <div class="table-a__head clb">
                    <p class="table-a__tit fl">Season List</p>
                    <div class="table-a__inbox type-head fr">
                        <a id="add_season" name="add_season" class="btn-v2 ml-10" style="color: black;">시즌추가</a>
                        <button type="submit" class="btn-v2 ml-10 btn-info">시즌삭제</button>
                    </div>
                </div>
                    <table class="table-a__table" id="add_season_list">
                        <colgroup>
                            <col width="30px" />
                            <col width="*" />
                            <col width="*" />
                            <col width="*" />
                            <col width="*" />
                        </colgroup>
                        <tbody id="add_season_list">
                        {{ csrf_field() }}
                        <tr class="table-a__tr type-th">
                            <th class="table-a__th"></th>
                            <th class="table-a__th">시즌명</th>
                            <th class="table-a__th">시작 기간</th>
                            <th class="table-a__th">끝 기간</th>
                            <th class="table-a__th"></th>
                        </tr>
                        @foreach($seasonList as $k=>$st)
                        <tr class="table-a__tr">
                            <td class="table-a__td">
                                <div class="table-a__inbox ">
                                    <input type="checkbox" name="season_id[]" id="season_id_{{$k}}" class="checkbox-v1 type-notxt " value="{{$st->id}}"><label for="season_id_{{$k}}"></label>
                                </div>
                            </td>
                            <td class="table-a__td">
                                <p>
                                    <input type='hidden' id='season_name_{{$st->id}}' name='season_name[{{$st->id}}]' value="{{$st->season_name}}">
                                    <a id="season_show" >{{$st->season_name}}</a>
                                    <br>
                                    <button type="button" class="btn-v1" data-season="{{$st->id}}">시즌 기간 추가</button>
                                </p>
                            </td>
                            <td class="table-a__td" id="test_{{$st->id}}_1" >
                                 @foreach($season_term_check as $t=>$s)
                                    @if($st->id == $s->season_id)
                                        <div class="table-a__inbox type-line">
                                            <p class="dp-wrap dp-ib type-able disable-wrap">
                                                <input type='text' class="datepicker va-m noto"
                                                       id='season_start_{{$s->season_id}}_{{$t}}'
                                                       name='season_start[{{$s->season_id}}][]'
                                                       value="{{isset($season_term)?$s->season_start:""}}"/>
                                            </p>
                                        </div>
                                     @endif
                                @endforeach
                            </td>
                            <td class="table-a__td" id="test_{{$st->id}}_2" >
                                @foreach($season_term_check as $t=>$s)
                                    @if($st->id == $s->season_id)
                                        <div class="table-a__inbox type-line">
                                            <p class="dp-wrap dp-ib type-able disable-wrap">
                                                <input type='text' class="datepicker va-m noto"
                                                       id='season_end_{{$s->season_id}}_{{$t}}'
                                                       name='season_end[{{$s->season_id}}][]'
                                                       value="{{isset($season_term)?$s->season_end:""}}"/>
                                            </p>
                                            <input type="checkbox" name="season_delete1[{{$s->season_id}}][{{$s->id}}]"
                                                   id="chk3_{{$s->season_id}}_{{$t}}" class="checkbox-v1 va-m"
                                                   value="{{$s->id}}"><label for="chk3_{{$s->season_id}}_{{$t}}"
                                                                             class="ml-10"
                                                                             id="chk3_{{$s->season_id}}_{{$t}}">삭제</label>
                                        </div>
                                    @endif
                                @endforeach
                            </td>
                            <td class="table-a__td">
                                <button type="button" class="table-a__btn type-info btn-v2 type-lines dp-b w-92" onclick='delete1({{$st->id}},{{$user_id}})'><span class="point-51">시즌 기간</span><br><span class="point-blk">전체 삭제</span></button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="btn-wrap mt-24">
                        <button type="button" class="btn-v4 type-save season_save" onclick='saveSeason()'>저장</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
