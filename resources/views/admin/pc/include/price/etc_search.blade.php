<script>
    $(function () {
        $('.va-m').click(function () {
            var search_board =$('#search_board').val();
            var search2 = $('#search2').val();
            if(search_board != "" && search2 ==""){
                alert("검색 조건을 지정 해주세요");
                return false;
            }
        })
    })
</script>

<div class="row fl between-32" style="width:48%;min-width:460px;">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body">
            <h5 class="card-title bld">Search</h5>
            <form method="get" action="{{url()->current()}}">
               <div class="clb content-search">
                   <ul class="content-search__list">
{{--                       <li class="content-search__item fl">--}}
{{--                           <div class="select-wrap w-170">--}}
{{--							<select  name="search1" id="search1" class="select-v1 noto">--}}
{{--								<option value="client_list" {{ isset($search['search1'])&&$search['search1']=="client_list"?"selected":"" }}>Client List--}}
{{--                                <option value="room_list" {{ isset($search['search1'])&&$search['search1']=="room_list"?"selected":"" }}>Room List--}}
{{--							</select>--}}
{{--						</div>--}}
{{--                       </li>--}}
                       <li class="content-search__item fl">
                           <div class="select-wrap w-170">
							<select name='search2' id='search2' class="select-v1 noto">
								 <option id="default" value="" selected>==선택하세요==</option>
                                <option id="client_list_search_menu1" value="search_group" {{ isset($search['search2'])&&$search['search2']=="search_group"?"selected":"" }}>그룹명
                                <option id="client_list_search_menu2" value="search_num" {{ isset($search['search2'])&&$search['search2']=="search_num"?"selected":"" }} >판매객실수
                                <option id="client_list_search_menu3" value="search_basic" {{ isset($search['search2'])&&$search['search2']=="search_basic"?"selected":"" }} >기준
                                <option id="client_list_search_menu4" value="search_max" {{ isset($search['search2'])&&$search['search2']=="search_max"?"selected":"" }}>최대

							</select>
						</div>
                       </li>
                       <li class="content-search__item fl clb">
                        <div class="input-wrap w-170">
						    <input type="text" class="input-v1 va-m" name="search_board" id="search_board" value="{{ isset($search['search_board'])&&$search['search_board']!=""?$search['search_board']:"" }}">
					    </div>
                      <button type="submit" class="btn-v3 type-black type-search va-m">검색</button>
                       </li>
                   </ul>
               </div>
            </form>
        </div>
    </div>
</div>
