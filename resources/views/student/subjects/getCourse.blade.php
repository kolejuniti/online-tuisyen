<div class="row">
    @foreach ($data as $subject)
    <div class="col-md-4 course-item">
        <div class="course-card">
            <div class="course-image">
                <img src="{{ ($subject->subject->image) ? asset('storage/'.$subject->subject->image) : asset('assets/images/uniti.jpg') }}" 
                onerror="this.onerror=null;this.src='{{ asset('assets/images/uniti.jpg') }}';" 
                alt="{{ $subject->subject->name }}">                              
                <div class="fx-overlay">
                    <ul class="fx-info">
                        <li>
                            <a href="/student/{{ $subject->id }}" class="course-view-btn">
                                <i class="fa fa-paper-plane"></i> View Course
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="course-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="course-title">{{ ucwords($subject->subject->name) }}</h5>
                    <span class="badge-active">ACTIVE</span>
                </div>
                <div class="course-detail">
                    <strong>Lecturer:</strong> {{ $subject->teacher ? ucwords($subject->teacher->name) : 'NOT ASSIGNED' }}
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>