/**
 * Created by Admin on 21.09.2017..
 */


jQuery( document ).ready( function () {

    jQuery( document ).on( 'click', '#camera', function (e) {
        console.log( 'click');
        jQuery( '.photo-upload' ).trigger( 'click' );
    });

    jQuery(".photo-upload").change(function(){
        readURL(this);
    });
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#camera').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

