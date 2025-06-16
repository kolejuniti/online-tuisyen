@extends('layouts.student')

@section('main')
<div class="content-wrapper" style="min-height: 695.8px;">
  <div class="container-full">
    
    <!-- Welcome Hero Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; overflow: hidden;">
          <div class="card-body p-5 position-relative">
            <div class="row align-items-center">
              <div class="col-lg-8">
                <h1 class="text-white mb-3 fw-bold">
                  <i class="mdi mdi-hand-wave text-warning me-2"></i>
                  Welcome back, {{ Auth::guard('student')->user()->name }}!
                </h1>
                                 <p class="mb-4 fs-5" style="color: rgba(255, 255, 255, 0.8);">Ready to continue your learning journey? Let's make today amazing!</p>
                <div class="d-flex flex-wrap gap-3">
                  <button class="btn btn-warning btn-lg rounded-pill px-4">
                    <i class="mdi mdi-rocket me-2"></i>Start Learning
                  </button>
                  <button class="btn btn-outline-light btn-lg rounded-pill px-4">
                    <i class="mdi mdi-chart-line me-2"></i>View Progress
                  </button>
                </div>
              </div>
              <div class="col-lg-4 text-end d-none d-lg-block">
                <div class="position-relative">
                  <i class="mdi mdi-school text-white-50" style="font-size: 120px; opacity: 0.3;"></i>
                </div>
              </div>
            </div>
            
            <!-- Floating elements for visual appeal -->
            <div class="position-absolute" style="top: 20px; right: 50px; opacity: 0.1;">
              <i class="mdi mdi-star text-warning" style="font-size: 60px;"></i>
            </div>
            <div class="position-absolute" style="bottom: 30px; right: 150px; opacity: 0.1;">
              <i class="mdi mdi-lightbulb text-warning" style="font-size: 40px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-sm rounded-circle bg-primary-light d-flex align-items-center justify-content-center">
                  <i class="mdi mdi-book-multiple text-primary" style="font-size: 24px;"></i>
                </div>
              </div>
                             <div class="flex-grow-1 ms-3">
                 <h3 class="mb-0 fw-bold text-dark">{{ $activeSubjects }}</h3>
                 <p class="text-muted mb-0">Active Subjects</p>
               </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-sm rounded-circle bg-success-light d-flex align-items-center justify-content-center">
                  <i class="mdi mdi-clipboard-check text-success" style="font-size: 24px;"></i>
                </div>
              </div>
                             <div class="flex-grow-1 ms-3">
                 <h3 class="mb-0 fw-bold text-dark">{{ $completedTests }}</h3>
                 <p class="text-muted mb-0">Completed Tests</p>
               </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-sm rounded-circle bg-warning-light d-flex align-items-center justify-content-center">
                  <i class="mdi mdi-quiz text-warning" style="font-size: 24px;"></i>
                </div>
              </div>
                             <div class="flex-grow-1 ms-3">
                 <h3 class="mb-0 fw-bold text-dark">{{ $pendingQuizzes }}</h3>
                 <p class="text-muted mb-0">Pending Quizzes</p>
               </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm hover-lift" style="border-radius: 15px; transition: all 0.3s ease;">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-sm rounded-circle bg-info-light d-flex align-items-center justify-content-center">
                  <i class="mdi mdi-forum text-info" style="font-size: 24px;"></i>
                </div>
              </div>
                             <div class="flex-grow-1 ms-3">
                 <h3 class="mb-0 fw-bold text-dark">{{ $forumPosts }}</h3>
                 <p class="text-muted mb-0">Forum Posts</p>
               </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
      
      <!-- Left Column -->
      <div class="col-lg-8">
        
        <!-- Recent Activities -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
          <div class="card-header border-0 bg-white p-4">
            <div class="d-flex align-items-center justify-content-between">
              <h5 class="mb-0 fw-bold">
                <i class="mdi mdi-clock-outline text-primary me-2"></i>Recent Activities
              </h5>
              <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
            </div>
          </div>
                     <div class="card-body p-0">
             <div class="list-group list-group-flush">
               @forelse($recentActivities as $activity)
               <div class="list-group-item border-0 p-4">
                 <div class="d-flex align-items-start">
                   <div class="flex-shrink-0">
                     <div class="avatar-sm rounded-circle bg-{{ $activity['color'] }}-light d-flex align-items-center justify-content-center">
                       <i class="mdi {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                     </div>
                   </div>
                   <div class="flex-grow-1 ms-3">
                     <h6 class="mb-1">{{ $activity['title'] }}</h6>
                     <p class="text-muted mb-2">{{ $activity['description'] }}</p>
                     <small class="text-muted">{{ $activity['time'] }}</small>
                   </div>
                 </div>
               </div>
               @empty
               <div class="list-group-item border-0 p-4 text-center">
                 <div style="color: #6c757d;">
                   <i class="mdi mdi-information-outline me-2" style="color: #6c757d;"></i>
                   No recent activities found. Start learning to see your progress here!
                 </div>
               </div>
               @endforelse
             </div>
           </div>
        </div>
        
        <!-- Progress Chart -->
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
          <div class="card-header border-0 bg-white p-4">
            <h5 class="mb-0 fw-bold">
              <i class="mdi mdi-chart-line text-primary me-2"></i>Learning Progress
            </h5>
          </div>
          <div class="card-body p-4">
            <div class="row">
                             <div class="col-md-6">
                 <h6 class="mb-3" style="color: #6c757d;">Subject Performance</h6>
                 @forelse($subjectPerformance as $performance)
                 <div class="mb-3">
                   <div class="d-flex justify-content-between mb-2">
                     <span>{{ $performance['subject'] }}</span>
                     <span class="text-{{ $performance['color'] }} fw-bold">{{ $performance['percentage'] }}%</span>
                   </div>
                   <div class="progress" style="height: 8px; border-radius: 10px;">
                     <div class="progress-bar bg-{{ $performance['color'] }}" style="width: {{ $performance['percentage'] }}%; border-radius: 10px;"></div>
                   </div>
                 </div>
                 @empty
                 <div class="text-center" style="color: #6c757d;">
                   <i class="mdi mdi-chart-line me-2" style="color: #6c757d;"></i>
                   No performance data available yet
                 </div>
                 @endforelse
               </div>
              
              <div class="col-md-6">
                                 <h6 class="mb-3" style="color: #6c757d;">Weekly Study Hours</h6>
                <div class="text-center">
                  <div class="position-relative d-inline-block">
                    <svg width="120" height="120" viewBox="0 0 120 120">
                      <circle cx="60" cy="60" r="45" fill="none" stroke="#e9ecef" stroke-width="8"/>
                      <circle cx="60" cy="60" r="45" fill="none" stroke="#667eea" stroke-width="8"
                              stroke-dasharray="283" stroke-dashoffset="85" stroke-linecap="round"
                              transform="rotate(-90 60 60)"/>
                    </svg>
                                         <div class="position-absolute top-50 start-50 translate-middle text-center">
                       <h4 class="mb-0 fw-bold text-primary">{{ $studyHours }}h</h4>
                       <small style="color: #6c757d;">This week</small>
                     </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Column -->
      <div class="col-lg-4">
        
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
          <div class="card-header border-0 bg-white p-4">
            <h5 class="mb-0 fw-bold">
              <i class="mdi mdi-lightning-bolt text-primary me-2"></i>Quick Actions
            </h5>
          </div>
          <div class="card-body p-4">
            <div class="d-grid gap-3">
              <button class="btn btn-outline-primary btn-lg rounded-pill text-start">
                <i class="mdi mdi-play-circle me-3"></i>Start New Quiz
              </button>
              <button class="btn btn-outline-success btn-lg rounded-pill text-start">
                <i class="mdi mdi-book-open-page-variant me-3"></i>Browse Content
              </button>
              <button class="btn btn-outline-info btn-lg rounded-pill text-start">
                <i class="mdi mdi-forum me-3"></i>Join Discussion
              </button>
              <button class="btn btn-outline-warning btn-lg rounded-pill text-start">
                <i class="mdi mdi-chart-bar me-3"></i>View Results
              </button>
            </div>
          </div>
        </div>
        
        <!-- Upcoming Deadlines -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
          <div class="card-header border-0 bg-white p-4">
            <h5 class="mb-0 fw-bold">
              <i class="mdi mdi-calendar-clock text-danger me-2"></i>Upcoming Deadlines
            </h5>
          </div>
                     <div class="card-body p-4">
             <div class="timeline">
               @forelse($upcomingDeadlines as $deadline)
               <div class="timeline-item {{ !$loop->last ? 'mb-3' : '' }}">
                 <div class="d-flex align-items-center">
                   <div class="timeline-marker bg-{{ $deadline['urgency'] }} rounded-circle me-3" style="width: 12px; height: 12px;"></div>
                   <div class="flex-grow-1">
                     <h6 class="mb-1">{{ $deadline['title'] }}</h6>
                     @if(isset($deadline['subtitle']))
                       <p class="text-muted mb-1 small">{{ $deadline['subtitle'] }}</p>
                     @endif
                     <small class="text-muted">{{ $deadline['time'] }}</small>
                   </div>
                 </div>
               </div>
                               @empty
                <div class="text-center" style="color: #6c757d;">
                  <i class="mdi mdi-calendar-check me-2" style="color: #6c757d;"></i>
                  No upcoming deadlines. Great job staying on top of your work!
                </div>
                @endforelse
             </div>
           </div>
        </div>
        
        <!-- Achievement Badge -->
                 <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);">
           <div class="card-body p-4 text-center">
             <div class="mb-3">
               <i class="mdi {{ $achievements['icon'] }} text-{{ $achievements['color'] }}" style="font-size: 48px;"></i>
             </div>
             <h5 class="fw-bold mb-2" style="color: #fff;">{{ $achievements['title'] }}</h5>
             <p class="mb-3" style="color: rgba(255, 255, 255, 0.8);">{{ $achievements['description'] }}</p>
             <button class="btn btn-light btn-sm rounded-pill px-3">
               <i class="mdi mdi-medal me-2"></i>View All Badges
             </button>
           </div>
         </div>
      </div>
    </div>
  </div>
</div>

<style>
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.bg-primary-light {
    background-color: rgba(102, 126, 234, 0.1);
}

.bg-success-light {
    background-color: rgba(40, 167, 69, 0.1);
}

.bg-warning-light {
    background-color: rgba(255, 193, 7, 0.1);
}

.bg-info-light {
    background-color: rgba(23, 162, 184, 0.1);
}

/* Ensure proper text contrast */
.text-muted {
    color: #6c757d !important;
}

.card-body .text-muted {
    color: #6c757d !important;
}

/* Fix timeline text visibility */
.timeline-item h6 {
    color: #212529 !important;
}

.timeline-item small {
    color: #6c757d !important;
}

/* Improve subject performance text */
.progress + .text-center {
    color: #6c757d !important;
}

/* Ensure activity descriptions are visible */
.list-group-item p {
    color: #6c757d !important;
}

.list-group-item small {
    color: #6c757d !important;
}

/* Card headers and titles */
.card-header h5 {
    color: #212529 !important;
}

/* Progress labels */
.progress ~ .d-flex span {
    color: #212529 !important;
}

/* Timeline subtitles */
.timeline-item p.small {
    color: #6c757d !important;
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.timeline-marker {
    box-shadow: 0 0 0 4px rgba(255,255,255,1);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 40px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.card {
    animation: fadeInUp 0.5s ease-out;
}

.card:nth-child(2) { animation-delay: 0.1s; }
.card:nth-child(3) { animation-delay: 0.2s; }
.card:nth-child(4) { animation-delay: 0.3s; }

/* Responsive improvements */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .h1 {
        font-size: 1.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add some interactive effects
    const cards = document.querySelectorAll('.hover-lift');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease-in-out';
            bar.style.width = width;
        }, 500);
    });
});
</script>

@endsection
