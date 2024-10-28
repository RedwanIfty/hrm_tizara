<div class="col-md-6 d-flex">
    <div class="card profile-box flex-fill">
        <div class="card-body">
            <h3 class="card-title">Experience</h3> 
            <div class="experience-box">
                <ul class="experience-list">
                    @forelse($experience as $exp)
                        <li>
                            <div class="experience-user">
                                <div class="before-circle"></div>
                            </div>
                            <div class="experience-content">
                                <div class="timeline-content">
                                    <a href="#/" class="name">{{ $exp->designation }} at {{ $exp->company_name }}</a>
                                    <span class="time">{{ \Carbon\Carbon::parse($exp->date)->format('M Y') }}</span>
                                    {{-- <p class="responsibilities">{{ $experience->key_responsibilities }}</p> --}}
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>No experience information available.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
