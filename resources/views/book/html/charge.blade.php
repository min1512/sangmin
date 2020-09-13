@extends("book.html.layout")

@section("title")호텔헤이븐 예약시스템@endsection

@section("scripts")
    <script src="{{ url('https://code.jquery.com/jquery-2.2.4.min.js') }}" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="{{ url('https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js') }}"></script>
    <script>
        function mobileCheck() {
            // 모바일 기기 여부 변수에 담기
            var m_userAgent_All = navigator.userAgent.toLowerCase();
            var m_userAgent = '';
            var m_mobile = new Array('iphone', 'ipod', 'ipad', 'android', 'blackberry', 'windows ce', 'nokia', 'webos', 'opera mini', 'sonyericsson', 'opera mobi', 'iemobile', 'mot');
            var m_mobileCheck = 0;

            for (var m_count = 0; m_count < m_mobile.length; m_count++) {
                if (m_userAgent_All.indexOf(m_mobile[m_count]) != -1) {
                    m_mobileCheck++;
                    m_userAgent = m_mobile[m_count];
                }
            }

            var m_platform = navigator.platform.toLowerCase();
            var m_platform_filter = new Array('win16', 'win32', 'win64', 'mac', 'macintel');

            for (var m_count = 0; m_count < m_platform_filter.length; m_count++) {
                if (m_platform.indexOf(m_platform_filter[m_count]) != -1) {
                    m_mobileCheck = 0;
                }
            }

            // 모바일 체크 변수 사용
            if (m_mobileCheck > 0) {
                return true;
            }
            else {
                return false;
            }
        }

        $(document).ready(function(){
            if(mobileCheck()==true){
                document.nicepay.action = "https://web.nicepay.co.kr/v3/v3Payment.jsp";
                document.nicepay.submit();
            }
            else {
                document.nicepay.action = "https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js";
                goPay(document.nicepay);
            }
        });
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
    {{--<form method="post" name="nicepay" accept-charset="EUC-KR" action="https://web.nicepay.co.kr/v3/v3Payment.jsp"> <!--모바일-->--}}
    <form method="post" name="nicepay" accept-charset="EUC-KR" action="https://web.nicepay.co.kr/v3/webstd/js/nicepay-3.0.js"> <!--PC-->
{{--        <input type="hidden" name="GoodsName" value="{{ $good }}" /><!--결제상품명-->--}}
{{--        <input type="hidden" name="Amt" value="{{ $data->reserve_price_out }}" /><!--금액-->--}}
        <input type="hidden" name="GoodsName" value="TestProduct" />
        <input type="hidden" name="Amt" value="1004" />
        <input type="hidden" name="MID" value="{{ $merchantID }}" /><!--상점ID-->
        <input type="hidden" name="EdiDate" value="{{$date}}" /><!--요청시간-->
        <input type="hidden" name="Moid" value="{{ $data->id }}" /><!--주문번호-->
        <input type="hidden" name="SignData" value="{{ $SignData }}" /><!--위변조코드 hex(sha256(EdiDate + MID + Amt + MerchantKey))-->

        <input type="hidden" name="BuyerName" value="{{ $data->reserve_name }}" /><!--구매자명-->
        <input type="hidden" name="BuyerTel" value="{{ $data->reserve_hp }}" /><!--구매자연락처-->
        <input type="hidden" name="ReturnURL" value="" /><!--요청응답URL-->
        <input type="hidden" name="PayMethod" value="{{ strtoupper($data->charge_method) }}" /><!--결제방법(CARD,BANK,VBANK,CELLPHONE) 중복사용 콤마이용-->
        <input type="hidden" name="ReqReserved" value="" /><!--가맹점여분필드-->
        <input type="hidden" name="BuyerEmail" value="{{ $data->reserve_email }}" /><!--구매자메일주소-->
        <input type="hidden" name="CharSet" value="utf-8" /><!--인증응답인코딩(euc-kr/utf-8)-->
        {{--    <input type="submit" value="테스트결제" />--}}
    </form>
@endsection

