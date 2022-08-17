<div class="form-group">
    {!! Form::label('name', 'Tên địa điểm') !!}
    {!! Form::text('name', isset($footballPlace) ? $footballPlace->name : '', ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Tên địa điểm']) !!}
    <p id="error_name" style="display: none"></p>
</div>

<fieldset id="custom-fieldset">
    <legend>Tiện ích</legend>
    <div class="form-row">
        @php
            $arrFootballPlaceUtilities = isset($footballPlace) ? explode(',', $footballPlace->utilities) : [];
        @endphp
        @foreach(trans('football.utilities') as $key => $value)
            <div class="checkbox col-sm-3" style="margin-top:0">
                <label style="font-weight: 400;">
                    {!! Form::checkbox('utilities[]', $key, in_array($key, $arrFootballPlaceUtilities), ['class' => 'utilities', 'id' => 'utilities_'.$key]) !!}
{{--                    <input type="checkbox" name="utilities[]" class="utilities" value="{!! $key !!}" id="utilities_{!! $key !!}">--}}
                    {!! $value !!}
                </label>
            </div>
        @endforeach
    </div>
</fieldset>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('phone', 'Số điện thoại') !!}
            {!! Form::text('phone', isset($footballPlace) ? $footballPlace->phone : '', ['class' => 'form-control', 'id' => 'phone', 'placeholder' => '000 0000 000']) !!}
            <p id="error_phone" style="display: none"></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('website', 'Website') !!}
            {!! Form::text('website', isset($footballPlace) ? $footballPlace->website : '', ['class' => 'form-control', 'id' => 'website', 'placeholder' => 'www.aaa.bbb']) !!}
            <p id="error_website" style="display: none"></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', isset($footballPlace) ? $footballPlace->email : '', ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'aaa@aaa.aaa']) !!}
            <p id="error_email" style="display: none"></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('allow_view', 'Cho phép hiển thị ') !!}<i class="fa fa-info-circle"></i>  <br>
            {!! Form::checkbox('allow_view', '1', isset($footballPlace) ? $footballPlace->allow_view : '', ['class' => '', 'id' => 'allow_view', 'data-bootstrap-switch']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('min_price', 'Giá thấp nhất') !!}
            {!! Form::number('min_price', isset($footballPlace) ? $footballPlace->min_price : '', ['class' => 'form-control', 'id' => 'min_price', 'placeholder' => 'Giá thấp nhất']) !!}
            <p id="error_min_price" style="display: none"></p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('max_price', 'Giá cao nhất') !!}
            {!! Form::number('max_price', isset($footballPlace) ? $footballPlace->max_price : '', ['class' => 'form-control', 'id' => 'max_price', 'placeholder' => 'Giá cao nhất', 'onchange' => 'onchangeCss(this)']) !!}
            <p id="error_max_price" style="display: none"></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {!! Form::submit('Tiếp tục', ['class' => 'btn btn-primary', 'style' => 'width: 100%']) !!}
    </div>
</div>

<!-- Bootstrap Switch -->
<script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js ') }}"></script>
<script src="{{ asset('assets/footballs/js/basic-info.js') }}"></script>
<script>
    $(function () {
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    })
</script>
