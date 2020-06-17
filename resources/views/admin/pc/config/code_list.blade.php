@extends("admin.pc.layout.basic")

@section("title")코드관리@endsection

@section("scripts")
    <script>
        $(function(){
            $(".list-code").click(function(){
                // $(this).data("depth");
                // $(this).data("id");
                $.post(
                    "{{route('config.code.call')}}"
                    ,{
                        id: $(this).data("id")
                        , depth: $(this).data("depth")
                    }
                    ,function(data){
                        console.log(data);
                        if(data.code==200){
                            var item = data.info;
                            $("select[name=up_id]").val(item.up_id);
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
            })
        });
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
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
@endsection
