$(document).ready(function() {
    $.ajax({
      url: APP_URL+'/districts/3515',
      type: "GET",
      data : {"_token":"{{ csrf_token() }}"},
      dataType: "json",
      success:function(data)
      {
        if(data){
            $('#district').empty();
            $('#district').append('<option hidden>Pilih Kecamatan</option>'); 
            $.each(data, function(key, district){
                $('select[name="district"]').append('<option value="'+ district.id +'">' + district.name+ '</option>');
            });
          }else{
              $('#district').empty();
          }
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
        $('#desa').empty();
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