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
