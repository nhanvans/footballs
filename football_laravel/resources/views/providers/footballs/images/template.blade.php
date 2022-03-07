<style>
    .container--border-dashed {
        border: 1px dashed #3c8dbc;
        padding: 15px 15px 0 15px;
        min-height: 200px;
        cursor: pointer;
        margin-bottom: 1rem;
    }

    .container--border-dashed:hover {
        border-width: 2px;
    }

    .col-sm-3 {
        padding-bottom: 15px !important;
        display: inline-table;
    }

    .center-parent {
        position: relative;
    }

    .center-me {
        width: 200px;
        height: 100px;
        position: absolute;
        top: 123px;
        left: 50%;
        margin: -50px 0 0 -100px;
    }

    /*css image model create edit page*/
    #modal_image #imgModal{
        max-height: 70%;
    }

    .gallery{
        width: 100%;
    }
/*  file  */

    p{
        margin-bottom: 0px
    }

    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 10000; /* Sit on top */
        /*padding-top: 50px;  Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        /*background-color: rgb(0,0,0); /* Fallback color */
        /*background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        background-color:rgba(0,0,0,0.4);
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color:rgba(0,0,0,0.8);
        /*background-color: white;*/
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 100%;
        height: 100%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }

    .flex-center {
        height: 100%;
        display:flex;
        align-items: center;
        justify-content: center;
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

    @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fa fa-info"></i>  Thông báo!</h5>
            Chúng tôi sẽ hiển thị những hình ảnh này trong trang của Quý vị trên trang web football.vn.
        </div>
    </div>
    <div class="col-sm-12">
        <div class="container--border-dashed" onclick="selectFile()">
            <div class="row">
                <div class="gallery" id="general">
                    <?php $i=0;?>
                    @if(isset($images) && $images->images != '')
                        @foreach(explode(',',$images->images) as $image)
                            <div class='col-sm-3' id='{{$i}}'>
                                <img src="{{config('app.s3.link').$image}}" style='height:150px;width:100%;border:1px solid grey' onclick="showModal(event, '{{config('app.s3.link').$image}}')">
                                <a href="javascript:;" data-url="{{route('images.destroy',['id'=>$images->id])}}" onclick="deleteImage(event, '{{$i}}', '{{$image}}')" class="deleteImage"><p style="text-align: center;padding-top: 5px"><i class="fa fa-trash" style='font-size:1.5em'></i>@lang('public.remove')</p></a>
                            </div>
                            <?php $i++; ?>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="center-parent ">
                <i class="far fa-fw fa-plus-square fa-2x center-me"></i>
            </div>
        </div>
        <input type="file" name="images[]" id="imgInp" style="display: none" accept="image/x-png, image/jpeg, image/jpg" multiple onchange="imagesPreview(this,'general')">
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary" style="width: 100%">Tiếp tục</button>
    </div>
</div>
<div id="modal_image" class="modal">
    <div class="modal-content">
        <div class="row" style="height: 100%">
            <div class="col-sm-12" style="text-align: center; height:100%">
                <button id="btnclose" style="float:right;/* background-color:rgba(0,0,0,0.005)*/;border:none" onclick="hideModal()"><em style="font-size: 1.5em;color:gray" class="fa fa-times"></em></button>
                <div class="flex-center" style="height: 100%">
                    <img src="{{asset('assets/dist/img/noimages.png')}}" id="imgModal"/> <!--width="40%" height="40%"-->
                </div>
            </div>
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

        $('#image_form').submit(function (event) {
            event.preventDefault();
            var url = $(this).attr('action');

            let form_data = new FormData();

            for (let i = 0, len = filesToUpload.length; i < len; i++) {
                form_data.append("images[]", filesToUpload[i].file);
            }
            let method = $('input[name="_method"]').val();
            if(typeof method != 'undefined'){
                form_data.append('_method', method);
                // console.log(method);
            }

            console.log(url)
            console.log(form_data.get('images[]'))
            console.log(method)

            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: (res) => {
                    Swal.fire({
                        title: loading_message,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: (res) => {
                    if (res.status == 200) {
                        if ($('#check_edit').val() == 1) {
                            $('#edit_tabs').find('.active').children().click();
                            Swal.fire({
                                icon: 'success',
                                title: save_sucess,
                            })
                        } else {
                            Swal.close();
                            $('.content-wrapper').html(res.view);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sever errors',
                            text: 'Something went wrong!',
                        })
                    }
                },
                error: (res) => {
                    console.log(res);
                    if (res.responseJSON.status == 422) {
                        Swal.close();
                        // console.log(res.responseJSON.data.errors);
                        printErrors(res.responseJSON.data.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sever errors',
                            text: 'Something went wrong!',
                        })
                    }
                }
            })

        });

    });

    function selectFile() {
        $('#imgInp').click();
    }

    function showModal(event,img_src)
    {
        event.stopPropagation();
        var modal = document.getElementById("modal_image");
        modal.style.display = "block";
        $('#imgModal').attr('src',img_src);
    }

    function hideModal(){
        var modal = document.getElementById("modal_image");
        modal.style.display = "none";
    }

    function deleteImage(event, div_id, image)
    {
        let title_delete_image = "Bạn muốn xóa hình ảnh này ?";
        event.stopPropagation();
        let url = $("#"+div_id).children('a').attr('data-url');
        Swal.fire({
            title: title_delete_image,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: cancel,
            confirmButtonText: yes
        }).then((result) => {
            if (result.value) {
                if (url != '') {
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data:{
                            image: image
                        },
                        success: function (response) {
                        },
                        error: function (err) {
                        }
                    });
                }
                document.getElementById(div_id).remove();
                let file_length = filesToUpload.length;
                for (var i = 0; i < file_length; ++i) {
                    if (filesToUpload[i].id == div_id){
                        filesToUpload.splice(i, 1);
                    }
                }
                file_length = filesToUpload.length;
                if(file_length == 0){
                    change = false;
                    $('a#submit').text(btn_continue);
                    prompt = false;
                }
                changeDisplayIcon()
            };
        });

    }


    var filesToUpload = new Array();
    function imagesPreview(input, placeToInsertImagePreview) {
        var validExtensions = ['image/jpg','image/png','image/jpeg']; //array of valid extensions
        if (input.files) {
            var filesAmount = input.files.length;
            var k = $(".gallery").children('div:last-child').attr('id');
            if (typeof k == "undefined" ) {k = 0}
            for (g = 0; g < filesAmount; g++)
            {
                k++;
                var file= input.files[g];
                var type = input.files[g].type;
                var FileSize = input.files[g].size / 1024 / 1024; // in MB
                if (FileSize > 40) {
                    Swal.fire(error_image);
                    break;
                }
                if ($.inArray(type, validExtensions) == -1) {
                    input.value = '';
                    Swal.fire(format_file+validExtensions.join(', '));
                    break;
                }
                filesToUpload.push({
                    id: k,
                    file: file
                });
                readerFileImages(k,placeToInsertImagePreview,file);
            }
        }
        input.value = '';

    }

    function readerFileImages(k,placeToInsertImagePreview,file){
        var reader = new FileReader();
        reader.onload = function(event)
        {
            var markup1 = "<div class='col-sm-3' id="+k+"><img src="+event.target.result+" style='height:150px;width:100%;border:1px solid #428bcaa3' onclick='showModal(event, \""+event.target.result+"\")'> <a href='javascript:;' data-url='' onclick='deleteImage(event ,"+k+", null)' class='deleteImage'><p style='text-align: center;padding-top:5px'><em class='fa fa-trash' style='font-size:1.5em'></em> "+remove+" </p></a></div>";
            $('#'+placeToInsertImagePreview).append(markup1);
            changeDisplayIcon()
        };
        reader.readAsDataURL(file);
    }

    function changeDisplayIcon(){
        let count_image = $('#general').children().length
        if(count_image >= 1){
            $('.center-parent').css('display', 'none');
        }else{
            $('.center-parent').css('display', 'block');
        }
    }

</script>
