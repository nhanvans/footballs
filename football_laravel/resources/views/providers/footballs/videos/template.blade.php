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

    .col-sm-4 {
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
            Chúng tôi sẽ hiển thị những video này trong trang của Quý vị trên trang web football.vn.
        </div>
    </div>
    <div class="col-sm-12">
        <div class="container--border-dashed" onclick="selectFile()">
            <div class="row">
                <div class="gallery js-video" id="general">
                    <?php $i=0;?>
                    @if(isset($videos) && $videos->links != null  )
                        @foreach(explode(',',$videos->links) as $video)
                            <div class='col-sm-4' id='{{$i}}'>
                                <video src="{{config('app.s3.link').$video}}" style='height:200px;width:100%;border:1px solid grey' controls></video>
                                <a href="javascript:;" data-url="{{route('videos.destroy',['id'=> $videos->id])}}" onclick="deleteFile(event, '{{$i}}', '{{$video}}')" class="deleteImage"><p style="text-align: center;padding-top: 5px"><em class="fa fa-trash" style='font-size:1.5em'></em>@lang('public.remove')</p></a>
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
        <input style="display:none" id="js-files" accept="video/*" multiple="" onchange="filesPreview(this,'general',3,500)" name="files_path[]" type="file">
        <input name="format_file" type="hidden" value="mp4,mpeg,ogg,webm,3gp,mov,flv,avi,wmv,ts">
        <input name="max_id" type="hidden" value="">
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" onclick="next(event)" style="width: 100%">Tiếp tục</button>
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


    // chuyen trang

    $(window).ready(function(){
        let url_delete = "{{route('videos.destroy',['video_id'])}}";
        let delete_file = "{{trans('public.delete_video')}}";
        let urlOpenTimeIndex = "{{ route('open-times.index') }}";
        changeDisplayIcon()
    })

    $('.btn--load-view').click(function(){
        if($('#check_edit').val() == 1)
        {
            Swal.fire({
                icon: 'success',
                title: save_sucess,
            }).then(()=>{
                $('#edit_tabs').children('li.active').children('a').trigger('click');
            })
        }else {
            next();
        }
    });
    function next(event){
        event.stopPropagation();
        event.preventDefault();
        $.ajax({
            method: "GET",
            url: urlOpenTimeIndex,
            success: function (res) {
                $('.content-wrapper').html(res);
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    //upload file

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function deleteFile(event, div_id, link)
    {
        event.stopPropagation();
        Swal.fire({
            title: delete_file,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: cancel,
            confirmButtonText: yes
        }).then((result) => {
            if (result.value) {
                var url = $("#"+div_id).children('a').attr('data-url');
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data:{
                        link: link
                    },
                    success: function (res) {

                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
                document.getElementById(div_id).remove();
                changeDisplayIcon();
            };
        });
    }

    function filesPreview(input, placeToInsertFilePreview,hidden_id,number_file,size,layout_id) {
        let format = $("input[name='format_file']").val();

        var validExtensions = format.split(','); //array of valid extensions
        var k;
        if (input.files) {
            let filesAmount = input.files.length; //
            k = $("input[name='max_id']").val();
            if(k == ''){
                let count_layout = [];
                count_layout.push($("#general").children('div:last-child').attr('id')||0);
                $("div.js-layout").each(function(index){
                    count_layout.push($(this).children('div:last-child').attr('id')||0);
                })
                k = Math.max.apply(Math,count_layout);
            }
            if(filesAmount > number_file){
                Swal.fire(limit_number_file.replace('number_file', number_file));
            }

            for (g = 0; g < filesAmount && g < number_file ; g++)
            {
                k++;
                var file= input.files[g];
                var name = input.files[g].name;
                var fileNameExt = name.substr(name.lastIndexOf('.') + 1);
                var FileSize = input.files[g].size / 1024 / 1024; // in MB
                if (FileSize > size) {
                    Swal.fire(error_file);
                    break;
                }
                if ($.inArray(fileNameExt, validExtensions) == -1) {
                    Swal.fire(format_file+validExtensions.join(', '));
                    break;
                }
                readerFile(k,name,hidden_id,placeToInsertFilePreview,file,layout_id);
            }
        }
        input.value = '';
    }

    function checkAllUploadSuccess(){

        $("#general").children('div').each(function(index){
            if(!$(this).children('a').hasClass('deleteImage')){
                prompt = true;
            }else{
                prompt = false;
            }
        })
        $("div.js-layout").each(function(i){
            $(this).children('div').each(function(index){
                if(!$(this).children('a').hasClass('deleteImage')){
                    prompt = true;
                }else{
                    prompt = false;
                }
            })
        })
    }

    function uploadFiles(k,file,hidden_id,layout_id) {
        var form_data = new FormData();
        form_data.append("file",file);
        let food_place_id = $("input[name='food_place_id']").val();
        form_data.append('food_place_id', food_place_id);
        let method = $('input[name="_method"]').val();
        if(typeof method != 'undefined'){
            form_data.append('_method', method);
            // console.log(method);
        }
        var action = $("#video_form").attr('action');
        $.ajax({
            xhr: function () {
                var div = document.getElementById(k);
                //Div.Progress
                var Progress = document.createElement('div');
                Progress.className = 'progress ';
                //Div.Progress-bar
                var ProgressBar = document.createElement('div');
                ProgressBar.className = 'progress-bar';
                //Div.Progress-text
                var ProgressText = document.createElement('div');
                ProgressText.className = 'progress-text';
                //Thêm Div.Progress-bar và Div.Progress-text vào Div.Progress
                Progress.append(ProgressBar);
                Progress.append(ProgressText);
                //Thêm Div.Progress và Div.Progress-bar vào Div.Progress-group
                div.append(Progress);
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        ProgressBar.style.width = Math.floor(percentComplete * 100) + '%';
                        ProgressText.innerHTML = Math.floor(percentComplete * 100) + '%';
                        if (percentComplete === 1) {
//    		                    $('.progress').fadeOut(3000);
                        }
                    }
                }, false);
                xhr.onreadystatechange = function(event) {
                    //Ki?m tra di?u ki?n
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        ProgressBar.style.background = ''; //B? hình ?nh x? lý
                        try { //B?y l?i JSON
                            var server = JSON.parse(xhr.responseText);
                            if (server.status) {
                                ProgressBar.className += ' progress-bar-success'; //Thêm class Success
                                ProgressBar.innerHTML = server.message; //Thông báo
                                Progress.style.marginBottom = '2px';

                            } else {
                                ProgressBar.className += ' progress-bar-danger'; //Thêm class Danger
                                ProgressBar.innerHTML = server.message; //Thông báo

                            }
                        } catch (e) {
                            ProgressBar.className += ' progress-bar-danger'; //Thêm class Danger
                            ProgressBar.innerHTML = e.message; //Thông báo
                        }
                    }
                    xhr.removeEventListener('progress',()=>{},true); //Bo bat su kien
                }
                return xhr;
            },
            method: "POST",
            url: action,
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                let link;
                let markup_delete, markup_name;
                link = url_delete.replace('video_id',res.data.video_id);
                markup_delete = "<a href='javascript:;' data-url="+link+" onclick='deleteFile(event, "+k+",\""+res.data.link+"\")' class='deleteImage'><p style='text-align: center;padding-top:5px'><em class='fa fa-trash' style='font-size:1.5em'></em> "+remove+" </p></a>";
                if(res.table == 'audios'){
                    markup_name = "<p title='"+res.data.name+"' style='text-align:center;overflow: hidden;text-overflow:ellipsis;'>"+res.data.name+"</p>";
                    $('div#'+k).append(markup_name);
                }
                $('div#'+k).append(markup_delete);
            },
            error: function (err) {
            }
        });
    }

    function changeDisplayIcon(){
        let count_image = $('#general').children().length
        if(count_image >= 1){
            $('.center-parent').css('display', 'none');
        }else{
            $('.center-parent').css('display', 'block');
        }
    }

    function selectFile(){
        $('#js-files').click();
    }
    //video js
    function readerFile(k,name,hidden_id,placeToInsertFilePreview,file,layout_id){
        var reader = new FileReader();
        var markup1;
        reader.onload = function(event)
        {
            if(layout_id != 0){
                markup1 = "<div class='col-sm-4' id="+k+"><video src="+event.target.result+" style='height:200px;width:100%;border:1px solid #428bcaa3' controls> </video> </div>";
            }else{
                markup1 = "<div class='col-sm-4' id="+k+"><video src="+event.target.result+" style='height:200px;width:100%;border:1px solid #428bcaa3' controls> </video> </div>";
            }

            $('#'+placeToInsertFilePreview).append(markup1);
            let last_id = $("input[name='max_id']").val();
            if(last_id < k){
                $("input[name='max_id']").val(k);
            }
            uploadFiles(k,file,hidden_id,layout_id);
            changeDisplayIcon();
        };
        reader.readAsDataURL(file);
    }


</script>
