<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body">
           <div class="table-a noto">
                 @php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = explode(".",$path);
                    if($path[0]=="staff"){
                        $PATH= $curPathstaff."/".$user_id;
                    }else{
                        $PATH = $curPath.'/save';
                    }
                    $check = $_SERVER['REQUEST_URI'];
                @endphp
                <form action="{{ $PATH }}" method="post">
                    <div class="table-a__head clb">
                        <p class="table-a__tit fl">Price List</p>
                        <div class="tab-v1 fl type-pd">
                            <ul class="tab-v1__list clb ml-20">
                                <li class="tab-v1__item fl {{$PATH == $check ?"is-active":""}} "><button type="button" class="tab-v1__btn" value="{{$PATH}}"><a href="{{ $PATH }}">전체요금표</a></button></li>
                                <li class="tab-v1__item fl {{$PATH.'/0' == $check ?"is-active":""}} "><button type="button" class="tab-v1__btn" value="{{$PATH}}/0"><a href="{{ $PATH }}/0">비수기</a></button></li>
                                @foreach($seasonList as $s)
                                    <li class="tab-v1__item fl {{$PATH.'/'.$s->id == $check ?"is-active":""}} "><button type="button" class="tab-v1__btn" id="{{$s->id}}" value="{{$PATH}}/{{$s->id}}"><a href="{{ $PATH }}/{{$s->id}}">{{$s->season_name}}</a></button></li>
                                @endforeach
                            </ul>
					</div>
                        <div class="table-a_inbox type-head fr">
                           <button type="button" class="btn-v1 js-pop-btn js-type-all-change">선택된 시즌 일괄변경</button>
                            <button type="submit" class="btn-v1">요금등록</button>
                        </div>

                    </div>
                    <input type="hidden" name="user_id" value="{{isset($user_id)?$user_id:""}}" />
                    {{csrf_field()}}
						<table class="table-a__table">
						 	<colgroup>
								<col width="">
								<col width="">
								<col width="">
								<col width="">
								<col width="">
								<col width="">
								<col width="">
								<col width="">
								<col width="">
								<col width="">
								<col width="">
						 	</colgroup>
							<tr class="table-a__tr type-th">
								<th class="table-a__th type-border" rowspan="2">그룹명</th>
								<th class="table-a__th type-border" colspan="3">객실</th>
								<th class="table-a__th type-border" colspan="4">객실 기본요금</th>
								<th class="table-a__th type-border" colspan="3">추가 인원 요금</th>
							</tr>
							<tr class="table-a__tr type-th type-line2">
								<th class="table-a__th type-border">기준</th>
								<th class="table-a__th type-border">객실명</th>
                                <th class="table-a__th type-border ta-l"><input type="checkbox" id="season_all" class="checkbox-v1"><label for="season_all">전체 선택(시즌)</label></th>
								<th class="table-a__th type-border">일요일</th>
								<th class="table-a__th type-border">주중</th>
								<th class="table-a__th type-border">금요일</th>
								<th class="table-a__th type-border">토요일<br><span>(공휴일 전날)</span></th>
								<th class="table-a__th type-border">성인</th>
								<th class="table-a__th type-border">아동</th>
								<th class="table-a__th type-border">유아</th>
							</tr>
                            @foreach($room as $r)
                                @foreach($season as $s)
                                    <tr class="table-a__tr">
                                        <td class="table-a__td gubun" >{{$r->type_name}}</td>
                                        <td class="table-a__td">{{$r->room_cnt_basic}}</td>
                                        <td class="table-a__td">{{$r->room_name}}</td>
                                        <td class="table-a__td ta-l"><input type="checkbox" class="checkbox-v1" name="all_price_{{$r->id}}_{{$s->id}}" id='all_price_{{$r->id}}_{{$s->id}}' value="all_price_{{$r->id}}_{{$s->id}}" /><label for="all_price_{{$r->id}}_{{$s->id}}">{{$s->season_name}}</label></td>
                                        <td class="table-a__td type-nobd"> <div class="input-wrap minw-75">
                                            <input type='text' size='9'  class="number input-v1" name='price[0][{{$r->id}}][{{$s->id}}]' id="price_0_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_0):0}}" />
                                        </div></td>
                                        <td class="table-a__td type-nobd">
                                        <div class="input-wrap minw-75">
                                            <input type='text' size='9'  class="number input-v1" name='price[1][{{$r->id}}][{{$s->id}}]' id="price_1_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_1):0 }}" />
                                        </div>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                           <div class="input-wrap minw-75">
                                            <input type='text' size='9'  class="number input-v1" name='price[5][{{$r->id}}][{{$s->id}}]' id="price_5_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_5):0}}" />
                                        </div></td>
                                        <td class="table-a__td type-nobd">
                                           <div class="input-wrap minw-75">
                                                <input type='text' size='9'  class="number input-v1" name='price[6][{{$r->id}}][{{$s->id}}]' id="price_6_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_6):0}}" />
                                            </div>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                        <div class="input-wrap minw-75">
                                            <input type='text' size='9'  class="number input-v1" name='price[11][{{$r->id}}][{{$s->id}}]' id="price_11_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_adult):0}}" />
                                        </div>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                            <div class="input-wrap minw-75">
                                                <input type='text' size='9'  class="number input-v1" name='price[12][{{$r->id}}][{{$s->id}}]' id="price_12_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_child):0}}" />
                                            </div>
                                        </td>
                                        <td class="table-a__td type-nobd">
                                        <div class="input-wrap minw-75">
                                            <input type='text' size='9'  class="number input-v1" name='price[13][{{$r->id}}][{{$s->id}}]' id="price_13_{{$r->id}}_{{$s->id}}" value="{{isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_baby):0}}" />
                                        </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </form>
                </div>

<!--                팝업-->
<!--    <div class="pop_up_price ">-->
    <div class="pop-module js-pop js-pop-all-change bld-pop">
		<div class="pop-module__wrap">
			<div class="pop-module__box">
				<div class="pop-module__inbox">
					<div class="pop-module__head clb">
						<span class="pop-module__tit fl">제목</span>
						<button type="button" class="pop-module__close fr js-pop-close">닫기</button>
					</div>
					<div class="pop-module__body">
						<div class="table-a noto">
							<table class="table-a__table">
								<tr class="table-a__tr type-th">
									<th class="table-a__th type-border" colspan="4">객실 기본요금</th>
									<th class="table-a__th type-border" colspan="3">추가 인원 요금</th>
								</tr>
								<tr class="table-a__tr type-th type-line2">
									<th class="table-a__th type-border pd-s">일요일</th>
									<th class="table-a__th type-border pd-s">주중</th>
									<th class="table-a__th type-border pd-s">금요일</th>
									<th class="table-a__th type-border pd-s">토요일<br>(공휴일 전날)</th>
									<th class="table-a__th type-border pd-s">성인</th>
									<th class="table-a__th type-border pd-s">아동</th>
									<th class="table-a__th type-border pd-s">유아</th>
								</tr>
								<tr class="table-a__tr">
									<td class="table-a__td type-nobd">
										<div class="input-wrap maxw-100">
											<input type="text" class="input-v1 number" name="insert_all_sunday" id="insert_all_sunday">
										</div>
									</td>
									<td class="table-a__td type-nobd">
										<div class="input-wrap maxw-100">
											<input type="text" class="input-v1 number" name="insert_all_weekday" id="insert_all_weekday">
										</div>
									</td>
									<td class="table-a__td type-nobd">
										<div class="input-wrap maxw-100">
											<input type="text" class="input-v1 number" name="insert_all_friday" id="insert_all_friday">
										</div>
									</td>
									<td class="table-a__td type-nobd">
										<div class="input-wrap maxw-100">
											<input type="text" class="input-v1 number" name="insert_all_saturday" id="insert_all_saturday">
										</div>
									</td>
									<td class="table-a__td type-nobd">
										<div class="input-wrap maxw-100">
											<input type="text" class="input-v1 number" name="insert_all_add_adult" id="insert_all_add_adult">
										</div>
									</td>
									<td class="table-a__td type-nobd">
										<div class="input-wrap maxw-100">
											<input type="text" class="input-v1 number" name="insert_all_add_child" id="insert_all_add_child">
										</div>
									</td>
									<td class="table-a__td type-nobd">
										<div class="input-wrap maxw-100">
											<input type="text" class="input-v1 number" name="insert_all_add_baby" id="insert_all_add_baby">
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="btn-wrap mt-10">
							<button type="button" class="btn-v4 type-save delete_module" onclick="type_season();">저장</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="dim">dim</div>
<!--    </div>-->

<script>

    $(document).ready(function(){
        $(".js-pop-btn.js-type-all-change").click(function(){
           
            
            $(".js-pop-all-change").removeClass("bld-pop");
            $(".dim").show();
        });
    });
    
    
    $(function () {
        $("input[id^='all_price_']").click(function(){
            seasonCheck();
        });
//        $('.pop_up_price').hide();
        $("#season_all").click(function () {
            if($(this).is(":checked")==true){
                $("input[name^='all_price']").each(function () {
                    $(this).prop("checked", true);
                });
            }else if($(this).is(":checked")==false){
                $("input[name^='all_price']").each(function () {
                    $(this).prop("checked", false);
                });
            }
            seasonCheck();
        });

        $(".js-pop-close").click(function (e) {
            $(".pop-module").addClass("bld-pop");
            $(".dim").fadeOut(300);
        }); //배경클릭

        $(".pop-module__inbox").click(function (e) {
            e.stopPropagation();
        });
        $(".pop-module").click(function () {
            $(".pop-module").addClass("bld-pop");
            $(".dim").fadeOut(300);
        });
	    $(".delete_module").click(function () {
            $(".pop-module").addClass("bld-pop");
            $(".dim").fadeOut(300);
        }); 
		
    })
	

    function seasonCheck() {
        $("input[id^='all_price_']").each(function () {
            if ($(this).prop("checked") == true) {
                $('.pop_up_price').show();
                $(".number").keyup(function () {
                    var number = $(this).val();
                    number = number.replace(/,/gi, "");
                    $(this).val(numberFormat(number));
                });
                return false;
            } else {
                $(".pop_up_price").hide();
            }
        });
    }
    function numberFormat(inputNumber) {
        return inputNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };
    function type_season(){
        $("input[id^='all_price_']").each(function () {
            if ($(this).prop("checked") == true){
                var all_price_value = $(this).val();
                var all_price_value = all_price_value.split(/_/gi);
                temp_price(all_price_value);
            }
        })
        $('.pop_up_price').hide();
        $("input:checkbox[id^='all_price_']").prop('checked',false);
        $('#insert_all_sunday').val(0);
        $('#insert_all_weekday').val(0);
        $('#insert_all_friday').val(0);
        $('#insert_all_saturday').val(0);
        $('#insert_all_add_adult').val(0);
        $('#insert_all_add_child').val(0);
        $('#insert_all_add_baby').val(0);
        $("#season_all").prop("checked", false);
    }

    function temp_price(all_price_value) {
        var z = all_price_value[2]+"_"+all_price_value[3];
        var insert_all_sunday = $('#insert_all_sunday').val();
        var insert_all_weekday = $('#insert_all_weekday').val();
        var insert_all_friday = $('#insert_all_friday').val();
        var insert_all_saturday = $('#insert_all_saturday').val();
        var insert_all_add_adult = $('#insert_all_add_adult').val();
        var insert_all_add_child = $('#insert_all_add_child').val();
        var insert_all_add_baby = $('#insert_all_add_baby').val();

        if(insert_all_sunday=="")insert_all_sunday =0;
        if(insert_all_weekday=="")insert_all_weekday=0;
        if(insert_all_friday=="")insert_all_friday=0;
        if(insert_all_saturday=="")insert_all_saturday=0;
        if(insert_all_add_adult=="")insert_all_add_adult=0;
        if(insert_all_add_child=="")insert_all_add_child=0;
        if(insert_all_add_baby=="")insert_all_add_baby=0;

        $("#price_0_"+z).val(insert_all_sunday);
        $("#price_1_"+z).val(insert_all_weekday);
        $("#price_5_"+z).val(insert_all_friday);
        $("#price_6_"+z).val(insert_all_saturday);
        $("#price_11_"+z).val(insert_all_add_adult);
        $("#price_12_"+z).val(insert_all_add_child);
        $("#price_13_"+z).val(insert_all_add_baby);
    }


</script>

<!--
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
-->
<!--
                    <tr>
                        <th colspan="3" style="text-align: center">객실</th>
                        <th colspan="4" style="text-align: center">객실 기본요금</th>
                        <th colspan="3" style="text-align: center">추가 인원 요금</th>
                    </tr>
-->
<!--
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
-->
<!--
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
-->
<!--
                </form>
            </table>
-->
        </div>
    </div>
</div>
<div class='many_price_insert'>
</div>
