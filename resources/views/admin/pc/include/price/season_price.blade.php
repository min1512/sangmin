<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Price List</h5>
            <table class="mb-0 table table-hover" name="price_season_table" id="price_season_table">
                @php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = explode(".",$path);
                    if($path[0]=="staff"){
                        $PATH= $curPathstaff."/".$user_id;
                    }else{
                        $PATH = $curPath.'/save';
                    }
                @endphp
                <form action="{{ $PATH }}" method="post">
                    <input type="hidden" name="user_id" value="{{isset($user_id)?$user_id:""}}" />
                    {{csrf_field()}}
                    <thead>
                    <tr>
                        <th colspan="3" style="text-align: center">객실</th>
                        <th colspan="4" style="text-align: center">객실 기본요금</th>
                        <th colspan="3" style="text-align: center">추가 인원 요금</th>
                    </tr>
                    <tr>
                        <td>그룹명</td>
                        <td>기준</td>
                        <td width="fit-content">객실명</td>
                        <td width="fit-content"><input type="checkbox" id="season_all">전체 선택(시즌)</td>
                        <td>일요일</td>
                        <td>주중</td>
                        <td>금요일</td>
                        <td>토요일(공휴일 전날)</td>
                        <td>성인</td>
                        <td>아동</td>
                        <td>유아</td>
                    </tr>
                    </thead>
                    @foreach($room as $r)
                        @foreach($season as $s)
                            <tr>
                                <td class="gubun">{{$r->type_name}}</td>
                                <td>{{$r->room_cnt_basic}}</td>
                                <td>{{$r->room_name}}</td>
                                <td><input type="checkbox" name="all_price_{{$r->id}}_{{$s->id}}" id='all_price_{{$r->id}}_{{$s->id}}' value="all_price_{{$r->id}}_{{$s->id}}" />{{$s->season_name}}</td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[0][{{$r->id}}][{{$s->id}}]' id="price_0_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_0):0}}" />
                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[1][{{$r->id}}][{{$s->id}}]' id="price_1_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_1):0 }}" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[5][{{$r->id}}][{{$s->id}}]' id="price_5_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_5):0}}" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[6][{{$r->id}}][{{$s->id}}]' id="price_6_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_6):0}}" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[11][{{$r->id}}][{{$s->id}}]' id="price_11_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_adult):0}}" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[12][{{$r->id}}][{{$s->id}}]' id="price_12_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_child):0}}" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[13][{{$r->id}}][{{$s->id}}]' id="price_13_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_baby):0}}" />

                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <th style="text-align: center; width: 150px;"><button class="mr-2 btn btn-info">요금 등록</button></th>
                    </tr>
                </form>
            </table>
        </div>
    </div>
</div>
<div class='many_price_insert'>
</div>
