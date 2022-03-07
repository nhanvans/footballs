<style>
    #os{
        position: relative;
        height: 400px;
        margin: 0px;
        width: 100%;
    }
    #map {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: #f2efe9;
        border: 1px solid #b7b2b2;
        border-radius: 2px;
    }
    .leaflet-container {
        cursor: auto !important;
    }
</style>

<div class="row">
    <div id="os">
        <div id="map">

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" name="address" class="form-control" id="address">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="country">Quốc gia</label>
{{--                country-data-default-value=""--}}
            <select name="country" id="country" class="form-control gds-cr select2" style="width: 100%"
                    country-data-region-id="gds-cr-one" country-data-default-value="" data-language="en" ></select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="city">Tỉnh/Thành phố</label>
{{--                region-data-default-value=""--}}
            <select name="city" id="gds-cr-one" region-data-default-value="" class="form-control select2" style="width: 100%"
                    ></select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="postcode">Mã bưu điện</label>
            <input type="text" name="postcode" class="form-control" id="postcode">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="longitude">Kinh độ</label>
            <input type="text" name="longitude" class="form-control" id="longitude">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="latitude">Vĩ độ</label>
            <input type="text" name="latitude" class="form-control" id="latitude">
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary" style="width: 100%">Tiếp tục</button>
    </div>
</div>

<script type="text/javascript" src="{{asset('assets/plugins/country/assets/js/geodatasource-cr.js')}}"></script>
<script !src="">
    $(function () {
        $('#location_form').submit(function (event) {
            event.preventDefault();
            let url = $(this).attr('action');
            let form_data = new FormData($(this)[0]);
            $.ajax({
                url: url,
                method: 'POST',
                data: form_data,
                processData: false,
                contentType: false,
                beforeSend: (res) => {
                    Swal.fire({
                        title: loading_message,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function (res) {
                    if (res.status == 200) {
                        if ($('#check_edit').val() == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: save_sucess,
                            })
                            $('#edit_tabs').find('.active').children().click();
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
                error: function (err) {
                    console.log(err);
                    Swal.close();
                }
            })
        })

        // map setting
        // var mymap = L.map('admin-map-provider').setView([16.0669077,108.2137987], 19);
        // var mymap = L.map('admin-map-provider',{zoom: 20, center: L.latLng([16.0669077,108.2137987])});
        // var marker = L.marker([16.0669077,108.2137987]).addTo(mymap);
        const myIcon = L.icon({
            iconUrl: '{{ asset("assets/dist/img/iconmap.png") }}',
            iconSize: [38, 38],
            iconAnchor: [22, 40],
            popupAnchor: [-3, -76],
            shadowUrl: '{{ asset("assets/dist/img/iconmap.png") }}',
            shadowSize: [38, 38],
            shadowAnchor: [22, 40]
        });

        var tileLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',
            {
                attribution: false
            });

        const longitude = $("#longitude").val() || 108.22700500488283;
        const latitude = $("#latitude").val() || 16.072537386536663;

        var mymap = L.map('map',
            {
                zoomControl: true,
                layers: [tileLayer]
                // maxZoom: 18,
                // minZoom: 6
            })
            .setView([latitude, longitude], 50);

        setTimeout(function () {
            mymap.invalidateSize()
        }, 800);

        var marker = L.marker([latitude, longitude], {
            draggable: true,
            autoPan: true,
            icon: myIcon,
            title: "MyPoint"
        }).addTo(mymap);

        marker.on("dragend", function (e) {
            const changedPos = e.target.getLatLng();
            $('#longitude').val(changedPos.lng);
            $('#latitude').val(changedPos.lat);
        });

        mymap.addEventListener("click", function (e) {
            const changedPos = e.latlng;
            let latlng = L.latLng(changedPos.lat, changedPos.lng);
            marker.setLatLng(latlng);
            $('#longitude').val(changedPos.lng);
            $('#latitude').val(changedPos.lat);
        });

        $(".longitude, .latitude").on('change', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let lon = $("#longitude").val();
            let lat = $("#latitude").val();
            let latlng = L.latLng(lat, lon);
            marker.setLatLng(latlng);
        });
    })

</script>
