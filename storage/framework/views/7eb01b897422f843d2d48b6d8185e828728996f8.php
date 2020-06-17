<div class="row ">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body">
            <h5 class="card-title bld">Search</h5>
            <form method="get" action="<?php echo e(url()->current()); ?>">
               <div class="clb content-search">
                   <ul class="content-search__list">
                       <li class="content-search__item fl">
                           <div class="select-wrap w-170">
							<select  name="search1" id="search1" class="select-v1 noto">
								<option value="client_list" <?php echo e(isset($search['search1'])&&$search['search1']=="client_list"?"selected":""); ?>>Client List
                                <option value="room_list" <?php echo e(isset($search['search1'])&&$search['search1']=="room_list"?"selected":""); ?>>Room List
							</select>
						</div>
                       </li>
                       <li class="content-search__item fl">
                           <div class="select-wrap w-170">
							<select name='search2' id='search2' class="select-v1 noto">
								 <option id="default" value="" selected>==선택하세요==</option>
                                <option id="client_list_search_menu1" value="search_group" <?php echo e(isset($search['search2'])&&$search['search2']=="search_group"?"selected":""); ?>>그룹명
                                <option id="client_list_search_menu2" value="search_num" <?php echo e(isset($search['search2'])&&$search['search2']=="search_num"?"selected":""); ?> >판매객실수
                                <option id="client_list_search_menu3" value="search_basic" <?php echo e(isset($search['search2'])&&$search['search2']=="search_basic"?"selected":""); ?> >기준
                                <option id="client_list_search_menu4" value="search_max" <?php echo e(isset($search['search2'])&&$search['search2']=="search_max"?"selected":""); ?>>최대
                                <option id="room_list_search_menu1" value="search_room_name" <?php echo e(isset($search['search2'])&&$search['search2']=="search_room_name"?"selected":""); ?> >객실명
                                <option id="room_list_search_menu2" value="search_realtime" <?php echo e(isset($search['search2'])&&$search['search2']=="search_realtime"?"selected":""); ?> >실시간 예약
                                <option id="room_list_search_menu3" value="search_online" <?php echo e(isset($search['search2'])&&$search['search2']=="search_online"?"selected":""); ?> >온라인 예약
							</select>
						</div>
                       </li>
                       <li class="content-search__item fl clb">
                        <div class="input-wrap w-170">
						    <input type="text" class="input-v1 va-m" name="search_board" id="search_board" value="<?php echo e(isset($search['search_board'])&&$search['search_board']!=""?$search['search_board']:""); ?>">
					    </div>
                      <button type="submit" class="btn-v3 type-black type-search va-m">검색</button>
                       </li>
                   </ul>
               </div>
<!--
                <table class="mb-0 table">
                    <tr>
                        <td>
                            <select name="search1" id="search1">
                                <option value="client_list" <?php echo e(isset($search['search1'])&&$search['search1']=="client_list"?"selected":""); ?>>Client List
                                <option value="room_list" <?php echo e(isset($search['search1'])&&$search['search1']=="room_list"?"selected":""); ?>>Room List
                            </select>
                        </td>
                        <td>
                            <select name='search2' id='search2'>
                                <option id="default" value="" selected>==선택하세요==</option>
                                <option id="client_list_search_menu1" value="search_group" <?php echo e(isset($search['search2'])&&$search['search2']=="search_group"?"selected":""); ?>>그룹명
                                <option id="client_list_search_menu2" value="search_num" <?php echo e(isset($search['search2'])&&$search['search2']=="search_num"?"selected":""); ?> >판매객실수
                                <option id="client_list_search_menu3" value="search_basic" <?php echo e(isset($search['search2'])&&$search['search2']=="search_basic"?"selected":""); ?> >기준
                                <option id="client_list_search_menu4" value="search_max" <?php echo e(isset($search['search2'])&&$search['search2']=="search_max"?"selected":""); ?>>최대
                                <option id="room_list_search_menu1" value="search_room_name" <?php echo e(isset($search['search2'])&&$search['search2']=="search_room_name"?"selected":""); ?> >객실명
                                <option id="room_list_search_menu2" value="search_realtime" <?php echo e(isset($search['search2'])&&$search['search2']=="search_realtime"?"selected":""); ?> >실시간 예약
                                <option id="room_list_search_menu3" value="search_online" <?php echo e(isset($search['search2'])&&$search['search2']=="search_online"?"selected":""); ?> >온라인 예약
                            </select>
                        </td>
                        <td>
                            <input type="text" name="search_board" id="search_board" value="<?php echo e(isset($search['search_board'])&&$search['search_board']!=""?$search['search_board']:""); ?>">
                        </td>
                        <td>
                            <button type="submit" class="mr-2 btn-transition btn btn-outline-dark">검색</button>
                        </td>
                    </tr>
                </table>
-->
            </form>
        </div>
    </div>
</div>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/etc_search.blade.php ENDPATH**/ ?>