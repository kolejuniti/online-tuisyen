@php
    $layoutMap = [
        'Admin' => 'layouts.admin.admin',
        'Teacher' => 'layouts.user',
    ];
    
    if (isset(Auth::user()->user_type) && array_key_exists(Auth::user()->user_type, $layoutMap)) {
        $layout = $layoutMap[Auth::user()->user_type];
    }
@endphp

@extends($layout)

@section('main')
<!-- Content Header (Page header) -->
<div class="content-wrapper" style="min-height: 695.8px;">
  <div class="container-full">
    <!-- Page Header -->
    <div class="page-header">
      <div class="d-flex align-items-center">
          <div class="me-auto">
              <h3 class="page-title mb-1">Dashboard</h3>
              <div class="d-inline-block align-items-center">
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                      </ol>
                  </nav>
              </div>
          </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
				<div class="col-xl-12 col-12">
          <div class="box bg-success">
            <div class="box-body d-flex p-0">
              <div class="flex-grow-1 p-30 flex-grow-1 bg-img bg-none-md align-content-center" style="background-position: right bottom; background-size: auto 100%; background-image: url(images/svg-icon/color-svg/custom-30.svg)">
                <div class="row">
                  <div class="col-12 col-xl-12">
                    <h1 class="mb-0 fw-600" style="text-align:center">Welcome to eTutor!</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</div>

<script src="{{ asset('assets/src/js/pages/data-table.js') }}"></script>

@endsection
