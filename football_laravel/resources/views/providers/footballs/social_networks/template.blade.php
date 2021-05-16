<div class="card-body">

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" name="facebook" class="form-control" id="facebook">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="twitter">Twitter</label>
                <input type="text" name="twitter" class="form-control" id="twitter">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="youtube">Youtube</label>
                <input type="text" name="youtube" class="form-control" id="youtube">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="instagram">Instagram</label>
                <input type="text" name="instagram" class="form-control" id="instagram">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="zalo">Zalo</label>
                <input type="text" name="zalo" class="form-control" id="zalo">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="lotus">Lotus</label>
                <input type="text" name="lotus" class="form-control" id="lotus">
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary" style="width: 100%">Tiếp tục</button>
        </div>
    </div>
</div>
<script !src="">
    $('#social_form').submit(function(event){
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

</script>
