
@extends('layouts.student.student')

@section('main')

<style>
    .cke_chrome{
        border:1px solid #eee;
        box-shadow: 0 0 0 #eee;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
    <!-- Content Header (Page header) -->	  
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Quiz</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Quiz</li>
                        </ol>
                    </nav>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="box">
              <div class="card-header mb-4">
                <h3 class="card-title">Quiz List</h3>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <div id="complex_header_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                      <div class="col-sm-12">
                        <table id="myTable" class="table table-striped projects display dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="complex_header_info">
                          <thead>
                            <tr>
                              <th style="width: 1%">
                                No.
                              </th>
                              <th style="width: 15%">
                                Name
                              </th>
                              <th style="width: 20%">
                                Submission Date
                              </th>
                              <th style="width: 10%">
                                Status
                              </th>
                              <th style="width: 5%">
                                Marks
                              </th>
                              <th style="width: 20%">
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($quiz as $key => $qz)
                              @php
                                if(empty($status[$key]))
                                {
                                  $alert = "badge bg-danger";
                                }else{
                                  $alert = "badge bg-success";
                                }
                              @endphp
                              <tr>
                                <td style="width: 1%">
                                    {{ $key+1 }}
                                </td>
                                <td style="width: 15%">
                                  <span class="{{ $alert }}">{{ $qz->name }}</span>
                                </td>
                                <td style="width: 20%">
                                      {{  empty($status[$key]) ? '-' : $status[$key]->submittime }}
                                </td>
                                <td>
                                      {{  empty($status[$key]) ? '-' : $status[$key]->status }}
                                </td>
                                <td>
                                      {{  empty($status[$key]) ? '-' : $status[$key]->final_mark }}
                                </td>                          
                                
                                <td class="project-actions text-center" >
                                  @if (empty($status[$key]) || ($status[$key]->status == 1) )
                                    @if ($qz->status == 2)
                                      @if (date("Y-m-d H:i:s") >= $qz->date_from && date("Y-m-d H:i:s") <= $qz->date_to)
                                      <a class="btn btn-success btn-sm mr-2" href="/student/quiz/{{ Session::get('subjects')->id }}/{{ request()->quiz }}/view">
                                        <i class="ti-user">
                                        </i>
                                        Answer
                                      </a>
                                      @elseif (date("Y-m-d H:i:s") < $qz->date_from)
                                        <a class="btn btn-danger btn-sm mr-2">
                                          <i class="ti-lock">
                                          </i>
                                          Quiz will be open on {{  $qz->date_from  }}
                                        </a>
                                      @elseif (date("Y-m-d H:i:s") > $qz->date_to)
                                        <a class="btn btn-danger btn-sm mr-2">
                                          <i class="ti-lock">
                                          </i>
                                          Quiz has closed on {{  $qz->date_to  }}
                                        </a>
                                      @endif
                                    @elseif ($qz->status == 1)
                                      <a class="btn btn-danger btn-sm mr-2">
                                        <i class="ti-lock">
                                        </i>
                                        Quiz is not published yet
                                      </a>
                                    @endif
                                  @elseif (!($status[$key]))
                                  <a class="btn btn-success btn-sm mr-2" href="/student/quiz/{{ request()->quiz }}/{{ Auth::guard('student')->user()->ic }}/result">
                                    <i class="ti-user">
                                    </i>
                                    Result
                                  </a>
                                  @else
                                    @if ($qz->status == 2)
                                      @if (date("Y-m-d H:i:s") >= $qz->date_from && date("Y-m-d H:i:s") <= $qz->date_to)
                                      <a class="btn btn-success btn-sm mr-2" href="/student/quiz/{{ Session::get('subjects')->id }}/{{ request()->quiz }}/view">
                                        <i class="ti-user">
                                        </i>
                                        Answer
                                      </a>
                                      @elseif (date("Y-m-d H:i:s") < $qz->date_from)
                                        <a class="btn btn-danger btn-sm mr-2">
                                          <i class="ti-lock">
                                          </i>
                                          Quiz will be open on {{  $qz->date_from  }}
                                        </a>
                                      @elseif (date("Y-m-d H:i:s") > $qz->date_to)
                                        <a class="btn btn-danger btn-sm mr-2">
                                          <i class="ti-lock">
                                          </i>
                                          Quiz has closed on {{  $qz->date_to  }}
                                        </a>
                                      @endif
                                    @elseif ($qz->status == 1)
                                      <a class="btn btn-danger btn-sm mr-2">
                                        <i class="ti-lock">
                                        </i>
                                        Quiz is not published yet
                                      </a>
                                    @endif
                                  @endif
                                </td>
                              </tr>                            
                            @endforeach
                          </tbody>
                        </table>
                      </div>
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
<!-- /.content-wrapper -->
<script src="{{ asset('assets/src/js/pages/data-table.js') }}"></script>

<script type="text/javascript">
$(document).ready( function () {
    $('#myTable').DataTable();
} );

    $(document).on('click', '#newFolder', function() {
        location.href = "/user/quiz/{{ Session::get('CourseID') }}/create";
    })

    function deleteMaterial(dir){     
        Swal.fire({
			title: "Are you sure?",
			text: "This will be permanent",
			showCancelButton: true,
			confirmButtonText: "Yes, delete it!"
		}).then(function(res){
			
			if (res.isConfirmed){
                $.ajax({
                    headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
                    url      : "{{ url('user/content/delete') }}",
                    method   : 'DELETE',
                    data 	 : {dir:dir},
                    error:function(err){
                        alert("Error");
                        console.log(err);
                    },
                    success  : function(data){
                        window.location.reload();
                        alert("success");
                    }
                });
            }
        });
    }

</script>
@stop