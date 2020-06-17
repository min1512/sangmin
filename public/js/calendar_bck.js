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

    calendarBody.innerHTML = "<link href='http://api.einet.co.kr/template/default/default.css' rel='stylesheet' />";

    if(add_info == "step01") {
        var tmp_title = "";
        tmp_title += "<div class='line_menu'>";
            tmp_title += "<p class='"+brand_id+"_title'>펜션명</p>";
            tmp_title += "<p class='"+brand_id+"_menu on'>예약달력</p>";
            tmp_title += "<p class='"+brand_id+"_menu'>예약하기</p>";
            tmp_title += "<p class='"+brand_id+"_menu'>예약확인</p>";
            tmp_title += "<p class='"+brand_id+"_admin'>관리자페이지</p>";
        tmp_title += "</div>";
        calendarBody.innerHTML += tmp_title;

        var inHTML = "<div class='year_month'>";
            if (first1 > first2) inHTML += "<a href='javscript://' class='calendar off'>＜</a>"; //이전달은 조회하지 않음
            else inHTML += "<a href='javscript://' class='calendar off' onclick=\"makeCalendar('" + params.key + "', " + firstPrev.getFullYear() + ", " + firstPrev.getMonth() + ", '" + target_id + "', '" + add_info + "'); \"><</a>";

            inHTML += first.getFullYear() + "년 " + (first.getMonth() + 1) + "월";
            inHTML += "<a href='javscript://' class='calendar off' onclick=\"makeCalendar('" + params.key + "', " + firstNext.getFullYear() + ", " + firstNext.getMonth() + ", '" + target_id + "', '" + add_info + "');\">></a>";
        inHTML += "</div>";
        inHTML += "<div class='today'>";
            inHTML += "TODAY : ";
            inHTML += today.getFullYear() + "년 " + (today.getMonth() + 1) + "월 " + today.getDate() + "일(" + dayList_ko[today.getDay()] + ")";
        inHTML += "</div>";
    }
    else if(add_info == "step02") {
        var inHTML = "<div class='year_month2'>";
            if (first1 > first2) inHTML += "<a href='javscript://' class='calendar'>＜</a>"; //이전달은 조회하지 않음
            else inHTML += "<a href='javscript://' class='calendar off' onclick=\"makeCalendar('" + params.key + "', " + firstPrev.getFullYear() + ", " + firstPrev.getMonth() + ", '" + target_id + "', '" + add_info + "'); \"><</a>";

            inHTML += first.getFullYear() + ". " + (first.getMonth() + 1);
            inHTML += "<a href='javscript://' class='calendar' onclick=\"makeCalendar('" + params.key + "', " + firstNext.getFullYear() + ", " + firstNext.getMonth() + ", '" + target_id + "', '" + add_info + "');\">></a>";
        inHTML += "</div>";
    }
    calendarBody.innerHTML += inHTML;

    if(add_info == "step01") {
        var item_point = "";
        item_point += "<div class='order_item'>";
            item_point += "<span class='state order'>가</span> 예약가능";
            item_point += "<span class='state ready'>대</span> 예약대기";
            item_point += "<span class='state complete'>완</span> 예약완료";
            item_point += "<span class='state phone'>전</span> 전화문의";
            item_point += "<div class='price'><button type='button'>요금보기</button></div>";
        item_point += "</div>";
        calendarBody.innerHTML += item_point;
    }

    var $div = document.createElement('div');
    $div.setAttribute('class', 'container_calendar');

    var inHTML = "";

    var tbl_id = "tbl_"+brand_id;
    var $table = document.createElement('table');
    $table.setAttribute('id', tbl_id);
    if(add_info == "step01") {
        $table.setAttribute('class', 'full');
    }
    else if(add_info == "step02") {
        $table.setAttribute('class', 'small');
    }
    $table.setAttribute('cellpadding', '0');
    $table.setAttribute('cellspacing', '0');
    var $tr = document.createElement('tr');
    for(var d in dayList_ko) {
        var $td = document.createElement('th');
        $td.innerHTML = dayList_ko[d];
        $tr.appendChild($td);
    }
    $table.appendChild($tr);
    $div.appendChild($table);
    calendarBody.appendChild($div);


    calendarBody = document.getElementById(tbl_id);

    for(var i = 0; i < 7; i++){
        var $tr = document.createElement('tr');
        $tr.setAttribute('id', monthCnt);
        for(var j = 0; j < 7; j++){
            if((i === 0 && j < first.getDay()) || cnt > pageYear[first.getMonth()]){
                var $td = document.createElement('td');
                $td.innerHTML = "&nbsp;";
                $tr.appendChild($td);
            }else{
                var $td = document.createElement('td');
                var tmp_html = "";
                if(add_info == "step01") {
                    tmp_html += "<ul class='day'>";
                        tmp_html += "<li>"+cnt+"</li>";
                        tmp_html += "<li id='info_season_"+cnt+"'></li>";
                    tmp_html += "</ul>";
                    tmp_html += "<div class='room_info' id='room_info_" + cnt + "'></div>";
                }
                else if(add_info == "step02") {
                    tmp_html += "<a href='javasscript://' onclick=\"changeRoomList('"+first.getFullYear()+"-"+first.getMonth()+"-"+cnt+"')\">"+cnt+"</a>";
                }
                // for(var room of data.room) {
                //     tmp_html += '<p>['+room.room_name+'] '+data.info[cnt][room.id].price.format()+'</p>';
                // }

                $td.innerHTML = tmp_html;
                $td.setAttribute('id', cnt);
                $tr.appendChild($td);
                cnt++;
            }
        }
        monthCnt++;
        //calendarBody.appendChild($tr);
        calendarBody.appendChild($tr);

        //날짜가 종료되면 돌리지 말기
        if(cnt > pageYear[first.getMonth()]) {
            break;
        }
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
                var tmp_html2 = "<p id='room_"+i+"_"+r+"' class='room_list' data-days='"+i+"' data-room='"+r+"' onclick=\"actionSet('"+year+"-"+month+"-"+i+"','"+r+"');\">";
                tmp_html2 += "<span id='order_"+i+"_"+r+"'>Loading</span>";
                tmp_html2 += "<span class='room_name'>"+tmp_html[r]+"</span>";
                //tmp_html2 += "<span id='price_"+i+"_"+r+"'>Loading</span>";
                tmp_html2 += "</p>";
                document.getElementById('room_info_'+i).innerHTML += tmp_html2;
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
                var stateClass = "order";
                var stateText = "가";
                var stateIng = true;
                if(item[r] && item[r]['state']=="ready")            { stateClass = item[r]['state']; stateText = '대'; stateIng = false; }
                else if(item[r] && item[r]['state']=="pending")     { stateClass = item[r]['state']; stateText = '대'; stateIng = false; }
                else if(item[r] && item[r]['state']=="success")     { stateClass = item[r]['state']; stateText = '완'; stateIng = false; }
                else if(item[r] && item[r]['state']=="complete")    { stateClass = item[r]['state']; stateText = '완'; stateIng = false; }

                document.getElementById('order_'+(parseInt(i)+1)+'_'+r).innerHTML = "<span class='state "+stateClass+"' data-state='"+(stateIng==true?'y':'n')+"'>"+stateText+"</span>";
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
                //document.getElementById('price_'+i+'_'+r).style.color = '#333';
                //document.getElementById('price_'+i+'_'+r).innerHTML = "<br/><span style='text-decoration:line-through; color:#aaa;font-size:0.8em; '>"+data.origin[i][r].format()+"</span> <span style='font-weight:bold; '>"+item[r].format()+"</span>";
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
    //console.log(tmp_day[0]+":"+(parseInt(tmp_day[1]) - 1)+":"+params.target_id+":"+add_info);

    var html = "";
    html += "<div id='"+brand_id+"_calendar' style='float:left; width:50%; '>달력</div>";
    html += "<div id='"+brand_id+"_roominfo' style='float:left; width:50%; '>객실</div>";
    html += "<div id='"+brand_id+"_roomlist' style='clear:both; '>객실목록 및 부가시설정보</div>";
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
        roominfo += "<div>선택일</div>";
        roominfo += "<div>"+tmp_date[0]+"년 "+tmp_date[1]+"월 "+tmp_date[2]+"일</div>";
        roominfo += "<div>주소 "+data.client.client_addr_basic+" "+data.client.client_addr_detail+"</div>";
        roominfo += "<div>전화번호 "+data.client.client_tel+"</div>";
        roominfo += "<div>결제방법 ";
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
        roominfo += "<p>기간안내 ";
        for(var i in data.season) {
            if(i>0) roominfo += " / ";
            roominfo += "<span>"+data.season[i].season_name+" : "+data.season[i].season_start+"~"+data.season[i].season_end+"</span>";
        }
        roominfo += "</p>";
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
            roomlist += "<div><img src='"+tmp_img+"' style='width:50px; height:50px; ' id='room_img_"+item.id+"' />["+item.type_name+"]"+item.room_name+", 기간:<select name=''><option value='1'>1박</option></select>기준:"+item.room_cnt_basic+"최대:"+item.room_cnt_max+", 가격(정상가):<span id='price_1_"+item.id+"'></span>, 가격(할인가):<span id='price_2_"+item.id+"'></span></div>";
            roomlist += "<ul>";
            roomlist += "</ul>";

            //일자별, 룸별 가격정보
            postAjax("http://api.einet.co.kr/price/day",{
                key: params.key,
                day: days,
                room: item.id,
            }, function(obj) {
                var data = JSON.parse(obj);
                document.getElementById("price_1_"+data.room).innerText = data.price_origin.format();
                document.getElementById("price_2_"+data.room).innerText = data.price.format();
            })
        }

        document.getElementById(brand_id+"_roomlist").innerHTML = roomlist;
    });
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
    console.log(event.state);
    if(event.state.add_info=="step01") {
        makeCalendar(params.key, event.state.year, event.state.month, event.state.target_id, event.state.add_info)
    }
}
