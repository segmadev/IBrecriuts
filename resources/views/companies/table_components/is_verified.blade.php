<div class="d-flex justify-content-center">
    <div class="form-check form-switch">
        <input class="form-check-input isEmployerVerify" name="Is isVerify" type="checkbox" role="switch"
              {{$row->user->is_verified == 0 ? '' : 'checked'}}  data-id="{{$row->id}}">
        <span class="custom-switch-indicator"></span>
    </div>
</div>
