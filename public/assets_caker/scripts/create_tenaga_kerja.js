let marker;
let lat = document.getElementById('latitude').value;
let long = document.getElementById('longitude').value;
var tileLayer = new L.TileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',{
attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
});
var map = new L.Map('map', {
    'center': [lat,long],
    'zoom': 12,
    'layers': [tileLayer]
});
marker = L.marker([lat,long],{
    draggable: true
}).addTo(map);
$(document).ready(function() {
    $('#province').on('change', function() {
        var provinceId = $(this).val();
        if(provinceId) {
            $.ajax({
                url: APP_URL+'/city/'+provinceId,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                     $('#city').empty();
                     $('#city').append('<option hidden>Pilih Kabupaten/Kota</option>');
                     $('#district').empty();
                     $('#district').append('<option hidden>Pilih Kecamatan</option>'); 
                     $('#subdistrict').empty();
                     $('#subdistrict').append('<option hidden>Pilih Desa</option>');  
                     $.each(data, function(key, city){
                         $('select[name="city"]').append('<option value="'+ city.id +'">' + city.name+ '</option>');
                     });
                 }else{
                     $('#city').empty();
                 }
              }
            });
        }else{
          $('#city').empty();
        }
    });

    $('#city').on('change', function() {
        var cityId = $(this).val();
        if(cityId) {
            $.ajax({
                url: APP_URL+'/districts/'+cityId,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                     $('#district').empty();
                     $('#district').append('<option hidden>Pilih Kecamatan</option>'); 
                     $('#subdistrict').empty();
                     $('#subdistrict').append('<option hidden>Pilih Desa</option>'); 
                     $.each(data, function(key, district){
                         $('select[name="district"]').append('<option value="'+ district.id +'">' + district.name+ '</option>');
                     });
                 }else{
                     $('#district').empty();
                 }
              }
            });
        }else{
          $('#district').empty();
        }
    });

    $('#district').on('change', function() {
        var districtsId = $(this).val();
        if(districtsId) {
            $.ajax({
                url: APP_URL+'/sub-districts/'+districtsId,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                     $('#subdistrict').empty();
                     $('#subdistrict').append('<option hidden>Pilih Desa</option>'); 
                     $.each(data, function(key, sub_district){
                         $('select[name="subdistrict"]').append('<option value="'+ sub_district.id +'">' + sub_district.name+ '</option>');
                     });
                 }else{
                     $('#subdistrict').empty();
                 }
              }
            });
        }else{
          $('#subdistrict').empty();
        }
    });

    $('#company').select2({
        theme: "bootstrap-5",
        // minimumInputLength: 2,
        maximumSelectionLength: 2,
        allowClear: true,
        tags: true,
        placeholder: 'Pilih Perusahaan',
        ajax: {
            url: APP_URL+'/company',
            dataType: 'json',
            delay: 800,
            data: function(params) {
              return {
                search: params.term
              }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.name
                        }
                    })
                };
            },
        }
    });
    $('#company').on('change', function() {
        var companyId = $(this).val();
        if(companyId) {
            $.ajax({
                url: APP_URL+'/company/'+companyId,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                    if (!$.trim(data)){   
                        var address = `<div class="row">
                        <div class="col">
                          <h2 class="input-group-title">Alamat Perusahaan</h2>
                          <hr>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-md-12 mb-3">
                          <label for="company_province" class="form-label">Provinsi</label>
                          <select name="company_province" id="company_province" class="form-select">
                            <option value="">Pilih Provinsi</option>
                          </select>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-3">
                          <label for="company_city" class="form-label">Kabupaten/Kota</label>
                          <select name="company_city" id="company_city" class="form-select">
                            <option value="">Pilih Kota/Kabupaten</option>
                          </select>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-3">
                          <label for="company_district" class="form-label">Kecamatan</label>
                          <select name="company_district" id="company_district" class="form-select">
                            <option value="">Pilih Kecamatan</option>
                          </select>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-3">
                          <label for="company_subdistrict" class="form-label">Desa</label> 
                          <select name="company_subdistrict" id="company_subdistrict" class="form-select">
                            <option value="">Pilih Desa</option>
                          </select>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-3">
                          <label for="company_address" class="form-label">Alamat</label>
                          <textarea class="form-control" id="company_address" name="company_address" rows="3"></textarea>
                        </div>
                      </div>`;
                      $('#address_company').append(address);
                      $.ajax({
                        url: APP_URL+'/province',
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data)
                        {
                          if(data){
                              $('#company_province').empty();
                              $('#company_province').append('<option hidden>Pilih Provinsi</option>'); 
                              $.each(data, function(key, province){
                                  $('select[name="company_province"]').append('<option value="'+ province.id +'">' + province.name+ '</option>');
                              });
                          }else{
                              $('#company_province').empty();
                          }
                        }
                      });
                      $('#company_province').on('change', async function() {
                        var provinceId = $(this).val();
                        if(provinceId) {
                            await $.ajax({
                                url: APP_URL+'/city/'+provinceId,
                                type: "GET",
                                data : {"_token":"{{ csrf_token() }}"},
                                dataType: "json",
                                success:function(data)
                                {
                                  if(data){
                                     $('#company_city').empty();
                                     $('#company_city').append('<option hidden>Pilih Kabupaten/Kota</option>');
                                     $('#company_district').empty();
                                     $('#company_district').append('<option hidden>Pilih Kecamatan</option>'); 
                                     $('#company_subdistrict').empty();
                                     $('#company_subdistrict').append('<option hidden>Pilih Desa</option>');  
                                     $.each(data, function(key, city){
                                         $('select[name="company_city"]').append('<option value="'+ city.id +'">' + city.name+ '</option>');
                                     });
                                 }else{
                                     $('#company_city').empty();
                                 }
                              }
                            });
                        }else{
                          $('#company_city').empty();
                        }
                      });
                      $('#company_city').on('change', function() {
                        var cityId = $(this).val();
                        if(cityId) {
                            $.ajax({
                                url: APP_URL+'/districts/'+cityId,
                                type: "GET",
                                data : {"_token":"{{ csrf_token() }}"},
                                dataType: "json",
                                success:function(data)
                                {
                                  if(data){
                                     $('#company_district').empty();
                                     $('#company_district').append('<option hidden>Pilih Kecamatan</option>'); 
                                     $('#company_subdistrict').empty();
                                     $('#company_subdistrict').append('<option hidden>Pilih Desa</option>'); 
                                     $.each(data, function(key, district){
                                         $('select[name="company_district"]').append('<option value="'+ district.id +'">' + district.name+ '</option>');
                                     });
                                 }else{
                                     $('#company_district').empty();
                                 }
                              }
                            });
                        }else{
                          $('#company_district').empty();
                        }
                    });
                    $('#company_district').on('change', function() {
                        var districtsId = $(this).val();
                        if(districtsId) {
                            $.ajax({
                                url: APP_URL+'/sub-districts/'+districtsId,
                                type: "GET",
                                data : {"_token":"{{ csrf_token() }}"},
                                dataType: "json",
                                success:function(data)
                                {
                                  if(data){
                                     $('#company_subdistrict').empty();
                                     $('#company_subdistrict').append('<option hidden>Pilih Desa</option>'); 
                                     $.each(data, function(key, sub_district){
                                         $('select[name="company_subdistrict"]').append('<option value="'+ sub_district.id +'">' + sub_district.name+ '</option>');
                                     });
                                 }else{
                                     $('#company_subdistrict').empty();
                                 }
                              }
                            });
                        }else{
                          $('#company_subdistrict').empty();
                        }
                      });
                    }
                    else{
                        // document.getElementById('subdistrict').value = data110101
                        console.log("What follows is not blank: " + data[0].name);
                        $('#company_province').val('15');
                        $('#company_province').trigger('change');
                        $('#company_city').val('1508');
                    }
              }
            });
        }
    });

    $('#subdistrict').on('change', function() {
        var subdistrict = document.getElementById('subdistrict');
        var subdistrict_text = subdistrict.options[subdistrict.selectedIndex].text;
        var district = document.getElementById('district');
        var district_text = district.options[district.selectedIndex].text;
        var city = document.getElementById('city');
        var city_text = city.options[city.selectedIndex].text;
        console.log(subdistrict_text, district_text, city_text.substring(5));
        $.get("https://nominatim.openstreetmap.org/search?q="+ subdistrict_text +","+ district_text +","+ city_text.substring(5) +"&format=json", function (result) {
            map.removeLayer(marker)
            marker = L.marker([result[0].lat,result[0].lon],{
                draggable: true
            }).addTo(map);
            document.getElementById('latitude').value = result[0].lat;
            document.getElementById('longitude').value = result[0].lon;
            map.setView(new L.LatLng(result[0].lat, result[0].lon), 15);
            marker.on('dragend', function (e) {
                document.getElementById('latitude').value = marker.getLatLng().lat;
                document.getElementById('longitude').value = marker.getLatLng().lng;
            });
        });
    });

    $("#job").select2({
        tags: true,
        theme: "bootstrap-5"
    });
});
function checkNIK() {
  var nik = document.getElementById('nik');

  if (nik.value == "") {
    Swal.fire({
      icon: 'error',
      title: 'Harap isi NIK terlebih dahulu',
      showConfirmButton: false,
      timer: 2000
    })
  } else {
    var no_kk = document.getElementById('no_kk');
    var fullname = document.getElementById('fullname');
    var place_of_birth = document.getElementById('place_of_birth');
    var address = document.getElementById('address');
    var rt = document.getElementById('rt');
    var rw = document.getElementById('rw');
    var gender = document.getElementById('gender');
    var birthdate = document.getElementById('birthdate');
    var province = document.getElementById('province');
    var city = document.getElementById('city');
    var district = document.getElementById('district');
    var subdistrict = document.getElementById('subdistrict');
    let _url = APP_URL+`/citizen/${nik.value}`;

    var response = '';
    $.ajax({ type: "GET",   
      url: _url,   
      async: false,
      success : function(data)
      {
        if (!$.trim(data)){   
          Swal.fire({
            icon: 'warning',
            title: 'Data Penduduk Tidak Ditemukan',
            showConfirmButton: false,
            timer: 1500
          })
          no_kk.value = "";
          fullname.value = "";
          place_of_birth.value = "";
          address.value = "";
          rt.value = "";
          rw.value = "";
          gender.value = "";
          gender.dispatchEvent(new Event('change'));
          birthdate.value = "";
          province.value = "";
          province.dispatchEvent(new Event('change'));
          city.value = "";
          city.dispatchEvent(new Event('change'));
          district.value = "";
          district.dispatchEvent(new Event('change'));
          subdistrict.value = "";
          subdistrict.dispatchEvent(new Event('change'));
        }
        else{   
            Swal.fire({
              icon: 'success',
              title: 'Data Penduduk Ditemukan',
              showConfirmButton: false,
              timer: 2000
            })
            no_kk.value = data.no_KK;
            fullname.value = data.fullname;
            place_of_birth.value = data.place_of_birth;
            address.value = data.address;
            rt.value = data.RT;
            rw.value = data.RW;
            gender.value = data.gender;
            gender.dispatchEvent(new Event('change'));
            birthdate.value = data.birthdate;
            province.value = data.province;
            province.dispatchEvent(new Event('change'));

            setTimeout(function() {
              city.value = data.city;
              city.dispatchEvent(new Event('change'));
            }, 1000);
            
            setTimeout(function() {
              district.value = data.district;
              district.dispatchEvent(new Event('change'));
            }, 2000);

            setTimeout(function() {
              subdistrict.value = data.subdistrict;
              subdistrict.dispatchEvent(new Event('change'));
            }, 3000);
        }   
      }
    });
  }
}
function select2( size ) {
    $( "select" ).each( function () {
        $( this ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( "width" ) ? $( this ).data( "width" ) : $( this ).hasClass( "w-100" ) ? "100%" : "style",
            placeholder: $( this ).data( "placeholder" ),
            allowClear: Boolean( $( this ).data( "allow-clear" ) ),
            closeOnSelect: !$( this ).attr( "multiple" ),
            containerCssClass: size == "small" || size == "large" ? "select2--" + size : "",
            selectionCssClass: size == "small" || size == "large" ? "select2--" + size : "",
            dropdownCssClass: size == "small" || size == "large" ? "select2--" + size : "",
        } );
    });
}
select2()
var buttons = document.querySelectorAll(".select2-size")
buttons.forEach( function( button ) {
    var id = button.id
    button.addEventListener( "click", function( e ) {
        e.preventDefault()
        select2( id )
        document.querySelectorAll(".select2-size").forEach( function( item ) {
            item.classList.remove("active")
        })
        this.classList.add("active")
    })
})
