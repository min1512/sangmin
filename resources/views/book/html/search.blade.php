@extends("book.html.layout")

@section("title")호텔헤이븐 예약시스템@endsection

@section("scripts")
    <script src="{{ url('https://code.jquery.com/jquery-2.2.4.min.js') }}" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="{{ url('https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#start-day").val('{{ date("Y-m-d") }}');
            $("#end-day").val('{{ date("Y-m-d",strtotime("+1 days")) }}');
            $("#cnt_adult").val("2");
            $("#cnt_child").val("0");
            chgRoomList();
        })



        $(function(){
            $("#btn-search").click(function(){
                chgRoomList();
            });
            $(document).on("click",".reserv-ban__delete",function(){
                $(this).parents("li.reserv-ban__item").remove();
            })
            $(document).on("click",".js-reserv-btn",function(){
                if($('#cart_'+$(this).data("id")).length>0){
                    return false;
                }
                var inHtml = '';
                inHtml += '<li class="reserv-ban__item" id="cart_'+$(this).data("id")+'">';
                inHtml += '<input type="hidden" name="goods_id[]" value="'+$(this).data("id")+'" />'
                inHtml += '<input type="hidden" name="goods_price[]" value="'+$("#goods_"+$(this).data("id")).data("price")+'" />';
                inHtml += '<input type="hidden" name="goods_price_list[]" value="'+$("#goods_"+$(this).data("id")).data("price_list")+'" />';
                inHtml += '<input type="hidden" name="reserve_term[]" value="'+$("#goods_"+$(this).data("id")).data("term")+'" />';
                    inHtml += '<div class="reserv-ban__inbox type-tit clb">';
                        inHtml += '<p class="reserv-ban__badge">객실<br>01</p>';
                        inHtml += '<p class="reserv-ban__tit ellipsis2">'+$("#goods_"+$(this).data("id")).data("goods")+'</p>';
                        inHtml += '<button type="button" class="reserv-ban__delete"></button>';
                    inHtml += '</div>';
                    inHtml += '<div class="ban-info">';
                        inHtml += '<ul class="ban-info__list">';
                            inHtml += '<li class="ban-info__item clb">';
                                inHtml += '<span class="ban-info__name fl">체크인</span>';
                                inHtml += '<span class="ban-info__val fr">'+$("#goods_"+$(this).data("id")).data("checkin")+'</span>';
                            inHtml += '</li>';
                            inHtml += '<li class="ban-info__item clb">';
                                inHtml += '<span class="ban-info__name fl">체크아웃</span>';
                                inHtml += '<span class="ban-info__val fr">'+$("#goods_"+$(this).data("id")).data("checkout")+'</span>';
                            inHtml += '</li>';
                            inHtml += '<li class="ban-info__item clb">';
                                inHtml += '<span class="ban-info__name fl">숙박일</span>';
                                inHtml += '<span class="ban-info__val fr">'+$("#goods_"+$(this).data("id")).data("term")+'박</span>';
                            inHtml += '</li>';
                            inHtml += '<li class="ban-info__item clb">';
                                inHtml += '<span class="ban-info__name fl">인원</span>';
                                inHtml += '<span class="ban-info__val fr">성인'+$("#goods_"+$(this).data("id")).data("cnt_adult")+',아동'+($("#goods_"+$(this).data("id")).data("cnt_child")?$("#goods_"+$(this).data("id")).data("cnt_child"):0)+'</span>';
                            inHtml += '</li>';
                            inHtml += '<li class="ban-info__item clb">';
                                inHtml += '<span class="ban-info__name fl">객실료</span>';
                                inHtml += '<span class="ban-info__val fr">'+$("#goods_"+$(this).data("id")).data("price").format()+'원</span>';
                            inHtml += '</li>';
                        inHtml += '</ul>';
                        inHtml += '<div class="ban-info__inbox type-price clb">';
                            inHtml += '<span class="ban-info__name type-price fl">전체합계</span>';
                            inHtml += '<span class="ban-info__val type-price fr">200,000원</span>';
                        inHtml += '</div>';
                    inHtml += '</div>';
                inHtml += '</li>';

                $("ul.reserv-ban__list").append(inHtml);
            });
        });

        function chgRoomList() {
            var checkDateSt = $("#start-day").val();
            var checkDateEn = $("#end-day").val();
            var checkAdult = $("#cnt_adult").val();
            var checkChild = $("#cnt_child").val();
            $.post(
                "{{ route('html.search.ajax',['id'=>$id, 'token'=>$token]) }}"
                ,{
                    _token: "{{ csrf_token() }}"
                    , checkDateSt: checkDateSt
                    , checkDateEn: checkDateEn
                    , checkAdult: checkAdult
                    , checkChild: checkChild
                }
                ,function(data){
                    var html = '';
                    for(var i in data.goods){
                        var item = data.goods[i];
                        var tmp_yoil = item.yoil.split(',');
                        var tmp_price = 0;
                        var tmp_price_unit = new Array();
                        for(var t in tmp_yoil){
                            var tmpItem = tmp_yoil[t];
                            tmp_price = parseInt(tmp_price) + parseInt(eval("item.goods_price_sales_"+tmpItem));
                            tmp_price_unit.push(eval("item.goods_price_sales_"+tmpItem));
                        }

                        html += '<li class="reserv-room__item" id="goods_'+item.id+'"' +
                            ' data-goods="'+item.goods_name+'"' +
                            ' data-checkin="'+checkDateSt+'"' +
                            ' data-checkout="'+checkDateEn+'"' +
                            ' data-term="'+item.dayTerm+'"' +
                            ' data-cnt_adult="'+checkAdult+'"' +
                            ' data-cnt_child="'+checkChild+'"' +
                            ' data-price="'+(tmp_price===false?0:tmp_price.format())+'"' +
                            ' data-price_list="'+tmp_price_unit.join(',')+'" ' +
                            '>';
                            html += '<div class="per-room clb">';
                                html += '<div class="per-room__img fl  m-col-1" style="background:url(\'/data/'+item.thumbnail+'\') no-repeat center center/cover"></div>';
                                html += '<div class="room-info fr m-col-1 ">';
                                html += '<ul class="room-info__list ">';
                                    html += '<li class="room-info__item clb">';
                                        html += '<p class="room-info__name fl type-tit">상품<br>구성</p>';
                                        html += '<div class="room-info__val fl">';
                                            html += '<p class="room-info__inbox type-tit">';
                                                html += '<span class="room-info__tit">'+item.goods_name+'</span>';
                                                html += '<br>';
                                                html += '<span class="room-info__sub">(객실 + 조식 + 커뮤니티)</span>';
                                            html += '</p>';
                                            html += '<span class="room-info__info type-default type-sub">기준&nbsp;&nbsp;';
                                            for(var c=1; c<=item.room_cnt_basic; c++){
                                                html += '<i class="fas fa-user-alt" style="color:#333;"></i>';
                                            }
                                            html += '</span> ';
                                            html += '<span class="room-info__info type-default type-sub">최대&nbsp;&nbsp;';
                                            for(var c=1; c<=item.room_cnt_max; c++){
                                                html += '<i class="fas fa-user-alt" style="color:#333;"></i>';
                                            }
                                            html += '</span>';
                                            html += '<span class="room-info__info type-size type-sub">'+item.room_area+'㎡</span>';
                                        html += '</div>';
                                    html += '</li>';
                                    html += '<li class="room-info__item clb">';
                                        html += '<p class="room-info__name fl type-tit">인원</p>';
                                        html += '<div class="room-info__val fl">';
                                            html += '<div class="room-info__selects">';
                                                html += '<div class="select-v1 type-grey room-info__select type-left" style="">';
                                                    html += '<label for="" class="select-v1__label">성인</label>';
                                                    html += '<select name="goods_cnt_adult[]" id="" class="select-v1__select">';
                                                    for(var c=1; c<=item.room_cnt_max; c++) {
                                                        html += '<option value="'+c+'" class="select-v1__option" '+(checkAdult==c?"selected":"")+'>'+c+'명</option>';
                                                    }
                                                    html += '</select>';
                                                html += '</div>';
                                                html += '<div class="select-v1 type-grey room-info__select type-right" style="">';
                                                    html += '<label for="" class="select-v1__label">아동</label>';
                                                    html += '<select name="goods_cnt_child[]" id="" class="select-v1__select">';
                                                    for(var c=0; c<item.room_cnt_max; c++) {
                                                        html += '<option value="'+c+'" class="select-v1__option"'+(checkChild==c?"selected":"")+'>'+c+'명</option>';
                                                    }
                                                    html += '</select>';
                                                html += '</div>';
                                            html += '</div>';
                                        html += '</div>';
                                    html += '</li>';
                                    html += '<li class="room-info__item type-price clb">';
                                        html += '<p class="room-info__name fl type-price">';
                                        html += '객실료';
                                        html += '<br class="mo-item">';
                                        html += '<span class="room-info__mo-info mo-item">'+item.dayTerm+'박 / 세금포함</span>';
                                        html += '</p>';
                                        html += '<div class="room-info__val fl clb">';
                                            html += '<span class="room-info__info fl type-price">'+item.dayTerm+'박 / 세금포함</span>';
                                            html += '<p class="room-info__inbox type-price fr">';
                                                html += '<span class="room-info__won">KRW</span>';
                                                html += '<span class="room-info__price">'+(tmp_price===false?0:tmp_price.format())+'</span>';
                                            html += '</p>';
                                        html += '</div>';
                                    html += '</li>';
                                html += '</ul>';
                                html += '<button type="button" class="btn-v3 room-info__btn js-reserv-btn" data-id='+item.id+'>객실<br class="pc-item">예약하기</button>';
                            html += '</div>';
                        html += '</div>';
                        html += '<div class="per-service">';
                            html += '<div class="per-service__inbox type-tit clb">';
                                html += '<span class="per-service__tit">SERVICE & AMENITY</span>';
                                html += '<span class="per-service__sub">지구살리기 일환으로 일회용품 사용 자제를 위하여, 칫솔, 치약 면도기는 제공해 드리지 않습니다</span>';
                            html += '</div>';
                            html += '<div class="per-service__inbox type-body">';
                                html += '<ul class="per-service__list clb">';
                                    if(item.service!=null) var tmp_service = item.service.split(','); else var tmp_service = new Array();
                                    if(item.amenity!=null) var tmp_amenity = item.amenity.split(','); else var tmp_amenity = new Array();
                                    for(var s in tmp_service){
                                        html += '<li class="per-service__item fl type-wifi"><span class="per-service__span">'+tmp_service[s]+'</span></li>';
                                    }
                                    for(var a in tmp_amenity){
                                        html += '<li class="per-service__item fl type-wifi"><span class="per-service__span">'+tmp_amenity[a]+'</span></li>';
                                    }
                                    // html += '<li class="per-service__item fl type-wifi"><span class="per-service__span">WI-FI</span></li>';
                                    // html += '<li class="per-service__item fl type-tv"><span class="per-service__span">TV</span></li>';
                                    // html += '<li class="per-service__item fl type-bed"><span class="per-service__span">침대</span></li>';
                                    // html += '<li class="per-service__item fl type-make"><span class="per-service__span">화장대</span></li>';
                                    // html += '<li class="per-service__item fl type-table"><span class="per-service__span">테이블</span></li>';
                                    // html += '<li class="per-service__item fl type-chair"><span class="per-service__span">의자</span></li>';
                                    // html += '<li class="per-service__item fl type-refri"><span class="per-service__span">냉장고</span></li>';
                                    // html += '<li class="per-service__item fl type-pot"><span class="per-service__span">전기포트기</span></li>';
                                    // html += '<li class="per-service__item fl type-coffee"><span class="per-service__span">커피</span></li>';
                                    // html += '<li class="per-service__item fl type-tea"><span class="per-service__span">티백</span></li>';
                                    // html += '<li class="per-service__item fl type-mug"><span class="per-service__span">머그컵</span></li>';
                                    // html += '<li class="per-service__item fl type-amen"><span class="per-service__span">어메니티</span></li>';
                                    // html += '<li class="per-service__item fl type-dry"><span class="per-service__span">드라이기</span></li>';
                                    // html += '<li class="per-service__item fl type-closet"><span class="per-service__span">옷장</span></li>';
                                    // html += '<li class="per-service__item fl type-hanger"><span class="per-service__span">옷걸이</span></li>';
                                    // html += '<li class="per-service__item fl type-toilet"><span class="per-service__span">화장실</span></li>';
                                    // html += '<li class="per-service__item fl type-gawn"><span class="per-service__span">목욕가운</span></li>';
                                    // html += '<li class="per-service__item fl type-towel"><span class="per-service__span">수건</span></li>';
                                    // html += '<li class="per-service__item fl type-slip"><span class="per-service__span">객실슬리퍼</span></li>';
                                    // html += '<li class="per-service__item fl type-bathslip"><span class="per-service__span">욕실슬리퍼</span></li>';
                                html += '</ul>';
                            html += '</div>';
                        html += '</li>';
                    }
                    $("ul.reserv-room__list").html(html);
                }
                ,"json"
            );
        }
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="reserv">
    {{-- 헤더에 변수 처리할 예정 --}}
    @include("book.html._header")

    <!-- 헤더끝 -->
        <form method="post" name="frmOrder" action="{{route('html.search',['id'=>$id])}}?token={{$token}}">
        {{csrf_field()}}
        <div class="reserv__body">
            <section class="reserv__section type-cal">
                <div class="reserv__wrap">
                    <div class="r-calendar">
                        <div class="r-calendar__wrap">
                            <ul class="r-calendar__list clb">
                                <li class="r-calendar__item type-input fl m-col-1">
                                    <div class="r-calendar__inbox type-blue">
                                        <p class="r-calendar__tit">날짜 및 인원 선택</p>
                                        <div class="r-calendar__inner">
                                            <div class="input-v2 clb">
                                                <label for="start-day" class="input-v2__label fl">체크인</label>
                                                <input type="text" name="checkin" class="input-v2__input fr js-mo-btn" id="start-day" value="{{ date("Y-m-d") }}" />
                                            </div>
                                            <div class="input-v2 clb">
                                                <label for="end-day" class="input-v2__label fl">체크아웃</label>
                                                <input type="text" name="checkout" class="input-v2__input fr js-mo-btn" id="end-day" value="{{ date("Y-m-d",strtotime("+1 days")) }}" />
                                            </div>
                                        </div>
                                        <div class="r-calendar__selects">
                                            <div class="select-v1 r-calendar__select type-left" style="">
                                                <label for="cnt_adult" class="select-v1__label">성인</label>
                                                <select name="cnt_adult" id="cnt_adult" class="select-v1__select">
                                                    <option value="1" class="select-v1__option">1명</option>
                                                    <option value="2" class="select-v1__option" selected >2명</option>
                                                    <option value="3" class="select-v1__option">3명</option>
                                                    <option value="4" class="select-v1__option">4명</option>
                                                    <option value="5" class="select-v1__option">5명</option>
                                                </select>
                                            </div>
                                            <div class="select-v1 r-calendar__select type-right" style="">
                                                <label for="cnt_child" class="select-v1__label">아동</label>
                                                <select name="cnt_child" id="cnt_child" class="select-v1__select">
                                                    <option value="1" class="select-v1__option" selected >0명</option>
                                                    <option value="1" class="select-v1__option">1명</option>
                                                    <option value="2" class="select-v1__option">2명</option>
                                                    <option value="3" class="select-v1__option">3명</option>
                                                    <option value="4" class="select-v1__option">4명</option>
                                                    <option value="5" class="select-v1__option">5명</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class=" r-calendar__btn">
                                            <button type="button" class="btn-v2" id="btn-search">
                                                <span class="btn-v2__span">조회하기</span>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <li class="r-calendar__item type-cal fl js-cal-box">
                                    <div class="r-calendar__inbox type-cal">
                                        <div class="r-calendar__box">
                                            <div class="r-calendar-header">
                                                <p class="r-calendar-header__tit">날짜 선택하기</p>
                                                <span class="r-calendar-header__close js-close-cal"></span>
                                                <div class="r-calendar-header__inbox">
                                                    <ul class="r-calendar-header__list clb">
                                                        <li class="r-calendar-header__item type-sun fl">일</li>
                                                        <li class="r-calendar-header__item fl">월</li>
                                                        <li class="r-calendar-header__item fl">화</li>
                                                        <li class="r-calendar-header__item fl">수</li>
                                                        <li class="r-calendar-header__item fl">목</li>
                                                        <li class="r-calendar-header__item fl">금</li>
                                                        <li class="r-calendar-header__item fl type-sat">토</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <input type="hidden" class="saira pop-head2__input" id="demo-3_1" value="{{date("Y-m-d")}}" />
                                            <input type="hidden" class="saira pop-head2__input" id="demo-3_2" value="{{date("Y-m-d",strtotime("+1 days"))}}" />
                                            <button type="button" class="r-calendar-header__btn js-close-cal">선택완료</button>
                                        </div>
                                    </div>
                                </li>
                                <li class="r-calendar__item type-fac fl ">
                                    <div class="r-calendar__inbox type-fac">
                                        <div class="r-calendar__inner type-add clb">
                                            <p class="r-calendar__info fl">
                                                <span class="r-calendar__info-name">호텔명: </span>
                                                <span class="r-calendar__info-val">호텔 헤이븐</span>
                                            </p>
                                            <p class="r-calendar__info fl">
                                                <span class="r-calendar__info-name">문의전화: </span>
                                                <span class="r-calendar__info-val">061-643-7777</span>
                                            </p>
                                            <p class="r-calendar__info fl">
                                                <span class="r-calendar__info-name">주소: </span>
                                                <span class="r-calendar__info-val">전라남도 여수시 돌산읍 진두해안길 131</span>
                                            </p>
                                        </div>
                                        <div class="r-calendar__inner type-fac clb pc-item">
                                            <p class="fac-list__tit fl">부대<br>시설</p>
                                            <div class="fac-list fr">
                                                <ul class="fac-list__list clb">
                                                    @foreach($client['facility'] as $cf)
                                                    <li class="fac-list__item fl">
                                                        <div class="fac-list__inbox {{ $cf->code_icon }}">
                                                            <span class="fac-list__span">{{ $cf->code_name }}</span>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <section class="reserv__section type-rooms">
            <div class="reserv__wrap">
                <div class="reserv__inbox type-head clb">
                    <p class="reserv__tit fl">01 객실정보</p>
                    <div class="reserv__right fr">
                        <button type="button" class="reserv__order on">가격순</button>
                        <button type="button" class="reserv__order">이름순</button>
                    </div>
                </div>
                <div class="reserv-room">
                    <ul class="reserv-room__list"></ul>
                </div>


            </div>
        </section>
        <section class="reserv__section type-customer">
            <div class="reserv__wrap">
                <div class="reserv__inbox type-head clb">
                    <p class="reserv__tit fl">02 기본 투숙객 정보 입력</p>
                </div>
                <div class="reserv__inbox type-body">
                    <div class="reserv-form">
                        <div class="reserv-form__inbox type-line type-top">
                            <ul class="reserv-form__list">
                                <li class="reserv-form__item clb">
                                    <div class="reserv-form__name">투숙객</div>
                                    <div class="reserv-form__val"><input type="text" name="reserve_name" class="input-v1" placeholder="투숙객" required></div>
                                </li>
                                <li class="reserv-form__item clb">
                                    <div class="reserv-form__name">이메일</div>
                                    <div class="reserv-form__val">
                                        <div class="input-wrap">
                                            <div class="input-wrap__inbox type-33">
                                                <input type="text" name="reserve_email_id" class="input-v1" placeholder="" required />
                                            </div>
                                            <div class="input-wrap__inbox type-33 type-mail">
                                                <input type="text" class="input-v1" name="reserve_email_addr" placeholder="" required />
                                            </div>
                                            <div class="input-wrap__inbox type-33">
                                                <select name="reserve_email_addr" id="" class="select-v2">
                                                    <option value="">::이메일선택::</option>
                                                    <option value="daum.net">daum.net</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="reserv-form__item clb">
                                    <div class="reserv-form__name">휴대폰</div>
                                    <div class="reserv-form__val">
                                        <div class="input-wrap">
                                           <div class="input-wrap__inbox type-33">+
												<select name="reserve_hp[]" id="" class="select-v2" required>
                                                    <option value="010">010</option>
                                                    <option value="011">011</option>
                                                    <option value="016">016</option>
                                                    <option value="017">017</option>
                                                    <option value="018">018</option>
                                                    <option value="019">019</option>
                                                    <option value="070">070</option>
												</select>
											</div>
                                            <div class="input-wrap__inbox type-33 type-phone">
                                                <input type="text" name="reserve_hp[]" class="input-v1" placeholder="" required />
                                            </div>
                                            <div class="input-wrap__inbox type-33 type-phone">
                                                <input type="text" name="reserve_hp[]" class="input-v1" placeholder="" required />
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="reserv-form__item clb">
                                    <div class="reserv-form__name">요청사항</div>
                                    <div class="reserv-form__val">
                                        <textarea name="reserve_request" rows="3" cols="80" class="textarea-v1"></textarea>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="reserv-form__inbox type-line type-bottom">
                            <ul class="reserv-form__list">
                                <li class="reserv-form__item clb">
                                    <div class="reserv-form__name type-2">결제 방법 선택</div>
                                    <div class="reserv-form__val">
                                        <div class="reserv-form__inner type-val type-top">
                                            <div class="reserv-form__radio1">
                                                <input type="radio" name="reserve_scene" id="reserve_scene_N" class="radio-v1" value="N" checked />
                                                <label for="reserve_method_card">바로결제</label>
                                            </div>
                                            <div class="reserv-form__radio1">
                                                <input type="radio" name="reserve_scene" id="reserve_scene_Y" class="radio-v1" value="Y" />
                                                <label for="reserve_method_scene">현장결제</label>
                                            </div>
                                        </div>
                                        <div class="reserv-form__inner type-val type-top">
                                            <ul class="radio-v2__list">
                                                <li class="radio-v2__item">
                                                    <input type="radio" name="reserve_method" id="reserve_method_card" class="radio-v2" value="card" checked />
                                                    <label for="reserve_method_card"><span class="radio-v2__span type-card">카드결제</span></label>
                                                </li>
                                                <li class="radio-v2__item">
                                                    <input type="radio" name="reserve_method" id="reserve_method_account" class="radio-v2" value="account" />
                                                    <label for="reserve_method_account"><span class="radio-v2__span type-won">무통장입금</span></label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="reserv-form__item clb">
                                    <div class="reserv-form__name type-2">예약조회 시 비밀번호</div>
                                    <div class="reserv-form__val">
                                        <div class="input-pw">
                                            <ul class="input-pw__list">
                                                <li class="input-pw__item">
                                                    <input type="password" name="password" class="input-v1" placeholder="비밀번호" />
                                                </li>
                                                <li class="input-pw__item">
                                                    <input type="password" name="password2" class="input-v1" placeholder="비밀번호 확인" />
                                                </li>
                                            </ul>
                                            <span class="input-pw__info">* 예약 조회 시 사용할 비밀번호를 입력해 주세요.</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="reserv-form__inbox type-check">
                            <ul class="reserv-form__list">
                                <li class="reserv-form__item clb">
                                    <div class="reserv-form__name type-2 type-check">개인정보 수집 동의</div>
                                    <div class="reserv-form__val type-check">
                                        <ul class="checkbox-list__list">
                                            <li class="checkbox-list__item">
                                                <input type="checkbox" name="chkAll1" id="chkAll-1" class="checkbox-v1 js-all-checkbox"><label for="chkAll-1">전체 동의</label>
                                            </li>
                                            <li class="checkbox-list__item">
                                                <input type="checkbox" name="agreement_1" id="chkAll-2" class="checkbox-v1 js-per-checkbox" required><label for="chkAll-2">개인정보 수집 및 이용 목적 동의 (필수)</label>
                                                <a href="" class="checkbox-list__link fr">전문보기</a>
                                            </li>
                                            <li class="checkbox-list__item">
                                                <input type="checkbox" name="agreement_2" id="chkAll-4" class="checkbox-v1 js-per-checkbox" required><label for="chkAll-4">개인 정보의 제 3자 제공 동의 (필수)</label>
                                                <a href="" class="checkbox-list__link fr">전문보기</a>
                                            </li>
                                            <li class="checkbox-list__item">
                                                <input type="checkbox" name="agreement_3" id="chkAll-3" class="checkbox-v1 js-per-checkbox"><label for="chkAll-3">광고성 정보 수신 동의 (선택)</label>
                                                <a href="" class="checkbox-list__link fr">전문보기</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="reserv-form__bottom">
                        <button type="submit" class=" btn-v4 reserv-form__btn">예약하기</button>
                        <p class="reserv-form__info">본 예약 화면은 (주)이아이넷의 예약시스템에서 제공 받고 있습니다.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="reserv__section type-info">
            <div class="reserv__wrap">
                <div class="reserv-refund">
                    <p class="reserv-refund__tit">환불규정</p>
                    <div class="reserv-refund__body">
                        <ul class="reserv-refund__list">
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">8일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">0%<br class="mo-item"> 패널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">7일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">50%<br class="mo-item"> 페널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">6일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">50%<br class="mo-item"> 패널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">5일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">80%<br class="mo-item"> 패널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">4일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">80%<br class="mo-item"> 패널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">3일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">80%<br class="mo-item"> 패널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">2일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">80%<br class="mo-item"> 패널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">1일전<br class="mo-item"> 취소</p>
                                <p class="reserv-refund__bottom">100%<br class="mo-item"> 패널티</p>
                            </li>
                            <li class="reserv-refund__item">
                                <p class="reserv-refund__top">입실<br class="mo-item"> 당일</p>
                                <p class="reserv-refund__bottom">100%<br class="mo-item"> 패널티</p>
                            </li>
                        </ul>
                        <p class="reserv-refund__info">* 패널티 적용 기준시간 00:00</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- 윙배너 -->
        <div class="reserv-ban js-wing-ban">
            <div class="reserv-ban__body">
                <div class="reserv-ban__head">선택된 예약</div>
                <div class="reserv-ban__scroll scroll1">
                    <ul class="reserv-ban__list">
                    </ul>
                </div>
            </div>
            <button class="btn-v4 reserv-ban__btn">투숙객 정보 입력</button>
        </div>
        </form>
        @include("book.html._footer")

    </div>



{{--여기부터는 이전 개발 내용 참고용--}}
    <form method="post" name="frmOrder" action="{{route('html.search',['id'=>$id])}}?token={{$token}}">
        {{csrf_field()}}
        @foreach($goods as $g)
            <input type="checkbox" name="order[]" value="{{$g->id}}" />{{$g->goods_name}}
            <p>
                노출: {{$g->cnt_except}}
                , 룸명: {{$g->room_name}}
                , 패키지명: {{$g->goods_name}}
                , 판매가격: {{$g->goods_price_origin}}
                , 할인가격: {{$g->goods_price_sales}}
                , 구비시설: {{$g->amenity}}
                , 서비스: {{$g->service}}
                , 면적: {{$g->room_area}}㎡
                , 인원: {{$g->room_cnt_min}} / {{$g->room_cnt_basic}} / {{$g->room_cnt_max}}
            </p>
            @php
                $amenity = explode(",",$g->amenity);
                $service = explode(",",$g->service);
            @endphp
            @if(isset($amenity) && sizeof($amenity)>0)
                <ul>
                    @foreach($amenity as $a)
                        @if($a!="")
                            <li>{{ \App\Http\Controllers\Controller::getCodeName($a) }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif
            @if(isset($service) && sizeof($service)>0)
                <ul>
                    @foreach($service as $s)
                        @if($s!="")
                            <li>{{ \App\Http\Controllers\Controller::getCodeName($s) }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif
            @foreach($pics[$g->room_id] as $img)
                <img src="/data/{{$img->path}}" style="width:300px; height:300px; " />
            @endforeach
        @endforeach
        <input type="radio" name="charge_method" value="card" checked />카드
        <input type="radio" name="charge_method" value="account" />무통장
        <input type="radio" name="charge_method" value="scene" />현장결제
        <button type="submit" id="btnOrder">예약하기</button>
    </form>
    @php $ymd = date("YmdHis") @endphp
    {{--<form method="post" accept-charset="EUC-KR" action="https://web.nicepay.co.kr/v3/v3Payment.jsp"> <!--모바일-->--}}
    <form method="post" name="nicepay" accept-charset="EUC-KR" action="https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js" target="_blank"> <!--PC-->
        <input type="hidden" name="GoodsName" value="상품명" /><!--결제상품명-->
        <input type="hidden" name="Amt" value="1004" /><!--금액-->
        <input type="hidden" name="MID" value="IMPpensi1m" /><!--상점ID-->
        <input type="hidden" name="EdiDate" value="{{$ymd}}" /><!--요청시간-->
        <input type="hidden" name="Moid" value="" /><!--주문번호-->
        <input type="hidden" name="SignData" value="{{ bin2hex(hash('sha256', $ymd."IMPpensi1m"."1004"."k2GiPBcpkMebbREl2Wjt+SUlqEpJ8DM7V+9kkM8wsNx/1yldkoqLHVIpiASIHl2Qap31xCm5yAgpa2KWY7hjGw==", true)) }}" /><!--위변조코드 hex(sha256(EdiDate + MID + Amt + MerchantKey))-->

        <input type="hidden" name="BuyerName" value="주병훈" /><!--구매자명-->
        <input type="hidden" name="BuyerTel" value="01036613451" /><!--구매자연락처-->
        <input type="hidden" name="ReturnURL" value="" /><!--요청응답URL-->
        <input type="hidden" name="PayMethod" value="CARD" /><!--결제방법(CARD,BANK,VBANK,CELLPHONE) 중복사용 콤마이용-->
        <input type="hidden" name="ReqReserved" value="" /><!--가맹점여분필드-->
        <input type="hidden" name="BuyerEmail" value="" /><!--구매자메일주소-->
        <input type="hidden" name="CharSet" value="utf-8" /><!--인증응답인코딩(euc-kr/utf-8)-->
        {{--    <input type="submit" value="테스트결제" />--}}
        <button type="button" onclick="goPay(document.nicepay);">테스트결제</button>
    </form>
@endsection

