$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#football_form').submit(function(event){
        event.preventDefault();
        let method = $('input[name="_method"]').val();
        let url = $(this).attr('action');
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
                    showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            },
            success: (res) => {
                if(res.status == 200){
                    if($('#check_edit').val() == 1)
                    {
                        $('#edit_tabs a').find('.active').children().click();
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
                    printErrors(res.responseJSON.errors);
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

    //setting phone pakage
    var input_phone_ct = document.querySelector("#phone");
    var iti = window.intlTelInput(input_phone_ct, {
        initialCountry: "vn",
    });

    $("#phone").on('change', function(){
        input_phone_ct.value =  iti.getNumber();
        $("#phone").parent().next().attr('style','display:none;');
    })
});
//reload

$(document).ready(function() {
    $("#phone").trigger('change');
});
