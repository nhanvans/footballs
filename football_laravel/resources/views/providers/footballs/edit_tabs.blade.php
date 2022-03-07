<input type="hidden" name="check_edit" value="1" id="check_edit">
<ul class="nav nav-tabs edit_tabs" id="custom-tabs-four-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" data-url="{{route('footballs.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Thông tin cơ bản</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" data-url="{{route('details.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Chi tiết</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" data-url="{{route('social-networks.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Mạng xã hội</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" data-url="{{route('locations.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Vị trí</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" data-url="{{route('images.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Hình ảnh</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" data-url="{{route('videos.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Video</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" data-url="{{route('open-times.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Thời gian mở cửa</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" data-url="{{route('services.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Dịch vụ</a>
    </li>
</ul>
<script !src="">
    function loadForm(tag)
    {
        $('.edit_tabs li a').css('pointer-events','');
        var url = $(tag).data('url');
        if(url != '')
        {
            $.ajax({
                url: $(tag).data('url'),
                method: 'GET',
                success: (res) => {
                    let view = $(res).find('.card-body').children();
                    view.find('button[type=submit]').html(save);
                    view.find('.btn--load-view').html(save);
                    $('.card-body').html(view);
                    $('.box-header').first().remove();
                    $('.edit_tabs .active').css('pointer-events','none');
                    // $('.edit_tabs li a:not(.active)').css('pointer-events','auto');
                },
                error: (err) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sever errors',
                        text: 'Something went wrong!',
                    })
                }
            })
        }
    }
</script>
