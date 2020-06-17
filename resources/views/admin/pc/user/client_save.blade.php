@extends("admin.pc.layout.basic")

@section("title")숙박업체 관리@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="tab-content">
        <div class="row">
            <div class="col-md">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        @include("admin.pc.include.client_info",['user'=>$user, 'userInfo'=>$userInfo, 'user_client_facility' =>$user_client_facility,'user_client_service'=>$user_client_service,'user_client_torisit'=>$user_client_torisit])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
