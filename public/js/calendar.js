/**
 * http://회사URL
 * CopyRight Reservation System from Einet co.
 *
 * Made By Einet.co.kr
 * Email: jubh03@einet.co.kr
 * Tel: +82 10 3661 3451
 */

//모바일/PC체크
function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

/** Query String Script **/
var brand_id = "br";
var scripts = document.getElementsByTagName('script');
var myScript = scripts[ scripts.length - 1 ];
var queryString = myScript.src.replace(/^[^\?]+\??/,'');
var params = parseQuery( queryString );

window.onload = function (){
    //callApi(params.key);
    var tmp_date = new Date();
    if(!isMobile()) makeCalendar(params.key, tmp_date.getFullYear(), tmp_date.getMonth(), params.target_id, "step01");
    //else mobileSearch(params.key, tmp_date.getFullYear(), tmp_date.getMonth()+1, tmp_date.getDate());
};

var pg_method = new Array();
pg_method["card"] = "카드결제";
pg_method["account"] = "무통장";

function parseQuery ( query ) {
    var Params = new Object ();
    if ( ! query ) return Params; // return empty object
    var Pairs = query.split(/[;&]/);
    for ( var i = 0; i < Pairs.length; i++ ) {
        var KeyVal = Pairs[i].split('=');
        if ( ! KeyVal || KeyVal.length != 2 ) continue;
        var key = unescape( KeyVal[0] );
        var val = unescape( KeyVal[1] );
        val = val.replace(/\+/g, ' ');
        Params[key] = val;
    }
    return Params;
}

function pageNecessary() {
    var monthOver = document.getElementsByClassName('cal-month__btn');
    for(var i = 0; i < monthOver.length; i++) {
        (function(index) {
            monthOver[index].addEventListener("mouseover", function(event) {
                event.target.classList.add("on");
            })
            monthOver[index].addEventListener("mouseout", function(event) {
                event.target.classList.remove("on");
            })
        })(i);
    }

    var viewPrice = document.getElementById('view_price');
    viewPrice.addEventListener("click", function(event){
        if(this.className.match(/type-oppo/))
            this.classList.remove("type-oppo");
        else
            this.classList.add("type-oppo");

        var _temp = document.getElementsByClassName("cal-rooms__item");
        for(var i=0; i<_temp.length; i++){
            if( _temp[i].className.match(/clb/) ) {
                if(_temp[i].style.display == "block") _temp[i].style.display = "none";
                else _temp[i].style.display = "block";
            }
            else {
                if(_temp[i].style.display == "none") _temp[i].style.display = "block";
                else _temp[i].style.display = "none";
            }
        }
    });
}

/**
 * Ajax Post Request
 */
function postAjax(url, data, success) {
    var params = typeof data == 'string' ? data : Object.keys(data).map(
        function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
    ).join('&');

    var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;
}

/** Calendar */
function makeCalendar(key, year, month, target_id, add_info){
    console.log("makeCalendar");
    if(!add_info) var add_info = "step01";
    var calendarBody = document.getElementById(target_id);
    calendarBody.innerHTML = "";
    var today = new Date();
    var first = new Date(year, month,1);
    var dayList_en = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    var dayList_ko = ['일','월','화','수','목','금','토'];
    var monthList = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    var leapYear=[31,29,31,30,31,30,31,31,30,31,30,31];
    var notLeapYear=[31,28,31,30,31,30,31,31,30,31,30,31];
    var pageFirst = first;
    var pageYear;
    if(first.getFullYear() % 4 === 0){
        pageYear = leapYear;
    }else{
        pageYear = notLeapYear;
    }
    var first1 = new Date();

    var first2 = new Date( first.getFullYear(), first.getMonth() , 1 );
    var firstPrev = new Date(first2.setDate(first2.getDate()-1));

    var first3 = new Date( first.getFullYear(), first.getMonth() , 1 );
    var firstNext = new Date(first3.setMonth(first3.getMonth()+1));

    let monthCnt = 100;
    let cnt = 1;

    //calendarBody.innerHTML = "<link href='http://api.einet.co.kr/template/default/default.css' rel='stylesheet' />";

    var calendarHtml = "";
    if(add_info == "step01") {
        calendarHtml += "<link rel='stylesheet' href='http://api.einet.co.kr/template/default/calendar.css' />";
        calendarHtml += "<link rel='stylesheet' href='//fonts.googleapis.com/earlyaccess/nanumgothic.css'>";
        calendarHtml += "";
        calendarHtml += "<header class='cal-header'>";
            calendarHtml += "<div class='container type-menu clb'>";
                calendarHtml += "<span class='cal-header__name fl'>이아이넷펜션</span>";
                calendarHtml += "<a href='' class='cal-header__admin fr'>관리자페이지</a>";
                calendarHtml += "<div class='cal-header__inbox type-menu'>";
                    calendarHtml += "<a href='' class='cal-header__menu on'>예약달력</a>";
                    calendarHtml += "<a href='' class='cal-header__menu'>예약하기</a>";
                    calendarHtml += "<a href='' class='cal-header__menu'>예약확인</a>";
                calendarHtml += "</div>";
            calendarHtml += "</div>";
        calendarHtml += "</header>";
        calendarHtml += "<div class='container type-cal'>";
            calendarHtml += "<div class='year_month cal-month'>";
                calendarHtml += "<a href='javascript://' class='cal-month__btn type-left' onclick=\"makeCalendar('" + params.key + "', " + firstPrev.getFullYear() + ", " + firstPrev.getMonth() + ", '" + target_id + "', '" + add_info + "'); \">이전달</a>";
                calendarHtml += "<span class='cal-month__date'>" + first.getFullYear() + "년 " + (first.getMonth() + 1) + "월</span>";
                calendarHtml += "<a href='javascript://' class='cal-month__btn type-right' onclick=\"makeCalendar('" + params.key + "', " + firstNext.getFullYear() + ", " + firstNext.getMonth() + ", '" + target_id + "', '" + add_info + "'); \">다음달</a>";
            calendarHtml += "</div>";
            calendarHtml += "<div class='cal-today'>TODAY : " + today.getFullYear() + "년 " + (today.getMonth() + 1) + "월 " + today.getDate() + "일(" + dayList_ko[today.getDay()] + ")</div>";
            calendarHtml += "<div class='cal-info clb'>";
                calendarHtml += "<ul class='cal-state clb'>";
                    calendarHtml += "<li class='cal-state__item fl is-order'>예약가능</li>";
                    calendarHtml += "<li class='cal-state__item fl is-ready'>예약대기</li>";
                    calendarHtml += "<li class='cal-state__item fl is-complete'>예약완료</li>";
                    calendarHtml += "<li class='cal-state__item fl is-phone'>전화문의</li>";
                calendarHtml += "</ul>";
                calendarHtml += "<button type='button' class='cal-info__btn' id='view_price'>요금보기</button>";
            calendarHtml += "</div>";

            calendarHtml += "<div class='container_calendar'>";
                calendarHtml += "<table class='calendar' cellpadding='0' cellspacing='0'>";
                    calendarHtml += "<colgroup>";
                        calendarHtml += "<col width='14%'>";
                        calendarHtml += "<col width='14%'>";
                        calendarHtml += "<col width='14%'>";
                        calendarHtml += "<col width='14%'>";
                        calendarHtml += "<col width='14%'>";
                        calendarHtml += "<col width='14%'>";
                        calendarHtml += "<col width='14%'>";
                    calendarHtml += "</colgroup>";
                    calendarHtml += "<tr>";
                    for(var d in dayList_ko) {
                        calendarHtml += "<th class='calendar__days "+(d==0?"type-sunday":(d==6?"type-saterday":""))+"'>일</th>";
                    }
                    calendarHtml += "</tr>";

        for(var i = 0; i < 7; i++){
            calendarHtml += "<tr class='cal-tr'>";
            for(var j = 0; j < 7; j++){
                if((i === 0 && j < first.getDay()) || cnt > pageYear[first.getMonth()]){
                    calendarHtml += "<td class='cal-td'></td>";
                }else{
                    calendarHtml += "<td class='cal-td'>";
                        calendarHtml += "<div class='cal-td__inbox type-date clb'>";
                            calendarHtml += "<span class='cal-td__num  "+(cnt==today.getDate()?"is-today":"")+" fl'>"+cnt+"</span>";
                            calendarHtml += "<div class='cal-td__day fr'>";
                                calendarHtml += "<span class='cal-td__txt' id='info_season_"+cnt+"'>비수기 주말</span>";
                                if(cnt==today.getDate()) {
                                    calendarHtml += "<span class='cal-td__today'>TODAY</span>";
                                }
                            calendarHtml += "</div>";
                        calendarHtml += "</div>";
                        calendarHtml += "<div class='cal-td__inbox type-rooms'>";
                            calendarHtml += "<ul class='cal-rooms__list' id='room_info_"+cnt+"'>";
                            calendarHtml += "</ul>";
                        calendarHtml += "</div>";
                    calendarHtml += "</td>";
                    cnt++;
                }
            }
            monthCnt++;

            //날짜가 종료되면 돌리지 말기
            if(cnt > pageYear[first.getMonth()]) {
                break;
            }
            calendarHtml += "</tr>";
        }
        calendarHtml += "</table>";
        calendarHtml += "</div>";

        calendarBody.innerHTML = calendarHtml;

        pageNecessary();
    }


    if(add_info == "step02") {
        var inHTML = "<link rel='stylesheet' href='http://api.einet.co.kr/template/default/calendar.css' />";
            inHTML += "<div id='"+brand_id+"_calendar_inner'>";
                inHTML +="<div class=\"year_month2 test\">"
                            if (first1 > first2) inHTML += "<a href='javscript://' class='calendar1'></a>"; //이전달은 조회하지 않음
                            else inHTML += "<a href='javscript://' class='calendar1 off' onclick=\"makeCalendar('" + params.key + "', " + firstPrev.getFullYear() + ", " + firstPrev.getMonth() + ", '" + target_id + "', '" + add_info + "'); \"></a>";
                            inHTML += first.getFullYear() + ". " + (first.getMonth() + 1);
                            inHTML += "<a href='javscript://' class='calendar1' onclick=\"makeCalendar('" + params.key + "', " + firstNext.getFullYear() + ", " + firstNext.getMonth() + ", '" + target_id + "', '" + add_info + "');\"></a>";
                inHTML +="</div>"
                inHTML +="<div class=\"container_calendar\">"
                    inHTML += "<table id=\"tbl_br\" class=\"small\" cellpadding=\"0\" cellspacing=\"0\">";
                    inHTML += "<tr>\n" +
                                    "<th>일</th>\n" +
                                    "<th>월</th>\n" +
                                    "<th>화</th>\n" +
                                    "<th>수</th>\n" +
                                    "<th>목</th>\n" +
                                    "<th>금</th>\n" +
                                    "<th>토</th>\n" +
                                "</tr>";
                                for(var i = 0; i < 7; i++){
                                    inHTML += "<tr class='cal-tr'>";
                                    for(var j = 0; j < 7; j++){
                                        if((i === 0 && j < first.getDay()) || cnt > pageYear[first.getMonth()]){
                                            inHTML += "<td class='cal-td'></td>";
                                        }else{
                                            inHTML += "<td class='cal-td'>";
                                            inHTML += "<div class='cal-td__inbox type-date clb'>";
                                            inHTML += "<a>"+cnt+"</a>";
                                            if(cnt==today.getDate() && today.getMonth()==first.getMonth() && today.getFullYear()==first.getFullYear()) {
                                                inHTML += "<span class='t_circle'></span>";
                                            }
                                            inHTML += "</div>";
                                            inHTML += "<div class='cal-td__inbox type-rooms'>";
                                            inHTML += "<ul class='cal-rooms__list' id='room_info_"+cnt+"'>";
                                            inHTML += "</ul>";
                                            inHTML += "</div>";
                                            inHTML += "</td>";
                                            cnt++;
                                        }
                                    }
                                    monthCnt++;

                                    //날짜가 종료되면 돌리지 말기
                                    if(cnt > pageYear[first.getMonth()]) {
                                        break;
                                    }
                                    inHTML += "</tr>";
                                }
                    inHTML += "</table>";
                inHTML +="</div>"
            inHTML +="</div>"


            inHTML += "</div>";
            inHTML += "</div>";
            inHTML += "</div>";
            calendarBody.innerHTML += inHTML;
    }

    if(add_info == "step01") callRoom(key, first.getFullYear(), first.getMonth()+1);
}

//룸정보 호출하여 정보 입력
function callRoom(key, year, month) {
    console.log("callRoom");
    var today = new Date();
    if(!year) var year = '';
    if(!month) var month = '';

    postAjax('http://api.einet.co.kr/calendar/room', {
        key: key,
        year: year,
        month: month,
    }, function(obj){
        var data = JSON.parse(obj);
        var tmp_html = new Array();
        for(var i in data.room){
            var item = data.room[i];
            if(item.room_name) tmp_html[item.id] = item.room_name;
        }

        for(var i=1; i<=data.total; i++){
            for(var r in tmp_html){
                var roomHtml = "";
                //roomHtml += "<p id='room_"+i+"_"+r+"' class='room_list' data-days='"+i+"' data-room='"+r+"' onclick=\"actionSet('"+year+"-"+month+"-"+i+"','"+r+"');\">";
                roomHtml += "<li class='cal-rooms__item incal-state pointer' data-days='"+i+"' data-room='"+r+"' id='room_"+i+"_"+r+"' onclick=\"actionSet('"+year+"-"+month+"-"+i+"','"+r+"');\">"+tmp_html[r]+"</li>";
                roomHtml += "<li class='cal-rooms__item clb pointer' id='room2_"+i+"_"+r+"' style='display:none; ' onclick=\"actionSet('"+year+"-"+month+"-"+i+"','"+r+"');\">";
                    roomHtml += "<span class='fl'>"+tmp_html[r]+"</span>";
                    roomHtml += "<span class='fr cal-rooms__price' id='price_"+i+"_"+r+"'></span>";
                roomHtml += "</li>";
                document.getElementById('room_info_'+i).innerHTML += roomHtml;
            }
        }
        callSeason(key, year, month);
        callReservation(key, year, month);
        callPrice(key, year, month);
    });
}

//일자별 시즌 정보 호출
function callSeason(key, year, month) {
    console.log("callSeason");
    postAjax('http://api.einet.co.kr/calendar/season', {
        key: key,
        year: year,
        month: month
    }, function(obj){
        var data = JSON.parse(obj);

        for(var i in data.season){
            var item = data.season[i];
            var tmp_cont = "";
            var tmp_day = new Date(year, parseInt(month)-1, i);
            if (!item || !item.season_name) tmp_cont += "비수기";
            else tmp_cont += item.season_name;
            if(tmp_day.getDay()==5 || tmp_day.getDay()==6) tmp_cont += " 주말";
            else tmp_cont += " 주중";

            document.getElementById("info_season_"+i).innerHTML = tmp_cont;
        }
    });
}

//룸별 예약정보
function callReservation(key, year, month) {
    console.log("callReservation");
    var today = new Date();
    if(!year) var year = '';
    if(!month) var month = '';

    postAjax('http://api.einet.co.kr/calendar/reservation', {
        key: key,
        year: year,
        month: month,
    }, function(obj){
        var data = JSON.parse(obj);
        for(var i in data.order){
            var item = data.order[i];
            for(var r in item){
                var stateClass = "is-order";
                var stateText = "가";
                var stateIng = true;
                if(item[r] && item[r]['state']=="ready")            { stateClass = "is-"+item[r]['state']; stateText = '대'; stateIng = false; }
                else if(item[r] && item[r]['state']=="pending")     { stateClass = "is-"+item[r]['state']; stateText = '대'; stateIng = false; }
                else if(item[r] && item[r]['state']=="success")     { stateClass = "is-"+item[r]['state']; stateText = '완'; stateIng = false; }
                else if(item[r] && item[r]['state']=="complete")    { stateClass = "is-"+item[r]['state']; stateText = '완'; stateIng = false; }

                var checkState = document.getElementById('room_'+(parseInt(i)+1)+'_'+r);
                var checkState2 = document.getElementById('room2_'+(parseInt(i)+1)+'_'+r);
                checkState.classList.add(stateClass);
                if(stateClass!="is-order") {
                    checkState2.classList.add("type-line");
                }
                //document.getElementById('room_'+(parseInt(i)+1)+'_'+r).innerHTML = "<span class='state "+stateClass+"' data-state='"+(stateIng==true?'y':'n')+"'>"+stateText+"</span>";
            }
        }
    });
}

//룸별 가격정보
function callPrice(key, year, month) {
    console.log("callPrice");
    var today = new Date();
    if(!year) var year = '';
    if(!month) var month = '';

    postAjax('http://api.einet.co.kr/calendar/price', {
        key: key,
        year: year,
        month: month,
    }, function(obj){
        var data = JSON.parse(obj);
        for(var i in data.price){
            var item = data.price[i];
            for(var r in item){
                document.getElementById('price_'+i+'_'+r).innerHTML = item[r].format();
                //document.getElementById('order_'+i+'_'+r).innerHTML += "<br/><span style='text-decoration:line-through; color:#aaa;font-size:0.8em; '>"+data.origin[i][r].format()+"</span> <span style='font-weight:bold; '>"+item[r].format()+"</span>";
            }
        }
    });
}

//예약하러가기
function actionSet(days, room) {
    console.log("actionSet");
    var tmp_day = days.split(/-/gi);
    var add_info = 'step01';
    if(history.state) {
        history.pushState(
            {
                'year': tmp_day[0],
                'month': parseInt(tmp_day[1]) - 1,
                'target_id': params.target_id,
                'add_info': add_info
            },
            '',
            'http://api.einet.co.kr/test'
        );
    }
    else {
        history.replaceState(
            {
                'year': tmp_day[0],
                'month': parseInt(tmp_day[1]) - 1,
                'target_id': params.target_id,
                'add_info': add_info
            },
            '',
            'http://api.einet.co.kr/test'
        );
    }

    var html = "<div id='"+brand_id+"_wrapper'>";
        html += "<nav id='"+brand_id+"_wrapper_inner_nav'>";
            html += "<div id='logo'><a href='javascript:void(0)'>이아이넷</a></div>";
            html += "<ul>";
                html += "<li>예약달력</li>";
                html += "<li class='on'>예약하기</li>";
                html += "<li>예약확인</li>";
            html += "</ul>";
            html += "<div id='admin'><a href='javascript:void(0)'>관리자페이지</a></div>";
        html += "</nav>";
        html += "<div id='"+brand_id+"_wrapper_inner_nav_top'>";
            html += "<div id='"+brand_id+"_calendar'>달력</div>";
            html += "<div id='"+brand_id+"_roominfo'>객실</div>";
        html += "</div>";
        html += "<div id='"+brand_id+"_roomlist' style='clear:both; '>객실목록 및 부가시설정보</div>";
    html += "</div>";
    document.getElementById(params.target_id).innerHTML = html;

    //달력 넣기
    makeCalendar(params.key, tmp_day[0], parseInt(tmp_day[1])-1, brand_id+'_calendar', 'step02');

    var tmp_date = days.split(/-/gi);
    postAjax('http://api.einet.co.kr/order/set', {
        key: params.key,
        days: days,
        room: room
    }, function(obj) {
        var data = JSON.parse(obj);

        //선택한 룸에 대한 기본 정보
        var roominfo = "";
        roominfo += "<div class=\"wrapper\">";
        roominfo += "<div class=\"title\">";
            roominfo += "<div class='button'>선택일</div>";
            roominfo += "<div class='h1'>"+tmp_date[0]+"년 "+tmp_date[1]+"월 "+tmp_date[2]+"일</div>";
        roominfo += "<div class='content'>"
            roominfo += "<div><span>주소</span> "+data.client.client_addr_basic+" "+data.client.client_addr_detail+"</div>";
            roominfo += "<div><span>전화번호</span> "+data.client.client_tel+"</div>";
            roominfo += "<div><span>결제방법</span> ";
            var tt = data.client.client_fee;
            var t2 = tt.split(/,/);
            var roominfo2 = "";
            for (var k in t2) {
                if(pg_method[t2[k]]) {
                    if(roominfo2!="") roominfo2 += ", ";
                    roominfo2 += pg_method[t2[k]];
                }
            }
            roominfo += roominfo2;
        roominfo += "</div>";
        roominfo += "<div><span>기간안내</span> ";
        for(var i in data.season) {
            if(i>0) roominfo += " / ";
            roominfo += "<span>"+data.season[i].season_name+" : "+data.season[i].season_start+"~"+data.season[i].season_end+"</span>";
        }
        roominfo += "</p>";
        roominfo +="</div>"
        roominfo +="<p>"
            roominfo += "<div><span>할인 기간 안내</span> ";
            for(var i in data.season) {
                if(i>0) roominfo += " / ";
                roominfo += "<span>"+data.season[i].season_name+" : "+data.season[i].season_start+"~"+data.season[i].season_end+"</span>";
            }
            roominfo +="</div>"
        roominfo +="</p>"


        document.getElementById(brand_id+"_roominfo").innerHTML = roominfo;

        changeRoomList(days);
    });
}

function changeRoomList(days) {
    console.log("changeRoomList");
    postAjax('http://api.einet.co.kr/order/change/day', {
        key: params.key,
        day: days
    }, function(obj) {
        var data = JSON.parse(obj);
        var roomlist = "";
        for(var k in data.room_list){
            var item = data.room_list[k];
            var tmp_img = "";
            for(var g in data.room_img[item.id]){
                var img = data.room_img[item.id][g];
                if(!img) tmp_img = "";
                else tmp_img = "http://api.einet.co.kr/data/"+img.path;
                if(tmp_img!="") break;
            }






                roomlist +="<div class=\"selected\" id='"+brand_id+"_room_info_"+item.id+"' price_room='"+item.id+"' price_adult='' price_child='' price_infant='' cnt_basic="+item.room_cnt_basic+" cnt_max="+item.room_cnt_max+" price='' >";
                    roomlist +="<div class=\"wrapper\">";
                        roomlist +="<h2>객실선택</h2>";
                        roomlist +="<div class=\"room\">";
                            roomlist +="<div class=\"c-box\"></div>";
                        roomlist +="<div class=\"f-box\">";
                            roomlist +="<div class=\"l-box\">";
                                roomlist +="<div class=\"img-box\">";
                                    roomlist +="<div class=\"button\"></div>";
                                        roomlist +="<img class=\"thumb-img\" src=\""+tmp_img+"\" id=\"room_img_"+item.id+"\" />";
                                    roomlist +="<div class=\"contents\">";
                                        roomlist +="<div class=\"r1 f-box\">";
                                            roomlist +="<div class=\"title\">["+item.type_name+"]-"+item.room_name+"</div>";
                                        roomlist +="<div class=\"view-icon\"><a href=\"javascript:void(0)\"><img src=\"./img/order/v_btn.png\" alt=\"view 아이콘\">view</a></div>";
                                    roomlist +="</div>";
                                roomlist +="</div>"
                                roomlist +="</div>"
                            roomlist +="</div>"
                            roomlist +="<div class=\"r-boxs\">"
                                roomlist +="<div class=\"r-box r1 \">"
                                    roomlist +="<div class=\"r1-inner f-box\">"
                                        roomlist +="<div class=\"term\">"
                                            roomlist +="<div class=\"title\">기간</div>"
                                            roomlist +="<select name=\"term\" onchange='check_price("+item.id+")'>"
                                                roomlist +="<option value=\"1\">1박</option>\n" +
                                                            "<option value=\"2\">2박</option>\n" +
                                                            "<option value=\"3\">3박</option>\n" +
                                                            "<option value=\"4\">4박</option>"
                                            roomlist +="</select>"
                                        roomlist +="</div>"
                                        roomlist +="<div class=\"person\">"
                                            roomlist +="<div class=\"title\">인원</div>"
                                            roomlist +="<select name=\"adult["+item.id+"]\" onchange=\"changeprice("+item.id+")\">"
                                                roomlist +="<option value=\"0\"><span>성인</span> 0명</option>\n";
                                                for(var i=0; i<item.room_cnt_max; i++){
                                                    roomlist += "<option value="+(i+1)+" "+(item.room_cnt_basic-1==i?"selected":"")+"><span>성인</span> "+(i+1)+"명</option>"
                                                }
                                            roomlist +="</select>"
                                            roomlist +="<select name=\"child["+item.id+"]\" onchange=\"changeprice("+item.id+")\">"
                                                roomlist +="<option value=\"0\"><span>아이</span> 0명</option>\n" +
                                                            "<option value=\"1\"><span>아이</span> 1명</option>\n" +
                                                            "<option value=\"2\"><span>아이</span> 2명</option>\n" +
                                                            "<option value=\"3\"><span>아이</span> 3명</option>\n" +
                                                            "<option value=\"4\"><span>아이</span> 4명</option>"
                                            roomlist +="</select>"
                                            roomlist +="<select name=\"infant["+item.id+"]\" onchange=\"changeprice("+item.id+")\">"
                                                roomlist +="<option value=\"0\"><span>영유아</span> 0명</option>\n" +
                                                            "<option value=\"1\"><span>영유아</span> 1명</option>\n" +
                                                            "<option value=\"2\"><span>영유아</span> 2명</option>\n" +
                                                            "<option value=\"3\"><span>영유아</span> 3명</option>\n" +
                                                            "<option value=\"4\"><span>영유아</span> 4명</option>"
                                            roomlist +="</select>"
                                        roomlist +="</div>"
                                        roomlist +="<div class=\"fee\">"
                                                // roomlist +="<div class=\"title\">객실요금(정상가)</div>"
                                                // roomlist +="<div class=\"fee-box\"><span id='price_1_"+item.id+"'></span> 원</div>"
                                                roomlist +="<div class=\"title\">객실요금(할인가)</div>"
                                                roomlist +="<div class=\"fee-box\"><span id='price_2_"+item.id+"'></span> 원</div>"
                                        roomlist +="</div>"
                                        roomlist +="<div class=\"button r-button\"><span>예약하기</span></div>"
                                    roomlist +="</div>"
                                roomlist +="</div>"
                                roomlist +="<div class=\"r-box r2\">"
                                    roomlist +="<div class=\"r2-inner\">"
                                        roomlist +="<div class=\"title\">기준인원 초과금액</div>"
                                        roomlist +="<div class=\"extra-fee\">"
                                            roomlist +="<div class=\"adult\">성인:<span class=\"a-age\" id='child_"+item.id+"'></span>  <span class=\"a-e-fee\" id='add_adult_"+item.id+"'></span>원 </div>\n" +
                                                        "<div class=\"child\">아동:<span class=\"c-age1\" id='young_"+item.id+"'></span>  <span class=\"c-e-fee\" id='add_child_"+item.id+"'></span>원</div>\n" +
                                                        "<div class=\"infant\">영유아:<span class=\"i-age1\" id='double_young_"+item.id+"'></span> <span class=\"i-e-fee\" id='add_baby_"+item.id+"'></span>원</div>\n"
                                        roomlist +="</div>"
                                    roomlist +="</div>"
                                roomlist +="</div>"
                            roomlist +="</div>"
                        roomlist +="</div>"
                        roomlist +="<div class=\"o-box\">"
                            roomlist +="<div class=\"l-box l-box1\">"
                                roomlist +="<div class=\"inner\">"
                                    roomlist +="<div class=\"title\">옵션선택</div>"
                                    roomlist +="<div class=\"txt\">원하시는 옵션을 체크하시면<br />"
                                    roomlist +="함께 예약됩니다</div>";
                                roomlist +="</div>"
                            roomlist +="</div>"
                            for(var z=0; z<data.facility.length; z++){
                                roomlist +="<div class='r-box'>"
                                    roomlist +="<div class=\"inner\">"
                                        roomlist +="<div class=\"r-box r-box1\">"
                                            roomlist +="<div class=\"l-box l-box2\">"
                                                roomlist +="<input type=\"checkbox\" id='cb1_"+z+"' onchange=\"facility("+item.id+","+z+")\" />"
                                                roomlist +="<label for='cb1_"+z+"'>"
                                                    roomlist +="<div class='lable-box' ></div>"
                                                    roomlist +="<div class='title' id='title_"+item.id+"_"+z+"'></div>"
                                                    roomlist +="<span class='detail' id='detail_"+item.id+"_"+z+"'></span>"
                                                roomlist +="</label>"
                                            roomlist +="</div>"
                                            roomlist +="<div class=\"r-box\">"
                                                roomlist +="<select name='num_"+z+"'>"
                                                roomlist +="<option value=\"1\">1</option>\n" +
                                                            "<option value=\"2\">2</option>\n" +
                                                            "<option value=\"3\">3</option>\n" +
                                                            "<option value=\"4\">4</option>"
                                                roomlist +="</select>"
                                                roomlist +="<span class=\"suffix\">SET</span>"
                                                roomlist +="<span class=\"r-line\"></span>"
                                                roomlist +="<span class=\"fee\"><span class=\"fee-value\" id='fee_value_"+item.id+"_"+z+"'></span></span>"
                                            roomlist +="</div>"
                                        roomlist +="</div>"
                                    roomlist +="</div>"
                                roomlist +="</div>"
                            }
                        roomlist +="</div>"
                        roomlist +="</div>"
                    roomlist +="</div>"
                roomlist +="</div>"

                document.getElementById(brand_id+"_roomlist").innerHTML = roomlist;


                // roomlist += "<div><img src='"+tmp_img+"' style='width:50px; height:50px; ' id='room_img_"+item.id+"' />["+item.type_name+"]"+item.room_name+", 기간:<select name=''><option value='1'>1박</option></select>기준:"+item.room_cnt_basic+"최대:"+item.room_cnt_max+", 가격(정상가):<span id='price_1_"+item.id+"'></span>, 가격(할인가):<span id='price_2_"+item.id+"'></span></div>";

            //일자별, 룸별 가격정보
            postAjax("http://api.einet.co.kr/price/day",{
                key: params.key,
                day: days,
                room: item.id,
            }, function(obj) {
                var data = JSON.parse(obj);
                // document.getElementById("price_1_"+data.room).innerText = data.price_origin.format();
                document.getElementById("price_2_"+data.room).innerText = data.price.format();
                document.getElementById("add_adult_"+data.room).innerText = data.add_adult.format();
                document.getElementById("add_child_"+data.room).innerText = data.add_child.format();
                document.getElementById("add_baby_"+data.room).innerText = data.add_baby.format();
                document.getElementById(brand_id+"_room_info_"+data.room).setAttribute("price_adult",data.add_adult);
                document.getElementById(brand_id+"_room_info_"+data.room).setAttribute('price_child',data.add_child);
                document.getElementById(brand_id+"_room_info_"+data.room).setAttribute('price_infant',data.add_baby);
                document.getElementById(brand_id+"_room_info_"+data.room).setAttribute('price',data.price);

                var data_room = data.room;
                postAjax('http://api.einet.co.kr/order/set', {
                    key: params.key,
                    days: days,
                    room: data_room
                }, function (obj) {
                    var data = JSON.parse(obj);
                    if(data.client.dobule_young=="N"){
                        document.getElementById('double_young_'+data_room).innerText ="입실 불가";
                        document.getElementById("add_baby_"+data_room).innerText="X";
                    }else{
                        document.getElementById('double_young_'+data_room).innerText = data.client.sleep_check_value_dobule_young+"개월까지";
                    }

                    if(data.client.young=="N"){
                        document.getElementById('young_'+data_room).innerText ="입실 불가";
                        document.getElementById("add_child_"+data_room).innerText="X";
                    }else{
                        document.getElementById('young_'+data_room).innerText = data.client.sleep_check_value_young+"개월까지";
                    }
                    document.getElementById('child_'+data_room).innerText = data.client.sleep_check_value_child+"개월 이상";

                    if(data.facility[0] != ""){
                        for (var i=0; i<data.facility.length; i++){
                            var facility = data.facility[i];
                            document.getElementById('title_'+data_room+"_"+i).innerText = facility.etc_content;
                            document.getElementById('detail_'+data_room+"_"+i).innerText = "("+facility.etc_min+facility.etc_dan+"부터"+"~"+facility.etc_max+facility.etc_dan+"까지"+")";
                            document.getElementById('fee_value_'+data_room+"_"+i).innerText = facility.etc_price+"원";
                        }
                    }
                });

            });


        }

    });
}

function changeprice(room) {
    check_price(room);
}

function check_price(room) {
    var cnt_adult = document.getElementsByName("adult["+room+"]");
    var cnt_child =document.getElementsByName("child["+room+"]");
    var cnt_infant = document.getElementsByName("infant["+room+"]");
    var term = document.getElementsByName("term");

    var price_adult = document.getElementById(brand_id+"_room_info_"+room).getAttribute("price_adult");
    var price_child = document.getElementById(brand_id+"_room_info_"+room).getAttribute("price_child");
    var price_infant = document.getElementById(brand_id+"_room_info_"+room).getAttribute("price_infant");
    var cnt_basic = document.getElementById(brand_id+"_room_info_"+room).getAttribute("cnt_basic");
    var cnt_max = document.getElementById(brand_id+"_room_info_"+room).getAttribute("cnt_max");
    var young = document.getElementById('young_'+room).innerText;
    var double_young = document.getElementById('double_young_'+room).innerText;
    var price = document.getElementById(brand_id+"_room_info_"+room).getAttribute("price");
    var cnt =0;

    for (var i = 0; i < cnt_adult.length; i++) {
        var cnt_adult = cnt_adult[i].value;
        var cnt_child = cnt_child[i].value;
        var cnt_infant = cnt_infant[i].value;
        var term = term[i].value;

        if(young=="입실 불가") {
            if (parseInt(cnt_child) > 0) {
                alert("아이는 입실 불가 입니다.");
                document.getElementsByName("child[" + room + "]")[0].value = 0;
                cnt++;
            }
        }else if(double_young =="입실 불가"){
            if (parseInt(cnt_infant) > 0) {
                alert("영유아는 입실 불가 입니다.");
                document.getElementsByName("infant[" + room + "]")[0].value = 0;
                cnt++;
            }
        }

        if((parseInt(cnt_adult) + parseInt(cnt_child) + parseInt(cnt_infant)) > parseInt(cnt_max)){
            alert("최대 인원보다 많을수는 없습니다");
            document.getElementsByName("adult["+room+"]")[0].value=cnt_basic;
            document.getElementsByName("child["+room+"]")[0].value=0;
            document.getElementsByName("infant["+room+"]")[0].value=0;
            document.getElementsByName("term")[0].value=1;
            price = price.replace(/,/gi,"");
            document.getElementById('price_2_'+room).innerText = parseInt(price);
            cnt++;
        }
    }

    if(cnt == 0){
        if((parseInt(cnt_adult) + parseInt(cnt_child) + parseInt(cnt_infant) <= parseInt(cnt_basic)) && facility_price == 0){
            price = price.replace(/,/gi,"");
            document.getElementById('price_2_'+room).innerText = (parseInt(price)*parseInt(term)).format();
        }else{
            price = price.replace(/,/gi,"");
            document.getElementById('price_2_'+room).innerText = ((parseInt(price) +((parseInt(cnt_adult) - parseInt(cnt_basic)) * parseInt(price_adult))) * parseInt(term)    + (parseInt(cnt_child) * parseInt(price_child) * parseInt(term)) + (parseInt(cnt_infant) * parseInt(price_infant) * parseInt(term))).format();        }
    }

}

function facility(room, sizefacility ) {
    // var term = document.getElementsByName("term");
    var num = document.getElementsByName("num_"+sizefacility+"")[0].value;

    if (document.getElementById('cb1_'+sizefacility+'').checked== true){
        var facility_price = document.getElementById('fee_value_'+room+'_'+sizefacility+'').innerText;
        var facility_price = facility_price.replace(/원/gi,"");
        var price = document.getElementById('price_2_'+room).innerText;
        price = price.replace(/,/gi,"");
        document.getElementById('price_2_'+room).innerText = (parseInt(price) + (parseInt(facility_price) * parseInt(num))).format();
    }else{
        var facility_price = document.getElementById('fee_value_'+room+'_'+sizefacility+'').innerText;
        var facility_price = facility_price.replace(/원/gi,"");
        var price = document.getElementById('price_2_'+room).innerText;
        price = price.replace(/,/gi,"");
        document.getElementById('price_2_'+room).innerText = (parseInt(price) - (parseInt(facility_price) * parseInt(num))).format();
    }
}


/** **************************************************************************************************************** **/
//모바일환경
function mobileSearch(key, year, month, day){
    console.log(year+"-"+month+"-"+day);
}
/** **************************************************************************************************************** **/

// 숫자 타입에서 쓸 수 있도록 format() 함수 추가
Number.prototype.format = function(){
    if(this==0) return 0;

    var reg = /(^[+-]?\d+)(\d{3})/;
    var n = (this + '');

    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');

    return n;
};

// 문자열 타입에서 쓸 수 있도록 format() 함수 추가
String.prototype.format = function(){
    var num = parseFloat(this);
    if( isNaN(num) ) return "0";

    return num.format();
};

window.onpopstate = function(event) {
    if(event.state.add_info=="step01") {
        makeCalendar(params.key, event.state.year, event.state.month, event.state.target_id, event.state.add_info)
    }
}
