<div class="d-flex align-items-center">
    <a href="javascript:void(0)">
        <div class="image image-mini image-circle me-3">
            <img src="{{$row->services_image_url}}" alt="" class="user-img">
        </div>
    </a>
    <div class="d-flex flex-column">
        <a href="javascript:void(0)" class="mb-1 testimonial-show-btn text-decoration-none"
           data-id="{{$row->id}}">{{$row->name}}</a>
    </div>
</div>
