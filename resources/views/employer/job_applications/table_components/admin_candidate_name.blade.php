<!-- <a href="{{ url('candidates.show', $row->candidate->id)}}" class="text-decoration-none" data-turbo="false">
    {{$row->candidate->user->full_name }}
</a> -->



<div class="d-flex align-items-center">
    <a href="{{ route('candidates.show', $row->candidate->id) }}">
        <div class="image image-circle image-mini me-3">
            <img src="{{ $row->candidate->candidate_url }}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a href="{{ route('candidates.show', $row->candidate->id) }}"
           class="mb-1 text-decoration-none fs-6">
            {{ $row->candidate->user->full_name }}
        </a>
        <span class="fs-6">{{ $row->candidate->user->email }}</span>
    </div>
</div>
