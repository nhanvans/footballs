<ul class="nav nav-tabs edit_tabs" id="custom-tabs-four-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" data-url="{{route('footballs.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" data-url="{{route('details.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" data-url="{{route('social-networks.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Messages</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" data-url="{{route('locations.index')}}" onclick="loadForm(this)" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Settings</a>
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
                    let view = $(res).find('.card-primary').children();
                    view.find('button[type=submit]').html(save);
                    view.find('.btn--load-view').html(save);
                    $('.card-primary').html(view);
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
