/**
 * Created by Admin on 21.09.2017..
 */

var fotoSelected = false;
var formDisabled = true;
jQuery( document ).ready( function () {
    

    var cameraPictureSrc = jQuery( '#camera' ).attr( 'src' );

    jQuery( '.wpcf7-submit' ).attr( 'title', 'Jāizvēlas foto vai piktogramma' );

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
    jQuery( "input[name='your-city']" ).on({
        keyup: function () {
            var val = 'Cits variants: ' + jQuery(this).val(); console.log(val)
            jQuery( '#city-radio-input .wpcf7-list-item.last input' ).attr( "value", val );
        },
        focusout: function(e){
            var val = 'Cits variants: ' + jQuery(this).val(); console.log(val)
            jQuery( '#city-radio-input .wpcf7-list-item.last input' ).attr( "value", val );
        }
    });


    //Ūga, cits variants
    jQuery("input[name='your-day']" ).on({
        keyup: function () {
            var val = 'Cits variants: ' + jQuery(this).val(); console.log(val)
            jQuery( '#selected-day .wpcf7-list-item.last input' ).attr( "value", val );
        },
        focusout: function(e){
            var val = 'Cits variants: ' + jQuery(this).val(); console.log(val)
            jQuery( '#selected-day .wpcf7-list-item.last input' ).attr( "value", val );
        }
    });

    //Pieteikties jaunumiem
    jQuery( "input[name='subscribe-email']" ).on({
        keyup: function () {
            var val = 'Vēlos saņemt stāstus, sajūtas un īpašas iespējas un piedāvājumus savā epastā. Epasts: ' + jQuery(this).val();console.log(val)
            jQuery( '#subscribe-radio-input .wpcf7-list-item.first input' ).attr( "value", val );
        },
        focusout: function(e){
            var val = 'Vēlos saņemt stāstus, sajūtas un īpašas iespējas un piedāvājumus savā epastā. Epasts: ' + jQuery(this).val();console.log(val)
            jQuery( '#subscribe-radio-input .wpcf7-list-item.first input' ).attr( "value", val );
        }
    });

    //Dzīvesvieta, cits variants
    // jQuery("input[name='your-city']").keyup(function(){
    //     var val = 'Cits variants: ' + jQuery(this).val(); console.log(val)
    //     jQuery( '#city-radio-input .wpcf7-list-item.last input' ).attr( "value", val );
    // });


    //Ūga, cits variants
    // jQuery("input[name='your-day']").keyup(function(){
    //     var val = 'Cits variants: ' + jQuery(this).val(); console.log(val)
    //     jQuery( '#selected-day .wpcf7-list-item.last input' ).attr( "value", val );
    // });

    //Pieteikties jaunumiem
    // jQuery("input[name='subscribe-email']").keyup(function(){
    //     var val = 'Vēlos saņemt stāstus, sajūtas un īpašas iespējas un piedāvājumus savā epastā. Epasts: ' + jQuery(this).val();console.log(val)
    //     jQuery( '#subscribe-radio-input .wpcf7-list-item.first input' ).attr( "value", val );
    // });



    var wpcf7Elm = document.querySelector( '.wpcf7' );
    if( wpcf7Elm ){
        wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ) {
            clearImage( cameraPictureSrc );
            fotoSelected = false;
            formDisabled = true;
        }, false );
    }



    jQuery( '#accept-terms input' ).change( function () {
        formDisabled = !formDisabled;
        jQuery( '.wpcf7-submit' ).prop( 'disabled', formDisabled || !fotoSelected )
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
            fotoSelected = true;
            jQuery( '.wpcf7-submit' ).prop( 'disabled', formDisabled || !fotoSelected )
            jQuery( '.wpcf7-submit' ).attr( 'title', '' );
        }

        reader.readAsDataURL(input.files[0]);
    }else{

        jQuery('#camera').attr('src', input.src);
        jQuery('#camera').addClass( 'full-width' );
        
        jQuery('.photo-upload').attr('value', "" );
        fotoSelected = true;
        jQuery( '.wpcf7-submit' ).prop( 'disabled', formDisabled || !fotoSelected )
        jQuery( '.wpcf7-submit' ).attr( 'title', '' );

    }
}

function clearImage( camera ) {
    jQuery('#camera').removeClass( 'full-width' );
    jQuery('#camera').attr('src', camera );
    jQuery('.photo-upload').attr('value', "" );
    jQuery(".selected-pictogram").val( "" );
    fotoSelected = false;
    jQuery( '.wpcf7-submit' ).prop( 'disabled', formDisabled || !fotoSelected )
    jQuery( '.wpcf7-submit' ).attr( 'title', 'Jāizvēlas foto vai piktogramma' );
}

