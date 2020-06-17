@if($id=="" || $id==0)
@else
<div class="season_term_list">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Season Term</h5>
            <form name="season_term_form" method="post" onsubmit="return test()">
                <table class="mb-0 table table-hover" style="width: 1000px;" id="season_term_table">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="season_id" value="{{$id}}">
                    {{ csrf_field() }}
                    <tbody>
                        <tr>
                            @foreach($season as $s)
                                <th>시즌명</th>
                                <td colspan="2">{{$s->season_name}}&nbsp;&nbsp;<a class="mr-2 btn btn-info" id="time_add" style="color: white">기간 추가</a></td>
                            @endforeach
                        </tr>
                        @foreach($season_term as $k=>$st)
                        <tr>
                            <input type="hidden" name="season_term_id[{{$k}}]" value="{{$st->id}}" />
                            <th>기간</th>
                            <td><input type="date" name="start_season[{{$k}}]" value="{{$st->season_start}}">~<input type="date" name="end_season[{{$k}}]" value="{{$st->season_end}}">&nbsp;&nbsp;<a class="mr-2 btn btn-info season_delete" style="color: white" >X</a></td>
                            <td><input type="radio" name="check_season[{{$k}}]" value="Y" @if($st->flag_view=="Y") checked="checked"@endif/>기간 노출함<input type="radio" name="check_season[{{$k}}]" value="N" @if($st->flag_view=="N") checked="checked"@endif/>기간 노출 안함</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><button class="mr-2 btn btn-info season_save" id="season_save">저장</button></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>
@endif
