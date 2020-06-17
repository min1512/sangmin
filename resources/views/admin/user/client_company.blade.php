@extends("layout.basic")

@section("title")예약시스템-숙박업체등록@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    @include("admin.include.content_title", [
        'title'=>'숙박업체 사업자 정보',
        'mean'=>'Client Company Information'
    ])

    <div class="tab-content">
        <div class="row">
            <div class="col-md">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <!--<h5 class="card-title">Controls Types</h5>-->
                        @include("admin.include.client_company",['id'=>$id, 'user'=>$user, 'userClientCompany'=>$userClientCompany])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
