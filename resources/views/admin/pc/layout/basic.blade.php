<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield("title")</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="{{ asset('asset/css/admin_pc_common.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/fontawesomepro/css/all.css') }}" rel="stylesheet">
    <script src="{{ asset('asset/js/common.js') }}"></script>
    @yield("scripts")
    @yield("styles")
</head>
<body>
    <div id="wrap">
        <div id="container">
            <div id="sidebar">
                <div class="change_client"><span>계정전환 <i class="fal fa-angle-down"></i></span></div>
                @php
                    $url = $_SERVER["HTTP_HOST"];
                    $url = str_replace(".einet.co.kr","",$url);

                    $hh = explode(".",$_SERVER["HTTP_HOST"]);
                    if($hh[0]=="staff") $tmp_user = \App\Models\UserStaff::where('user_id',Auth::user()->id)->select('permit_id')->first();
                    elseif($hh[0]=="agency") $tmp_user = \App\Models\UserAgency::where('user_id',Auth::user()->id)->select('permit_id')->first();
                    elseif($hh[0]=="client") $tmp_user = \App\Models\UserClient::where('user_id',Auth::user()->id)->select('permit_id')->first();

                    $permit = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->get();
                    $category = \App\Http\Controllers\Controller::getCategory();
                    $uri = \Illuminate\Support\Facades\Request::route()->uri();
                    $uri = explode("/",$uri);
                @endphp
                <div class="gnb">
                    <ul>
{{--
                        <li>
                            <span class="menu"><i class="fal fa-calendar-alt"></i>예약관리</span>
                            <span class="block_arrow"><i class="fal fa-angle-down"></i></span>
                            <p><i class="fal fa-angle-right"></i> 111111</p>
                            <p><i class="fal fa-angle-right"></i> 222222</p>
                            <p><i class="fal fa-angle-right"></i> 333333</p>
                            <p><i class="fal fa-angle-right"></i> 444444</p>
                        </li>
                        <li>
                            <span class="menu on"><i class="fal fa-calendar-alt"></i>요금관리</span>
                            <span class="block_arrow"><i class="fal fa-angle-up"></i></span>
                            <p><i class="fal fa-angle-right"></i> 가동률/예약통계</p>
                            <p><i class="fal fa-angle-right"></i> 매출통계</p>
                            <p><i class="fal fa-angle-right"></i> 정산현황</p>
                            <p><i class="fal fa-angle-right"></i> 현금영수증</p>
                        </li>
--}}
                        @foreach($category as $k => $v)
                            @php
                                $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v['code'])->count();
                                if($tmpCnt<1) continue;
                                $tmp_code_0 = str_replace("_",".",str_replace("admin_","",$v['code']));
                                $tmp_path_0 = explode(".",$tmp_code_0);
                            @endphp
                            <li>
                                @if(isset($v['sub']))
                                    <span class="menu"><i class="fal fa-{{$v['icon']}}"></i>{{ $v['name'] }}</span>
                                    <span class="block_arrow"><i class="fal fa-angle-down"></i></span>
                                    @foreach($v['sub'] as $k2 => $v2)
                                        @php
                                            $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v2['code'])->count();
                                            if($tmpCnt<1) continue;
                                            $tmp_code = str_replace("_",".",str_replace("admin_","",$v2['code']));
                                            $tmp_path = explode(".",$tmp_code);
                                        @endphp
                                        <p><a href="{{ route($tmp_code) }}"><i class="fal fa-angle-right"></i> {{ $v2['name'] }}</a></p>
                                    @endforeach
                                @else
                                    <span class="menu"><a href="{{ route($tmp_code_0) }}"><i class="fal fa-{{$v['icon']}}"></i>{{ $v['name'] }}</a></span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div id="header">
                <div class="logo">
                    <img src="{{asset('asset/images/logo_einet.png')}}" />
                    <span>이아이넷 펜션(본점)</span>
                </div>
                <div class="search">
                    <input type="text" name="" class="keyword" placeholder="예약자/연락처/요청/메모" />
                    <button class="btn_reservation"><i class="fal fa-calendar"></i> 직접예약</button>
                    <button class="btn_search"><i class="fal fa-search"></i> 검색</button>
                </div>
            </div>
            <div id="content">
                <div class="quick">
                    <ul>
                        <li>사이트바로가기</li>
                        <li>실시간예약창</li>
                        <li>내정보</li>
                    </ul>
                </div>
                <div class="content_wrap">
                    @yield("contents")
                </div>
            </div>
        </div>
    </div>
</body>
</html>
