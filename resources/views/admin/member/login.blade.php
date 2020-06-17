@extends("layout.blank")

@section("title")예약시스템 로그인@endsection

@section("scripts")
@endsection

@section("styles")
    <link rel="stylesheet" href="{{ asset('assets/css/fontawsom-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
@endsection

@section("contents")
    <div class="container-fluid conya" style="padding:0; ">
        <div class="side-left">
            <div class="sid-layy" style="background:transparent;">
                <div class="row slid-roo">
                    <div class="data-portion">
                        <h2>예약시스템 - {{ $name }}</h2>
                        <p>{{ $mean }}</p>
                        <ul>
                            <li>Tel : 1688 - 6433</li>
                            <li>Fax : 02 - 6008 - 2139</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="side-right">
            <form method="post" name="frmLogin" action="{{ url()->current() }}">
                {{ csrf_field() }}
            <img class="logo" src="{{ asset('assets/images/logo.jpg') }}" alt="">

            <h2>{{ $name }} Login</h2>

            <div class="form-row">
                <label for="email_id">Email ID</label>
                <input type="text" name="email" id="email_id" placeholder="email_id@email.com" class="form-control form-control-sm" />
            </div>

            <div class="form-row">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-sm" />
            </div>

            <div class="form-row row skjh">
                <div class="col-7 left no-padding">
                    <input type="checkbox" id="save_id" />
                    <label for="save_id">Save Email ID</label>
                </div>
                <div class="col-5">
                    <span> <a href="javascript://" onclick="alert('작업중....');">Forget Password ?</a></span>
                </div>


            </div>


            <div class="form-row dfr">
                <button class="btn btn-sm btn-success">Login</button>
            </div>

<!--
            <div class="ord-v">
                <a href=""></a>
            </div>
            </form>

            <div class="soc-det">
                <ul>
                    <li class="facebook"><i class="fab fa-facebook-f"></i></li>
                    <li class="twitter"><i class="fab fa-twitter"></i></li>
                    <li class="pin"><i class="fab fa-pinterest-p"></i></li>
                    <li class="link"><i class="fab fa-linkedin-in"></i></li>
                </ul>
            </div>
-->
        </div>
        <div class="copyco">
            <p>Copyright 2020 @ einet.co.kr</p>
        </div>
    </div>
    <script src="{{ asset('assets/scripts/popper.min.js') }}"></script>
@endsection
