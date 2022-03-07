<div class="form-group">
    <label for="description">Mô tả</label>
    <textarea name="description" class="form-control" id="description" rows="10"></textarea>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="types">Loại hình</label>
            <select name="types[]" class="form-control select2" id="types" style="width: 100%" multiple data-placeholder="Chọn một loại hình">
                @foreach(trans('football.types') as $key => $value)
                    <option value="{!! $key !!}">{!! $value !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Hoạt động</label>
            @foreach(trans('football.operation_times') as $key => $value)
                <div class="checkbox">
                    <label style="font-weight: 400;">
                        <input type="checkbox" name="operation_times[]" class="operation_times" value="{!! $key !!}">
                        {!! $value !!}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Mức giá</label>
            @foreach(trans('football.prices') as $key => $value)
                <div class="checkbox">
                    <label style="font-weight: 400;">
                        <input type="checkbox" name="prices[]" class="prices" value="{!! $key !!}">
                        {!! $value !!}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<fieldset id="custom-fieldset">
    <legend>Tiện nghi</legend>
    <div class="form-row">
        @foreach(trans('football.amenities') as $key => $value)
            <div class="checkbox col-sm-3" style="margin-top:0">
                <label style="font-weight: 400;">
                    <input type="checkbox" name="amenities[]" class="amenities" value="{!! $key !!}">
                    {!! $value !!}
                </label>
            </div>
        @endforeach
    </div>
</fieldset>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="capacity">Sức chứa</label>
            <input type="number" name="capacity" class="form-control" id="capacity" placeholder="Sức chứa">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="last_admission_time">Giờ nhận khách cuối</label>
            <input type="text" name="last_admission_time" class="form-control timepicker" id="last_admission_time" placeholder="Giờ nhận khách cuối">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="preparation_time">Thời gian chuẩn bị</label>
            <input type="text" name="preparation_time" class="form-control" id="preparation_time" placeholder="Thời gian chuẩn bị">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="holiday">Nghỉ lễ</label>
            <select name="holiday" class="form-control select2" id="holiday" style="width: 100%" multiple data-placeholder="Các ngày nghỉ trong năm">
                @foreach(trans('football.holiday') as $key => $value)
                    <option value="{!! $key !!}">{!! $value !!}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary" style="width: 100%">Tiếp tục</button>
    </div>
</div>
<script !src="">
    $('#detail_form').submit(function(event){
        event.preventDefault();
        let url = $(this).attr('action');
        let form_data = new FormData($(this)[0]);
        $.ajax({
            url: url,
            method: 'POST',
            data: form_data,
            processData: false,
            contentType: false,
            beforeSend:(res)=>{
                Swal.fire({
                    title: loading_message,
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            },
            success: function(res){
                if(res.status == 200){
                    if($('#check_edit').val() == 1)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: save_sucess,
                        })
                        $('#edit_tabs').find('.active').children().click();
                    }else {
                        Swal.close();
                        if(!$('.modal').hasClass('js-preview')){
                            $('.content-wrapper').html(res.view);
                        }else {
                            $("#modal_preview").modal('hide');
                            window.location.href = $(location).attr("href");
                        }
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Sever errors',
                        text: 'Something went wrong!',
                    })
                }
            },
            error: function (err){
                console.log(err);
                Swal.close();
            }
        })
    })
    $('.select2').select2();
    // setting ckeditor

    $('.timepicker').timepicker({
        showInputs: false,
        defaultTime: null,
        icons:
            {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            },
    })

</script>
