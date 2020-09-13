<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function makeCalendar(key, year, month) {
            $("body").html("");
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

            var calendarHtml = "";
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
                    calendarHtml += "<a href='javascript://' class='cal-month__btn type-left' onclick=\"makeCalendar('" + key + "', " + firstPrev.getFullYear() + ", " + firstPrev.getMonth() + "); \">이전달</a>";
                    calendarHtml += "<span class='cal-month__date'>" + first.getFullYear() + "년 " + (first.getMonth() + 1) + "월</span>";
                    calendarHtml += "<a href='javascript://' class='cal-month__btn type-right' onclick=\"makeCalendar('" + key + "', " + firstNext.getFullYear() + ", " + firstNext.getMonth() + "); \">다음달</a>";
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
                calendarHtml += "</div>";
            calendarHtml += "</div>";


            $("body").html(calendarHtml);

            callRoom(key, year, month);
        }

        function callRoom(key, year, month) {
            console.log("callRoom");
            var today = new Date();
            if(!year) var year = '';
            if(!month) var month = '';

            $.post(
                'http://api.einet.co.kr/calendar/room'
                , {
                    key: key,
                    year: year,
                    month: month,
                }
                , function(obj){
                    var data = obj;
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
                }
                , "json"
            );
        }

        //일자별 시즌 정보 호출
        function callSeason(key, year, month) {
            console.log("callSeason");
            $.post(
                'http://api.einet.co.kr/calendar/season'
                , {
                    key: key,
                    year: year,
                    month: month
                }
                , function(obj) {
                    var data = obj;

                    for (var i in data.season) {
                        var item = data.season[i];
                        var tmp_cont = "";
                        var tmp_day = new Date(year, parseInt(month) - 1, i);
                        if (!item || !item.season_name) tmp_cont += "비수기";
                        else tmp_cont += item.season_name;
                        if (tmp_day.getDay() == 5 || tmp_day.getDay() == 6) tmp_cont += " 주말";
                        else tmp_cont += " 주중";

                        document.getElementById("info_season_" + i).innerHTML = tmp_cont;
                    }
                }
                , "json"
            );
        }

        //룸별 예약정보
        function callReservation(key, year, month) {
            console.log("callReservation");
            var today = new Date();
            if(!year) var year = '';
            if(!month) var month = '';

            $.post(
                'http://api.einet.co.kr/calendar/reservation',
                {
                    key: key,
                    year: year,
                    month: month,
                }
                , function(obj){
                    var data = obj;
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
                        }
                    }
                }
                , "json"
            );
        }

        //룸별 가격정보
        function callPrice(key, year, month) {
            console.log("callPrice");
            var today = new Date();
            if(!year) var year = '';
            if(!month) var month = '';
            $.ajax({
                url : 'http://api.einet.co.kr/calendar/price',
                type: 'POST',
                data: {
                    key: key,
                    year: year,
                    month: month
                },
                dataType: 'json',
                success: function f(data) {
                    for(var i in data.price_sales){
                        var item = data.price_sales[i];
                        for(var r in item){
                            document.getElementById('price_'+i+'_'+r).innerHTML = item[r].format();
                        }
                    }
                }
            });
        }

        $(document).ready(function(){
            makeCalendar("<?=$_GET["token"]?>", "<?=date("Y")?>", "<?=date("m")?>");
        });

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
    </script>
</head>
<body>

</body>
</html>
