/**
 * Created by Admin on 21.09.2017..
 */


jQuery( document ).ready( function () {
    
    var formDisabled = true;
    var cameraPictureSrc = jQuery( '#camera' ).attr( 'src' );


    //Clickable labels
    // jQuery( '.wpcf7-list-item' ).click( function ( e ) {
    //     jQuery( this ).find( 'input' ).trigger( 'click' );
    // });


    jQuery( '.wpcf7-submit' ).prop( 'disabled', formDisabled );

    jQuery( document ).on( 'click', '#camera', function (e) {
        jQuery( '.photo-upload' ).trigger( 'click' );
    });

    jQuery( document ).on( 'click', '.pictogram', function (e) {
        readURL(this);
        jQuery(".selected-pictogram").val(  this.name );
    });

    jQuery( document ).on( 'click', '.left-card-block .close', function () {
        clearImage( cameraPictureSrc );
    } );

    jQuery(".photo-upload").change(function(){
        readURL(this);
    });


    //Dzīvesvieta, cits variants
    jQuery("input[name='your-city']").keyup(function(){
        jQuery( '#city-radio-input .wpcf7-list-item.last input' ).attr( "value", jQuery(this).val() );
    });


    //Ūga, cits variants
    jQuery("input[name='your-day']").keyup(function(){
        jQuery( '#selected-day .wpcf7-list-item.last input' ).attr( "value", jQuery(this).val() );
    });

    //Pieteikties jaunumiem
    jQuery("input[name='subscribe-email']").keyup(function(){
        jQuery( '#subscribe-radio-input .wpcf7-list-item.first input' ).attr( "value", jQuery(this).val() );
    });

    jQuery('.bxslider').bxSlider({
        minSlides: 8,
        maxSlides: 8,
        pager: false,
        slideWidth: 100,
        onSliderLoad: function () {
//            jQuery( '.bx-wrapper' ).show();
        }
    });




    jQuery( '#accept-terms input' ).change( function () {
        formDisabled = !formDisabled;

        jQuery( '.wpcf7-submit' ).prop( 'disabled', formDisabled )
    });



    var modal = document.getElementById('agreement-terms-modal');

    jQuery( document ).on( 'click', '#agreement-terms', function () {
        modal.style.display = "block";
    } )

    jQuery( document ).on( 'click', '#agreement-terms-modal .close', function () {
        modal.style.display = "none";
    } );

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#camera').attr('src', e.target.result);
            jQuery('#camera').addClass( 'full-width' );
            jQuery(".selected-pictogram").val( "" );
        }

        reader.readAsDataURL(input.files[0]);
    }else{

        jQuery('#camera').attr('src', input.src);
        jQuery('#camera').addClass( 'full-width' );
        
        jQuery('.photo-upload').attr('value', "" );

    }
}

function clearImage( camera ) {
    jQuery('#camera').removeClass( 'full-width' );
    jQuery('#camera').attr('src', camera );
    jQuery('.photo-upload').attr('value', "" );
    jQuery(".selected-pictogram").val( "" );
}

