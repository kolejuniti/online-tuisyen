@extends('layouts.user.user')

@section('main')



<style>


#fb-rendered-form {
    clear:both;
    display:none;
    button{
        float:right;
    }
}

.btn.btn-default.get-data{
    display:none;
}

.cb-wrap {

}
.form-wrap.form-builder .frmb-control li{
    font-family: Arial, Helvetica, sans-serif !important;
    font-weight: Bold !important;
}

div.form-actions.btn-group > button{
    font-size:1.2em !important;
    border-radius:0.5em !important;
    padding:0.5em !important;
    min-width:100px;
    margin: 0.5em;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->	  
        <div class="page-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">
                        {{ empty($data['quiz']->title) ? "Create Quiz" : $data['quiz']->title }}
                    </h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Academics</li>
                                <li class="breadcrumb-item" aria-current="page">Groups</li>
                                <li class="breadcrumb-item" aria-current="page">Group List</li>
                                <li class="breadcrumb-item" aria-current="page">Group Content</li>
                                
                                    @if(empty($data['quiz']->title))
                                        <li class="breadcrumb-item active" aria-current="page">Create Quiz</li>
                                    @else
                                        <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $data['quiz']->title }}</li>
                                    @endif
                                </li>
                              
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @if($errors->any())
            <a class="btn btn-danger btn-sm md-12 ">
                <i class="ti-na">
                </i>
                {{$errors->first()}}
            </a>
            @endif
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <form action="/user/quiz2/insert" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-xl-12 col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="header-setting row">
                                <div class="row col-md-12">
                                    <div class="col-md-3 mb-4">
                                        <label for="title" class="form-label "><strong>Quiz Title</strong></label>
                                        <input type="text" oninput="this.value = this.value.toUpperCase()"  id="title" name="title" class="form-control"
                                            value="{{ empty($data['quiz']->title) ? "" : $data['quiz']->title }}" required>
                                    </div>
                                    <input type="text" id="quiz" name="quiz" value="{{ empty($data['quiz']->id) ? "" : $data['quiz']->id }}" hidden>
                                    <!--<div class="col-md-2 mb-4">
                                        <label for="extra-duration" class="form-label "><strong>extra Deadline</strong></label>
                                        <input type="datetime-local" oninput="this.value = this.value.toUpperCase()"  id="extra-duration" name="extra-duration" class="form-control"
                                            value="" required>
                                    </div>-->
                                    <div class="col-md-2 mb-4">
                                        <div class="form-group">
                                          <label class="form-label" for="folder">Lecturer Folder</label>
                                          <select class="form-select" id="folder" name="folder" required>
                                              <option value="" disabled selected>-</option>
                                              @foreach ($folder as $fold)
                                              <option value="{{ $fold->DrID }}" >{{ ($fold->newDrName == null) ? $fold->DrName : $fold->newDrName }}</option>
                                              @endforeach
                                          </select>
                                          <span class="text-danger">@error('folder')
                                            {{ $message }}
                                          @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="total-marks" class="form-label "><strong>Total Marks</strong><span></span></label>
                                        <input type="number" id="total-marks" name="marks" class="form-control"
                                        value="{{ empty($data['quiz']->total_mark) ? "" : $data['quiz']->total_mark }}" required>
                                    </div>
                                    
                                </div>
                                <div class="row col-md-12">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label class="form-label"><strong>Group List</strong></label>
                                            <div class="table-responsive" style="width:99.7%">
                                                <table id="table_registerstudent" class="w-100 table text-fade table-bordered table-hover display nowrap margin-top-10 w-p100">
                                                    <thead class="thead-themed">
                                                    <th>Name</th>
                                                    <th></th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($group as $grp)
                                                        <tr>
                                                            <td>
                                                                <label>{{$grp->name}}</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-check pull-right">
                                                                    <input type="checkbox" id="chapter_checkbox_{{$grp->name}}"
                                                                        class="form-check-input" name="group[]" value="{{$tsubject->id}}|{{$grp->id}}">
                                                                    <label class="form-check-label" for="chapter_checkbox_{{$grp->name}}"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group" >
                                            <label class="form-label">Chapter List</label>
                                            <div class="container mt-1" id="chapterlist">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="total-marks" class="form-label "><strong>Content</strong></label>
                                        <input type="file" id="myPdf" name="myPdf" class="form-control"><br required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-12">
                    <div class="card" style="width:100%">
                        <div class="card-body">
                            <button id="publish-quiz"  class="btn btn-info pull-right m-1"><i class="mdi mdi-publish"></i> Save & Publish</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </section>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-builder.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-render.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

<script>
var selected_folder = "";

$(document).on('change', '#folder', async function(e){
    selected_folder = $(e.target).val();

    await getChapters(selected_folder);
});

// Add form validation for group selection
$(document).on('click', '#publish-quiz', function(e){
    e.preventDefault();
    
    // Check if at least one group is selected
    var groupChecked = $('input[name="group[]"]:checked').length > 0;
    
    if (!groupChecked) {
        alert('Please select at least one group before submitting.');
        return false;
    }
    
    // If validation passes, submit the form
    $(this).closest('form').submit();
});

function getChapters(folder)
{

  return $.ajax({
        headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
        url      : "{{ url('user/quiz/getChapters') }}",
        method   : 'POST',
        data 	 : {folder: folder},
        error:function(err){
            alert("Error");
            console.log(err);
        },
        success  : function(data){
            
            //$('#lecturer-selection-div').removeAttr('hidden');
            //$('#lecturer').selectpicker('refresh');
  
            //$('#chapter').removeAttr('hidden');
                $('#chapterlist').html(data);
                //$('#chapter').selectpicker('refresh');
        }
    });

}
</script>



@stop
