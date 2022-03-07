<style>
    .alert {
        border: 1px solid red !important;
    }
    label.error {
        display: grid;
        color:red;
        width: 250px;
        font-size: 1em;
        font-weight: normal;
        white-space: pre-line;
        /*float:left;*/
    }
    .col-sm-5,.col-sm-3,.col-sm-1,.col-sm-2,.col-sm-8{
        padding-bottom: 15px
    }
    .width-col{
        width: 4.3%;
    }
    .category{
        font-weight: bold;
    }
    hr{
        margin-top: 0
    }
    @media screen and (max-width: 1300px) {
        .width-col{
            width: 5.33333333%;
        }
    }
    @media screen and (max-width: 1100px) {
        .width-col{
            width: 8.33333333%;
        }
    }
</style>
    <div id="menu">
        @if(empty($typeServices))
            <div id="1" class="new">
                <div class="row category">
                    <div class="col-sm-offset-1 col-sm-8">
                        <input class="form-control category_name" type="text" id="category_name_1" placeholder="Tên danh mục" name="category_name[1]" value="">
                    </div>

                    <div class="col-sm-1">
                        <img style="cursor: pointer;padding-top:5px" src="{{asset('images/cancel.png')}}" class="btnDelete" onclick="deleteFoodAndCategory(this,'category',null)">
                    </div>
                </div>

                <div class="row" id="1" data-type="new">
                    <div class="col-sm-1">
                        <img src="{{asset('images/ServiceImages/move.png')}}" height="34" class="pull-right">
                    </div>
                    <div class=" col-sm-5">
                        <input class="form-control food_name" id="food_name_1" placeholder="Tên món" name="food_name[1]" type="text" value="">
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control price" id="price_1" placeholder="Giá tiền (VND)" name="price[1]" type="number" value="">
                    </div>
                    <div class="col-sm-1 width-col">
                        <label for="image_1_1" class="custom-file-upload">
                            <img src="https://provider.disanmientrung.vn/images/add_picture.png" class="image-input" width="34px" height="34px" id="preview_1_1" alt="upload photo">
                        </label>
                        <input style="display:none" id="image_1_1" onchange="previewImage(this,'preview_1_1')" accept="image/x-png, image/jpeg" class="image" name="image" type="file">
                    </div>
                    <div class="col-sm-1">
                        <img style="cursor: pointer;padding-top:5px" src="{{asset('images/cancel.png')}}" class="btnDelete" onclick="deleteFoodAndCategory(this,'food',null)">
                    </div>
                    <input id="move" data-id="1" name="move" type="hidden" value="false">
                </div>

            </div>
            <hr>
        @else
            @foreach($typeServices as $typeService)
                <div id="{{$typeService->id}}" class="old">
                    <div class="row category">
                        <div class="col-sm-offset-1 col-sm-8">
                            <input class="form-control category_name" type="text" id="category_name_{{$typeService->id}}" placeholder="Tên danh mục" name="category_name[{{$typeService->id}}]" value="{{isset($typeService->current_lang) ? $typeService->current_lang->name : ''}}">
                        </div>

                        <div class="col-sm-1">
                            <?php $ids = '';?>
                            @foreach($typeService->services as $service)
                                <?php  $ids .= $service->id.',';?>
                            @endforeach
                            <img style="cursor: pointer;padding-top:5px" src="{{asset('images/cancel.png')}}" class="btnDelete" onclick="deleteFoodAndCategory(this,'category',{{$typeService->id}})">
                                <input type="hidden" name="ids" value="{{$ids}}">
                        </div>
                    </div>

                    @foreach($typeService->services as $service)
                        <div class="row" id="{{$service->id}}" data-type="old">
                            <div class="col-sm-1">
                                <img src="{{asset('images/ServiceImages/move.png')}}" height="34" class="pull-right">
                            </div>
                            <div class="col-sm-5">
                                <input class="form-control food_name" id="food_name_{{$service->id}}" placeholder="Tên món" name="food_name[{{$service->id}}]" type="text" value="{{isset($service->current_lang) ? $service->current_lang->name : ''}}">
                            </div>
                            <div class="col-sm-3">
                                <input class="form-control price" id="price_{{$service->id}}" placeholder="Giá tiền (VND)" name="price[{{$service->id}}]" type="number" value="{{$service->price}}">
                            </div>
                            <div class="col-sm-1 width-col">
                                <label for="image_{{$typeService->id}}_{{$service->id}}" class="custom-file-upload">
                                    <img src="https://provider.disanmientrung.vn/images/add_picture.png" class="image-input" width="34px" height="34px" id="preview_{!! $typeService->id.'_'.$service->id !!}" alt="upload photo">
                                </label>
                                <input style="display:none" id="image_{!! $typeService->id.'_'.$service->id !!}" onchange="previewImage(this,'preview_{!! $typeService->id."_".$service->id !!}')" accept="image/x-png, image/jpeg" class="image" name="image" type="file">
                            </div>
                            <div class="col-sm-1">
                                <img style="cursor: pointer;padding-top:5px" src="{{asset('images/cancel.png')}}" class="btnDelete" onclick="deleteFoodAndCategory(this,'food',{{$food->id}})">
                            </div>
                            <input id="move" data-id="{{$typeService->id}}" name="move" type="hidden" value="false">
                        </div>
                    @endforeach
                </div>
                <hr>
            @endforeach
        @endif
    </div>
    <div class="row">
        <div class="col-sm-offset-1 col-sm-2">
            <button type="button" onclick="addFood()" class="btn btn-primary col-sm-12 col-xs-12"><i class="fa fa-plus-square"></i> &nbsp; @lang('foods.menu.add_food_button')</button>
        </div>
        <div class="col-sm-2">
            <button type="button" onclick="addCategory()" class="btn btn-primary col-sm-12 col-xs-12"><i class="fa fa-plus-square"></i> &nbsp; @lang('foods.menu.add_category_button')</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary" style="width: 100%">Tiếp tục</button>
        </div>
    </div>
<!-- Bootstrap Switch -->
<script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js ') }}"></script>
<script !src="">
    var delete_url = "{{route('services.delete')}}";
    var delete_food_title = "{{trans('foods.menu.delete_food_title')}}";
    var delete_category_title = "{{trans('foods.menu.delete_category_title')}}";
    var category_name_lb = "{{trans('foods.menu.category_name')}}";
    var food_name_lb = "{{trans('foods.menu.food_name')}}";
    var price_lb = "{{trans('foods.menu.price')}}";
    var add_image_link = "{{asset('/images/add_picture.png')}}";
    var max_length_message = "{{trans('foods.menu.rules.max_length_message')}}";
    var name_required_message = "{{trans('foods.menu.rules.name_required')}}";
    var price_required_message = "{{trans('foods.menu.rules.price_required')}}";
    var is_positive_integer_message = "{{trans('foods.menu.rules.is_positive_integer')}}";
    var category_required_message = "{{trans('foods.menu.rules.category_required')}}";
    var price_max_length_message = "{{trans('foods.menu.rules.price_max_length')}}";
{{--    var url_list_page = "{{route('manager.pageList', ['type' => 'food'])}}";--}}
    var is_unique_message = "{{trans('foods.menu.rules.is_unique_message')}}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function subm()
    {
        var form_data = new FormData();
        $(".new").each(function(){
            let id = $(this).attr("id");
            $(this).children().each(function(){
                if($(this).attr("class") == "row category" || $(this).attr("class") == 'row category ui-sortable-handle')
                {
                    form_data.append("new["+id+"][category_name]", $(this).find('.category_name').val());
                }else {
                    let type = $(this).attr("data-type");
                    let food_id = $(this).attr('id');
                    form_data.append("new["+id+"][food]["+type+"]["+food_id+"][name]", $(this).find('.food_name').val());
                    form_data.append("new["+id+"][food]["+type+"]["+food_id+"][price]", $(this).find('.price').val());
                    form_data.append("new["+id+"][food]["+type+"]["+food_id+"][image]", $(this).find('input[type=file]')[0].files[0]);
                    form_data.append("new["+id+"][food]["+type+"]["+food_id+"][move]", $(this).find('#move').val());
                }
            });
        });
        $(".old").each(function(){
            let id = $(this).attr("id");
            $(this).children().each(function(){
                if($(this).attr("class") == "row category" || $(this).attr("class") == 'row category ui-sortable-handle')
                {
                    form_data.append("old["+id+"][category_name]", $(this).find('.category_name').val());
                }else {
                    let food_id = $(this).attr("id");
                    let type = $(this).attr("data-type");
                    form_data.append("old["+id+"][food]["+type+"]["+food_id+"][name]", $(this).find('.food_name').val());
                    form_data.append("old["+id+"][food]["+type+"]["+food_id+"][price]", $(this).find('.price').val());
                    form_data.append("old["+id+"][food]["+type+"]["+food_id+"][image]", $(this).find('input[type=file]')[0].files[0]);
                    form_data.append("old["+id+"][food]["+type+"]["+food_id+"][move]", $(this).find('#move').val());
                }
            });
        });
        $.ajax({
            method: "POST",
            url: $("#menu_form").attr("action"),
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:(res)=>{
                Swal.fire({
                    title: loading_message,
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            },
            success: function (res) {
                if(res.results.success == true){
                    if($('#check_edit').val() == 1)
                    {
                        $('#edit_tabs').find('.active').children().click();
                        Swal.fire({
                            icon: 'success',
                            title: save_sucess,
                        })
                    }else {
                        Swal.close();
                        if(!$('.modal').hasClass('js-preview')){
                            $('.content-wrapper').html(res.view);
                            // window.location.href = url_list_page;
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
            error: function (err) {
                Swal.fire(server_issue);
            }
        });
    }

    var value = 0;
    var category_id = 0;
    var food_id = 0;
    $('#menu').children().each(function() {
        value = parseInt($(this).attr('id'));
        category_id = (value > category_id) ? value : category_id;
    });
    $('#menu').children().children().each(function() {
        value = parseInt($(this).attr('id'));
        food_id = (value > food_id) ? value : food_id;
    });

    function addFood()
    {
        var last_food_div = $("#menu > div").last();
        food_id++;
        var markup = "<div class='row' id='"+food_id+"' data-type='new' ><div class='col-sm-1'><img src="+move_icon+" height='34' class='pull-right'></div><div class='col-sm-5'><input class='form-control food_name' id='food_name_"+food_id+"' placeholder='"+food_name_lb+"' name='food_name["+food_id+"]' type='text' value=''></div><div class='col-sm-3'>	<input class='form-control price' id='price_"+food_id+"' placeholder='"+price_lb+"' name='price["+food_id+"]' type='number' value=''></div><div class='col-sm-1 width-col'><label for='image_"+category_id+"_"+food_id+"' class='custom-file-upload'><img src='"+add_image_link+"' class='image-input' width='34px' height='34px' id='preview_"+category_id+"_"+food_id+"' alt='upload photo'></label><input style='display:none' id='image_"+category_id+"_"+food_id+"' class='image' onchange=\"previewImage(this,'preview_"+category_id+"_"+food_id+"')\" accept='image/x-png, image/jpeg' name='image' type='file'></div><div class='col-sm-1'><img style='cursor: pointer;padding-top:5px' src='"+domain_public_link+"images/cancel.png' class='btnDelete' onclick=\"deleteFoodAndCategory(this,'food',null)\"></div><input id='move' name='move' type='hidden' value='false'></div>";
        last_food_div.append(markup);
        sortDiv();
    }

    function addCategory()
    {
        category_id++;
        var markup = "<div id='"+category_id+"' class='new'><div class='row category'><div class='col-sm-offset-1 col-sm-8'><input class='form-control category_name' type='text' id='category_name_"+category_id+"' placeholder='"+category_name_lb+"' name='category_name["+category_id+"]' value=''> </div><div class='col-sm-1'><img style='cursor: pointer;padding-top:5px' src='"+domain_public_link+"images/cancel.png' class='btnDelete' onclick=\"deleteFoodAndCategory(this,'category',null)\">	</div></div></div><hr>";
        $("#menu").append(markup);
        addFood();
    }

    function previewImage(input,preview_id)
    {
        var file= input.files[0];
        var name = input.files[0].name;
        var fileNameExt = name.substr(name.lastIndexOf('.') + 1);
        var validExtensions = ['jpg','png','jpeg', 'JPG', 'JPEG', 'PNG', 'jfif'];
        if ($.inArray(fileNameExt, validExtensions) < 0) {
            swal.fire(image_file+" "+validExtensions.join(', '));
            return false;
        }
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#'+preview_id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    String.prototype.trimChars = function (c) {
        var re = new RegExp("^[" + c + "]+|[" + c + "]+$", "g");
        return this.replace(re,"");
    }

    function deleteFoodAndCategory(input,type,id)
    {
        var delete_title;
        var parent;
        if(type == 'food')
        {
            delete_title = delete_food_title;
            parent = $(input).parent().parent();
        }else {
            delete_title = delete_category_title;
            parent = $(input).parent().parent().parent();
        }
        swal.fire({
            title: delete_title,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: cancel,
            confirmButtonText: yes
        }).then((result) => {
            if (result.value) {
                if(type == 'category')
                {
                    parent.next().remove();
                    if(parent.attr('class') == 'old')
                    {
                        var ids = $(input).next().val().trimChars(',').split(',');
                        $('#menu').children().each(function(){
                            $(this).children().each(function(){
                                if(ids.includes($(this).attr('id')))
                                {
                                    $(this).remove();
                                }
                            })
                        })
                    }
                }
                parent.remove();
                if(id != null)
                {
                    $.ajax({
                        method: "DELETE",
                        url: delete_url,
                        data: {
                            "id":id,
                            "type": type
                        },
                        success: function (response) {
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    });
                }
            }
        });
    }

    function sortDiv()
    {
        var old_category_id;
        var old_type;
        var count;
        $("#menu").sortable({
            cancel: ".category,:input",
            items: ".row",
            start: function( event, ui ) {
                old_category_id = ui.item.parent().attr('id');
                old_type = ui.item.parent().attr('class');
            },
            stop: function( event, ui ) {
                let item = ui.item;
                let parent = item.parent();
                let category_id = parent.attr('id');
                if(old_category_id != category_id)
                {
                    item.find('#move').val('true');
                }
                if(category_id == item.find('#move').attr('data-id'))
                {
                    item.find('#move').val('false');
                }
            }
        });
    }

    $.validator.addMethod("nRequired", $.validator.methods.required, name_required_message);

    $.validator.addMethod("cRequired", $.validator.methods.required, category_required_message);

    $.validator.addMethod("nMax", function(value, element) {
        return value.length <= 200;
    }, max_length_message);

    $.validator.addMethod("pMax", function(value, element) {
        return value.length <= 10;
    }, price_max_length_message);

    $.validator.addMethod("pRequired", $.validator.methods.required, price_required_message);

    $.validator.addMethod("pDigit", $.validator.methods.digits, is_positive_integer_message);

    $.validator.addMethod("unique", function(value, element) {
        var timeRepeated = 0;
        if (value != '') {
            $('.category_name').each(function () {
                if ($(this).val() === value) {
                    timeRepeated++;
                }
            });
        }
        return timeRepeated === 1 || timeRepeated === 0;
    }, is_unique_message);

    function formValidate()
    {

        $.validator.addClassRules({
            food_name: {
                nRequired: true,
                nMax: true
            },
            price: {
                pRequired: true,
                pDigit: true,
                pMax: true
            },
            category_name:{
                cRequired: true,
                nMax: true,
                unique: true
            }
        });
        $("#menu_form").validate({
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    $(validator.errorList[0].element).focus();
                }
            },
            highlight: function(element) {
                $(element).parent().addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).parent().removeClass('has-error');
            }

        });
        if($("#menu_form").valid())
        {
            subm();
        }
    }

    $(document).ready(function(){
        sortDiv();
        $('#menu_form').submit(function(e){
            e.preventDefault();
            formValidate()
        })
    })


</script>
