@extends('providers.layouts.master')

@section('css-content')

@endsection

@section('script-content')
    <!-- Bootstrap Switch -->
    <script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js ') }}"></script>
    <script !src="">

        $(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        })

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
                        if(res.results.success == true){
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
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tạo trang thông tin của bạn</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Sân bóng</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <div class="progress mb-2" style="border-radius: 25px">
                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 2%">
                            <span class="sr-only">2% Complete (success)</span>
                        </div>
                    </div>
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0"><i class="fa fa-info-circle"></i> Thông tin cơ bản
                            </h5>
                        </div>
                        <!-- form start -->
                        <form action="footballs" method="post" accept-charset="UTF-8" id="football_form">
                            @csrf
                          @include('providers.footballs.basic_infos.template')
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
