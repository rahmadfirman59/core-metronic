$(document).ready(function() {
    $.ajax({
        url: APP_URL+'/province/',
        type: "GET",
        data : {"_token":"{{ csrf_token() }}"},
        dataType: "json",
        success:function(data)
        {
          if(data){
            $('#province').empty();
            $('#province').append('<option hidden>Pilih Provinsi</option>'); 
            $.each(data, function(key, province){
                $('select[name="province"]').append('<option value="'+ province.id +'">' + province.name+ '</option>');
            });
        }else{
            $('#province').empty();
        }
      }
    });
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
                   $.each(data, function(key, subdistrict){
                       $('select[name="subdistrict"]').append('<option value="'+ subdistrict.id +'">' + subdistrict.name+ '</option>');
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
});
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
  } );
}
select2()
var buttons = document.querySelectorAll(".select2-size")
buttons.forEach( function( button ) {
  var id = button.id
  button.addEventListener( "click", function( e ) {
      e.preventDefault()
      select2( id )
      document.querySelectorAll(".select2-size").forEach( function( item ) {
          item.classList.remove( "active" )
      } )
      this.classList.add( "active" )
  } )
} )