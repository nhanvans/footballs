@extends('providers.layouts.master')

@section('css-content')

@endsection

@section('script-content')
    <script !src="">
        $(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })
        })
    </script>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sửa trang thông tin của bạn</h1>
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
                    <!-- general form elements -->
                    <div class="card card-dark card-outline">
                    <div class="card-header">
                        @include('providers.footballs.edit_tabs')
                    </div>
                    </div>
                    <div class="card card-primary card-outline">

                        <!-- form start -->
                        <form action="{{ route('footballs.update', $footballPlace->id) }}" method="post" accept-charset="UTF-8" id="football_form">
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
