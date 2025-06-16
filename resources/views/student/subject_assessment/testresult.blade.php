@extends('layouts.student.student')

@section('main')


<style>


#fb-rendered-form {
    clear:both;
    /* display:none; */
    button{
        float:right;
    }
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

input.collected-marks + label{
    float:right;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->	  
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">{{ $data['testtitle'] }} [Result]</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Academics</li>
                                <li class="breadcrumb-item" aria-current="page">Test</li>
                                <li class="breadcrumb-item" aria-current="page">{{ $data['testtitle'] }} [Result]</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6 p-4">
                    <div class="row mb-2">
                        <div class="col-md-3"><b>Participant Name</b></div>
                        <div class="col-md-9">{{ empty($data['fullname']) ? "N/A" : $data['fullname'] }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3"><b>Test Title</b></div>
                        <div class="col-md-9">{{ $data['testtitle'] }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3"><b>Duration</b></div>
                        <div class="col-md-9">{{ sprintf("%0d hour %02d minute",   floor($data['testduration']/60), $data['testduration']%60) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3"><b>Created At</b></div>
                        <div class="col-md-9">{{ date("d-M-Y (h:i:a l)", strtotime($data['created_at'])) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3"><b>Last Updated</b></div>
                        <div class="col-md-9">{{ date("d-M-Y (h:i:a l)", strtotime($data['updated_at'])) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3"><b>Submitted At</b></div>
                        <div class="col-md-9">{{ date("d-M-Y (h:i:a l)", strtotime($data['submittime'])) }}</div>
                    </div>
                </div>
                <div class="col-xl-12 col-12">
                    <div class=" d-flex justify-content-center">
                        <div id="fb-rendered-form" class="card" style="width:800px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="pull-left"> {{ $data['testtitle'] }}</h1>
                                        <div class="pull-right  badge badge-xl badge-success" style="font-size:1.2em">
                                                <label id="participant-mark"></label> <!--/ 
                                            <label id="total_mark" ></label>-->
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <form id="fb-render" class="mt-4"></form>
                                <hr>
                                @if ($data['comments'] == null)
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label class="form-label">Comments</label>
                                        <textarea id="commentss" name="commentss" class="form-control col-md-12 mt-3" rows="10" cols="80"></textarea>
                                     
                                    </div>   
                                </div>
                                @else
        
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label class="form-label">Comments</label>
                                        <textarea id="commentss" class="form-control col-md-12 mt-3" rows="10" cols="80" readonly>{{ $data['comments'] }}</textarea>
                                    </div>   
                                </div>
                                   
                                @endif
                                
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <button id="publish-result-btn" class="btn btn-danger pull-right">Publish Result</button>
                                        <a id="done-btn" href="/student/test/{{ Session::get('subjects')->id }}/{{ $data['testid'] }}" class="btn btn-success pull-right" hidden>Done</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
              
            </div>
            
        </section>
        
    </div>
</div>

@endsection

@section('content')
<!-- Scripts are already loaded in the layout, no need to reload them -->
<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>

<script>

var Test = {!! json_encode($data['test']) !!};
var selected_Test = {{ json_encode($data['testid']) }};
var selected_participant = {!! json_encode($data['testuserid']) !!};
var Test_status = {{ json_encode($data['studentteststatus']) }};
var index = "{{ $data['questionindex'] }}";

// Wait for DOM and all scripts to be fully loaded
$(document).ready(function(){
    console.log('Document ready, checking script availability...');
    console.log('jQuery version:', $.fn.jquery);
    console.log('formRender available:', typeof $.fn.formRender !== 'undefined');
    
    // Wait for formBuilder scripts to be available
    var checkScripts = setInterval(function() {
        if (typeof $.fn.formRender !== 'undefined') {
            clearInterval(checkScripts);
            console.log('Scripts loaded successfully, initializing...');
            initializeTestResult();
        } else {
            console.log('Waiting for formRender to load...');
        }
    }, 100);

    var selected_group = "";
    var input_date = "";

    // Initialize CKEditor
    if (document.querySelector('#comments')) {
        ClassicEditor
        .create(document.querySelector('#comments'), { height: '25em' })
        .then(newEditor => { editor = newEditor; })
        .catch(error => { console.log(error); });
    }
});

function initializeTestResult() {
    console.log('Initializing Test result...');
    console.log('Test status:', Test_status);
    console.log('Test data structure:', Test);

    if(Test_status == 2){
        console.log('Test status is 2 - showing waiting message');
        $('#fb-rendered-form').css('width','100%');
        $('#fb-rendered-form').html(`<p class="p-3 pb-2 pl-4 pr-4">Your Test is waiting to be graded ...</p>`);
    } else {
        console.log('Test status is not 2 - proceeding with form render');

        /* On Clicks */
        if (document.getElementById('publish-result-btn')) {
            document.getElementById('publish-result-btn').addEventListener('click', function() {
                $('[name="radio-question"]').removeAttr('disabled');
                $('[name="checkbox-question[]"]').removeAttr('disabled');

                const fbRender = document.getElementById("fb-render");

                $.ajax({
                    headers: {'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ url('user/test/updateTestresult') }}",
                    type: 'POST',
                    data:  {
                        Test: selected_Test,
                        participant: selected_participant,
                        final_mark: $('#participant-mark').html(),
                        comments: $('#commentss').val(),
                        data: window.JSON.stringify( {formData: $(fbRender).formRender("userData") })
                    },
                    error:function(err){
                        console.log(err);
                    },
                    success:function(res){
                        location.href = "/user/test/"+ selected_Test +"/"+selected_participant+"/result";
                    }
                });
            }, false);
        }
    }

    // Always attempt to render the form (unless status is 2)
    if(Test_status != 2) {
        console.log('Calling renderForm with Test data');
        renderForm(Test);
    }
    
    setTimeout(() => {
        renderMark();
        
        $('[name="radio-question"]').attr("disabled","disabled");
        $('[name="checkbox-question[]"]').attr("disabled","disabled");
        $('[name="subjective-text"]').attr("disabled","disabled");

        //remove editing features if published
        if( Test_status == 3 ){ 
            console.log('Test status is 3 - disabling editing features');
            $('.collected-marks').attr("disabled","disabled");
            $('#publish-result-btn').hide();
            $('#done-btn').removeAttr('hidden');
        }
    }, 1000); // Increased timeout to ensure form renders first

    /* On Changes */
    $(document).on('change', '.collected-marks', function(e){
        renderMark();
    });
}

function renderForm(formdata){
    console.log('renderForm called with data:', formdata);
    
    // Check if formRender is available
    if (typeof $.fn.formRender === 'undefined') {
        console.error('formRender plugin is not loaded');
        $('#fb-rendered-form').html('<p class="p-3 text-danger">Form rendering scripts not loaded. Please refresh the page.</p>');
        return;
    }

    try {
        const fbRender = document.getElementById("fb-render");
        
        if (!fbRender) {
            console.error('fb-render element not found');
            return;
        }
        
        // Check if Test data exists and has content
        if (!formdata) {
            console.error('No Test data provided');
            $('#fb-rendered-form').html('<p class="p-3">No Test data available</p>');
            return;
        }

        // Handle different data structures
        let TestContent = formdata;
        if (formdata.content) {
            try {
                TestContent = JSON.parse(formdata.content);
                if (TestContent.formData) {
                    TestContent = TestContent.formData;
                }
            } catch (e) {
                console.error('Error parsing Test content:', e);
                TestContent = formdata;
            }
        }

        console.log('Processed Test content:', TestContent);

        var formRenderOptions = {
            dataType: 'json',
            formData: typeof TestContent === 'string' ? TestContent : JSON.stringify(TestContent),
            onRender: function() {
                console.log('Form rendered successfully');
                const fileInputs = document.querySelectorAll('#fb-render input[type="file"]');
                fileInputs.forEach(function(fileInput) {
                    if (fileInput.name) {
                        const img = document.createElement('img');
                        img.src = fileInput.name;
                        img.alt = 'uploaded_image';
                        img.className = 'uploaded-image';
                        fileInput.parentNode.insertBefore(img, fileInput.nextSibling);
                        fileInput.style.display = 'none';
                    }
                });
            }
        };

        $(fbRender).formRender(formRenderOptions);

        // Disable form elements after a short delay
        setTimeout(() => {
            for(let i=0; i < index; i++){
                $(`[name="radio-question${i}"]`).attr("disabled","disabled");
                $(`[name="checkbox-question${i}[]"]`).attr("disabled","disabled");
                $(`[name="subjective-text${i}"]`).attr("disabled","disabled");
            }
        }, 100);

    } catch(error) {
        console.error('Error rendering form:', error);
        $('#fb-rendered-form').html('<p class="p-3 text-danger">Error loading Test form: ' + error.message + '</p>');
    }
}

function renderMark(){
    var total_mark = 0, total_correct_mark = 0; total_correct_input = 0; total_all = 0;
   
    $('.collected-marks').each((i)=>{
        var checkbox = $($('.collected-marks')[i]);

        var mark = checkbox.val();
        mark = parseInt(mark);

        if(checkbox.is(':checked')){
            total_correct_mark = total_correct_mark + mark;
        }
        
        total_mark = total_mark + mark;
    });

   
    $('.inputmark').each(function() {
        total_correct_input += parseInt($(this).val());
    });

    total_all = total_correct_mark + total_correct_input;

    $('#participant-mark').html(total_all + " Mark");
}
</script>

@endsection
