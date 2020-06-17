<div class="sidebar" data-color="orange" data-image="assets/img/full-screen-image-3.jpg">
    <div class="logo">
        <a href="{{ route('main') }}" class="logo-text">
            <img src="{{ asset('/assets/img/logo/logo.png') }}" />
            <br/>
            이아이넷 펜션(본점)
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    계정전환
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li><a href="#">이아이넷 펜션 (부산)</a></li>
                        <li><a href="#">이아이넷 펜션 (제주)</a></li>
                    </ul>
                </div>
            </div>
        </div>
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
        <ul class="nav">
        @foreach($category as $k => $v)
            @php
                $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v['code'])->count();
                if($tmpCnt<1) continue;
            @endphp
                <li>
                    @if(($v['name'])=="숙박업소관리")
                        <a href="/room">
                            <i class="far fa-calendar-alt"></i>
                            <p>{{ $v['name'] }}
                                <b class="caret"></b>
                            </p>
                        </a>
                    @elseif(($v['name'])=="요금관리")
                        <a href="/price">
                            <i class="far fa-calendar-alt"></i>
                            <p>{{ $v['name'] }}
                                <b class="caret"></b>
                            </p>
                        </a>
                    @else
                        <a data-toggle="collapse" href="#{{$v['name']}}">
                            <i class="far fa-calendar-alt"></i>
                            <p>{{ $v['name'] }}
                                <b class="caret"></b>
                            </p>
                        </a>
                    @endif
                    @if(isset($v['sub']))
                        <div class="collapse" id="{{$v['name']}}">
                            <ul class="nav">
                        @foreach($v['sub'] as $k2 => $v2)
                            @php
                                $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v2['code'])->count();
                                if($tmpCnt<1) continue;
                                $tmp_code = str_replace("_",".",str_replace("admin_","",$v2['code']));
                                $tmp_path = explode(".",$tmp_code);
                            @endphp
                                <li><a href="{{ route($tmp_code) }}"> {{ $v2['name'] }} </a></li>
                                @if(isset($v2['sub']))
                                    <div class="collapse" id="admin">
                                        <ul class="nav">
                                        @foreach($v2['sub'] as $k3 => $v3)
                                            @php
                                                $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v3['code'])->count();
                                                if($tmpCnt<1) continue;

                                                $tmp_code = str_replace("_",".",str_replace("admin_","",$v3['code']));
                                                $tmp_path = explode(".",$tmp_code);
                                            @endphp
                                                <li><a href="{{ route($tmp_code) }}"> {{ $v3['name'] }} </a></li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif
                        @endforeach
                            </ul>
                        </div>
                </li>
            @endif
        @endforeach
        </ul>
    </div>
</div>
