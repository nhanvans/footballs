
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

<div class="card-body">

    @if(isset($openTime))
        @foreach($openTime as $key => $value)
            <div class="row" style="margin-bottom: 1em;">

                <div class="col-xs-4 col-md-3 col-lg-2">
                    <div class="row">
                        <div class="col-xs-4 col-md-4 col-lg-2">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="{!! $key !!}[CHECK]" value="checked" id="{!! $key !!}_label" class="flat-red" {{ isset($value->CHECK) ? 'checked': '' }}>
                                <label for="{!! $key !!}_label"></label>
                            </div>
                        </div>
                        <div class="col-xs-8 col-md-6 col-lg-7 col-lg-offset-5" style="margin: 0">
                            <label style="font-weight: normal;" for="{!! $key !!}_label">
                                {!! __('public.week_days.'.$key) !!}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-xs-8 col-md-9 col-lg-9">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-5"  style="padding: 0">
                            <input name="{!! $key !!}[OPEN]" id="open-{!! $key !!}" type="text" value="{{ isset($value->OPEN) ? $value->OPEN: '' }}" class="form-control timepicker" style="display: inline-table;width:44%">&nbsp;|
                            <input name="{!! $key !!}[CLOSE]" id="close-{!! $key !!}" type="text" value="{{ isset($value->CLOSE) ? $value->CLOSE: '' }}" class="form-control timepicker" style="display: inline-table;width:44%">
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-5" {!! (isset($value->OPEN2))  ? "style='padding: 0;display: inline'": "style='padding: 0;display: none'" !!} id="time_plus">
                            <input name="{!! $key !!}[OPEN2]" id="open-{!! $key !!}-2" type="text" value="{{ isset($value->OPEN2) ? $value->OPEN2: '' }}" class="form-control timepicker" style="display: inline-table;width:44%">&nbsp;|
                            <input name="{!! $key !!}[CLOSE2]" id="close-{!! $key !!}-2" type="text" value="{{ isset($value->CLOSE2) ? $value->CLOSE2: '' }}" class="form-control timepicker" style="display: inline-table;width:44%">
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-2">
                            <div class="row">
                                {!! isset($value->OPEN2) ?"<p class='btn btn-danger' id='close_time' onclick='close_time(this)'><i class='fa fa-trash'></i></p>" : "<p class='btn btn-primary' id='add_time' onclick='add_time(this)'><i class='fa fa-plus-square'></i></p>" !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    @else
        @foreach(trans('football.open_times.day') as $key => $value)
            <div class="row" style="margin-bottom: 1em;">

                <div class="col-xs-4 col-md-3 col-lg-2">
                    <div class="row">
                        <div class="col-xs-4 col-md-4 col-lg-2">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="{!! $key !!}[CHECK]" id="{!! $key !!}_label" value="checked" class="flat-red">
                                <label for="{!! $key !!}_label"></label>
                            </div>
                        </div>
                        <div class="col-xs-8 col-md-6 col-lg-7 col-lg-offset-5" style="margin: 0">
                            <label style="font-weight: normal;" for="{!! $key !!}_label">
                                {!! $value !!}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-xs-8 col-md-9 col-lg-9">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-5"  style="padding: 0">
                            <input name="{!! $key !!}[OPEN]" id="open-{!! $key !!}" type="text" class="form-control timepicker" style="display: inline-table;width:44%">&nbsp;|
                            <input name="{!! $key !!}[CLOSE]" id="close-{!! $key !!}" type="text" class="form-control timepicker" style="display: inline-table;width:44%">
                        </div>

                        <div class="col-xs-12 col-md-12 col-lg-5" style="padding: 0;display: none" id="time_plus">
                            <input name="{!! $key !!}[OPEN2]" id="open-{!! $key !!}-2" type="text" class="form-control timepicker" style="display: inline-table;width:44%">&nbsp;|
                            <input name="{!! $key !!}[CLOSE2]" id="close-{!! $key !!}-2" type="text" class="form-control timepicker" style="display: inline-table;width:44%">
                        </div>
                        <div class="col-xs-12 col-md-12 col-lg-2">
                            <div class="row">
                                <p class="btn btn-primary" id="add_time" onclick="add_time(this)"><i class="fa fa-plus-square"></i></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary" style="width: 100%">Tiếp tục</button>
        </div>
    </div>
</div>
<script !src="">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function add_time(e)
    {
        $(e).parent().parent().prev().attr('style','padding: 0');
        $(e).children().replaceWith(`<i class="fa  fa-trash"></i>`);
        $(e).attr('class','btn btn-danger');
        $(e).attr('onclick','close_time(this)');
    }

    function close_time(e)
    {
        $(e).parent().parent().prev().attr('style','padding: 0;display:none');
        $(e).children().replaceWith(`<i class="fa fa-plus-square"></i>`);
        $(e).attr('class','btn btn-primary');
        $(e).attr('onclick','add_time(this)');
        $(e).parent().parent().prev().children().val(' ');
    }

    $('#open_time_form').submit(function(event){
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
                        $('.content-wrapper').html(res.view);
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

    //Flat red color scheme for iCheck
    // $('input[type="checkbox"].flat-red').iCheck({
    //     checkboxClass: 'icheckbox_flat-green',
    //     radioClass   : 'iradio_flat-green'
    // });
    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false,
        defaultTime: null,
        icons:
            {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            },
    })
    // $('.timepicker').click(()=>{
    // 	console.log($(".timepicker").timepicker().val())
    // })

</script>
