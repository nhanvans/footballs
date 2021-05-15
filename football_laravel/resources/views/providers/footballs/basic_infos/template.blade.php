<div class="card-body">

    <div class="form-group">
        <label for="name">Tên địa điểm</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Tên địa điểm">
    </div>

    <fieldset id="custom-fieldset">
        <legend>Tiện ích</legend>
        <div class="form-row">
            @foreach(trans('football.utilities') as $key => $value)
                <div class="checkbox col-sm-3" style="margin-top:0">
                    <label style="font-weight: 400;">
                        <input type="checkbox" name="utilities[]" class="utilities" value="{!! $key !!}" id="utilities_{!! $key !!}">
                        {!! $value !!}
                    </label>
                </div>
            @endforeach
        </div>
    </fieldset>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" id="phone" placeholder="000 0000 000">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="website">website</label>
                <input type="text" name="website" class="form-control" id="website" placeholder="www.aaa.bbb">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="email">email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="aaa@aaa.aaa">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="allow_view">Cho phép hiển thị <i class="fa fa-info-circle"></i> </label><br>
                <input type="checkbox" id="allow_view" class="" name="allow_view" value="1" checked data-bootstrap-switch>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="min_price">Giá thấp nhất</label>
                <input type="number" name="min_price" class="form-control" id="min_price" placeholder="Giá thấp nhất">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="max_price">Giá cao nhất</label>
                <input type="number" name="max_price" class="form-control" id="max_price" placeholder="Giá cao nhất">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary" style="width: 100%">Tiếp tục</button>
        </div>
    </div>
</div>
<!-- Bootstrap Switch -->
<script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js ') }}"></script>
<script !src="">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#football_form').submit(function(event){
            event.preventDefault();
            let method = $('input[name="_method"]').val();
            var url = $(this).attr('action');
            let form_data = $(this).serialize();

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: form_data,
                beforeSend:(res)=>{
                    Swal.fire({
                        title: loading_message,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: (res) => {
                    if(res.status == 200){
                        if($('#check_edit').val() == 1)
                        {
                            $('#edit_tabs').find('.active').children().click();
                            Swal.fire({
                                icon: 'success',
                                title: save_sucess,
                            }).then(()=>{
                                $("#phone").trigger('change');
                            })
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
                error: (res) => {
                    console.log(res);
                    if(res.responseJSON.status == 422){
                        Swal.close();
                        // console.log(res.responseJSON.data.errors);
                        printErrors(res.responseJSON.data.errors);
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Sever errors',
                            text: 'Something went wrong!',
                        })
                    }
                }
            })

        });

        function onchangeCss(input){
            $(input).next().attr('style','color: red;display:none;');
        }

        function printErrors(errors) {
            for (let [key, value] of Object.entries(errors)) {
                $("#error_"+key).replaceWith(`<p style="color: red;" id="error_${key}">${value[0]}</p>`);
            }
        }

        //setting phone pakage
        var input_phone_ct = document.querySelector("#phone");
        var iti = window.intlTelInput(input_phone_ct, {
            initialCountry: "vn",
        });

        $("#phone").on('change', function(){
            input_phone_ct.value =  iti.getNumber();
            $("#phone").parent().next().attr('style','color: red;display:none;');
        })
    });
    //reload

    $(document).ready(function() {
        $("#phone").trigger('change');
    });
</script>
