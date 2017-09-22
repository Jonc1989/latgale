<?php /**

* WordPress Settings Page

*/


if(
	(isset($_GET['page']) && $_GET['page']=='easy_ufdc')
	||
	( isset( $_POST['ufdc_fields_submitted'] ) && $_POST['ufdc_fields_submitted'] == 'submitted' )
){
	
function easy_ufdc_page() {

// Check the user capabilities

	global $easy_ufdc_error_default;

	if ( !current_user_can( 'manage_woocommerce' ) ) {

		wp_die( __( 'You do not have sufficient permissions to access this page.','easy-upload-files-during-checkout' ) );

	}

	

// Save the field values

	if ( isset( $_POST['ufdc_fields_submitted'] ) && $_POST['ufdc_fields_submitted'] == 'submitted' ) {

		delete_option('easy_ufdc_use_style');

		$_POST['eufdc_email'] = (isset($_POST['eufdc_email'])?$_POST['eufdc_email']:false);

		$_POST['eufdc_billing_off'] = (isset($_POST['eufdc_billing_off'])?$_POST['eufdc_billing_off']:false);

		$_POST['eufdc_shipping_off'] = (isset($_POST['eufdc_shipping_off'])?$_POST['eufdc_shipping_off']:false);

		$_POST['eufdc_order_comments_off'] = (isset($_POST['eufdc_order_comments_off'])?$_POST['eufdc_order_comments_off']:false);

			

		foreach ( $_POST as $key => $value ) {

			//pre($key.'>'.$value);

			if ( get_option( $key ) != $value ) {

				update_option( $key, $value );

			} else {

				add_option( $key, $value, '', 'no' );

			}

		}

	}
	

global $easy_ufdc_page, $ufdc_custom, $eufdc_data, $ufdc_premium_link;

$easy_ufdc_page = get_option( 'easy_ufdc_page' );

?>



<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>

	<h2>Easy Upload Files During Checkout <?php echo '('.$eufdc_data['Version'].($ufdc_custom?') Pro':')'); ?> - <?php _e('Settings','easy-upload-files-during-checkout'); ?> </h2>

	<?php if ( isset( $_POST['ufdc_fields_submitted'] ) && $_POST['ufdc_fields_submitted'] == 'submitted' ) { ?>

	<div id="message" class="updated fade"><p><strong><?php _e( 'Your settings have been saved.','easy-upload-files-during-checkout'); ?></strong></p></div>

	<?php } ?>

	<div id="content">

		<form method="post" action="" id="ufdc_settings">

			<input type="hidden" name="ufdc_fields_submitted" value="submitted">

			<div id="poststuff">

				<div style="float:left; width:100%;">

					<div class="postbox">

						<div class="inside ufdc-settings">

							<table class="form-table">

                                <tr>

    								<th>

    									<label for="easy_ufdc_caption"><b><?php _e( 'Caption','easy-upload-files-during-checkout'); ?></b>:</label>

    								</th>

    								<td>

                                        <textarea id="easy_ufdc_caption" style="width:50%; height:60px" name="easy_ufdc_caption" placeholder="<?php _e("Do you have something to attach?",'easy-upload-files-during-checkout'); ?>"><?php echo stripslashes(get_option( 'easy_ufdc_caption' )); ?></textarea>

    								</td>

    							</tr>                            

    							<tr>

    								<th>

    									<label for="easy_ufdc_page"><b><?php _e( 'Display on','easy-upload-files-during-checkout');?>:</b></label>

    								</th>

    								<td>

                                        <ul>

                                            <li><input type="radio" name="easy_ufdc_page" id="easy_ufdc_page_cart" value="cart" <?php if($easy_ufdc_page=='cart' || !$easy_ufdc_page) { echo 'checked="checked"'; } ?> />

                                            <label for="easy_ufdc_page_cart">&nbsp;<?php _e("Cart Page",'easy-upload-files-during-checkout'); ?></label>

                                            </li>



                                            <li><input type="radio" name="easy_ufdc_page" id="easy_ufdc_page_checkout" value="checkout" <?php if($easy_ufdc_page=='checkout'){ echo 'checked="checked"'; } ?> />

                                            <label for="easy_ufdc_page_checkout">&nbsp;<?php _e("Checkout Page",'easy-upload-files-during-checkout'); ?></label>

                                             </li>
                                             
    										 <li><input type="radio" name="easy_ufdc_page" id="easy_ufdc_page_checkout_notes" value="checkout_notes" <?php if($easy_ufdc_page=='checkout_notes'){ echo 'checked="checked"'; } ?> />

                                            <label for="easy_ufdc_page_checkout_notes">&nbsp;<?php _e("Checkout Page > After Notes",'easy-upload-files-during-checkout'); ?></label>

                                             </li>                                             

                                        </ul>

    								</td>

    							</tr>

                                <tr>

    								<th>

    									<label for="easy_ufdc_caption"><b><?php _e( 'Error Message','easy-upload-files-during-checkout'); ?>:</b></label>

    								</th>

    								<td>

                                        <textarea id="easy_ufdc_error" style="width:50%; height:60px" name="easy_ufdc_error" placeholder="<?php echo $easy_ufdc_error_default; ?>"><?php echo stripslashes(get_option( 'easy_ufdc_error' )); ?></textarea>

    								</td>

    							</tr> 



                                <tr>

                                    <th>

                                        <label for="easy_ufdc_limit"><b><?php _e( 'Multiple files','easy-upload-files-during-checkout'); ?>:</b></label><br />



                                        <small><?php echo (!$ufdc_custom?'<a style="color:red; font-weight:normal;" href="'.$ufdc_premium_link.'" target="_blank">'. __("Premium Feature",'easy-upload-files-during-checkout') . '</a>':''); ?></small>

                                    </th>

                                    <td>

                                        <input type="text" name="easy_ufdc_limit" class="regular-text" value="<?php if(!get_option( 'easy_ufdc_limit' )) { echo '1'; } else { echo stripslashes(get_option( 'easy_ufdc_limit' )); }?>"/><br />

                                        <span class="description"><?php

                                        echo __( 'Specify number of files allowed to upload (numbers only).','easy-upload-files-during-checkout');

                                        ?></span>

                                    </td>

                                </tr>



								<tr>

    								<th>

    									<label for="easy_ufdc_allowed_file_types"><b><?php _e( 'Allowed file types','easy-upload-files-during-checkout'); ?>:</b></label>

    								</th>

    								<td>
<?php
$mime = array_keys(get_allowed_mime_types());
$allowed_mime = array();
if(!empty($mime)){
	foreach($mime as $types){
		$types = explode('|', $types);
		$allowed_mime = array_merge($allowed_mime, $types);
	}
}

?>
<script type="text/javascript" language="javascript">
var contains = function(needle) {
    // Per spec, the way to identify NaN is that it is not equal to itself
    var findNaN = needle !== needle;
    var indexOf;

    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
        indexOf = Array.prototype.indexOf;
    } else {
        indexOf = function(needle) {
            var i = -1, index = -1;

            for(i = 0; i < this.length; i++) {
                var item = this[i];

                if((findNaN && item !== item) || item === needle) {
                    index = i;
                    break;
                }
            }

            return index;
        };
    }

    return indexOf.call(this, needle) > -1;
};
var allowed_mime = [];
<?php 
	if(!empty($allowed_mime)){
		foreach($allowed_mime as $i=>$mime){
?>
allowed_mime[<?php echo $i; ?>] = '<?php echo $mime; ?>';
<?php			
		}
	}
	
?>	
jQuery(document).ready(function($){
	$('input[name="easy_ufdc_allowed_file_types"]').on('blur', function(){
		var str = $.trim($(this).val());
		//alert(str);
		if(str!=''){
			
			var chars = str.split(',');
			var all_good = true;
			$.each(chars, function(i, v){
				
				if(all_good){
					all_good = contains.call(allowed_mime, v);					
				}
				
			});
			//alert(all_good);
			if(all_good)
			$('#ufdc_settings pre').fadeOut();
			else
			$('#ufdc_settings pre').fadeIn();
		}
	});
	
	$('input[name="easy_ufdc_allowed_file_types"]').trigger('blur');
});

</script>
    									<input type="text" name="easy_ufdc_allowed_file_types" class="regular-text" value="<?php if(!get_option( 'easy_ufdc_allowed_file_types' )) { echo 'doc,txt'; } else { echo stripslashes(get_option( 'easy_ufdc_allowed_file_types' )); }?>"/><br />



    									<span class="description"><?php

    										echo __( 'Specify which file types are allowed for uploading, seperate by commas.','easy-upload-files-during-checkout');

    									?></span>
                                        
                                        <pre>Add the following line in your wp-config.php <br /><br /><strong>define( 'ALLOW_UNFILTERED_UPLOADS', true );</strong><br /><br />if you are allowing some files which are not<br />supported by <a href="https://codex.wordpress.org/Uploading_Files" target="_blank">WordPress by default</a>.<br /></pre>

    								</td>

    							</tr>



                                <tr>

    								<th>

    									<label for="easy_ufdc_req"><b><?php _e( 'Make upload field required?','easy-upload-files-during-checkout'); ?></b></label>

    								</th>



    								<td>

                                        <input type="radio" name="easy_ufdc_req"  value="1" <?php if(get_option( 'easy_ufdc_req' ) && get_option( 'easy_ufdc_req' )==1) { echo 'checked="checked"'; } ?> />



                                        <label><?php _e("Yes",'easy-upload-files-during-checkout');?></label>

                                        <br />

                                        <input type="radio" name="easy_ufdc_req" value="0" <?php if(!get_option( 'easy_ufdc_req' ) || get_option( 'easy_ufdc_req' )!=1) { echo 'checked="checked"'; } ?> />



                                        <label><?php _e("No",'easy-upload-files-during-checkout');?></label>



                                        <br />

       									<span class="description">&nbsp;</span>

    								</td>

    							</tr>



								<tr>

    								<th>

    									<label for="easy_ufdc_max_uploadsize"><b><?php _e( 'Maximum upload size','easy-upload-files-during-checkout'); ?>:</b></label>

    								</th>

    								<td>

    									<input type="text" name="easy_ufdc_max_uploadsize" class="short" value="<?php if(!get_option( 'easy_ufdc_max_uploadsize' )) { echo ini_get('upload_max_filesize'); } else { echo stripslashes(get_option( 'easy_ufdc_max_uploadsize' )); }?>"/><br />



    									<span class="description"><?php

    										echo __( 'Specify maximum upload size for all files in MegaBytes. Cannot exceed max PHP upload size.','easy-upload-files-during-checkout').'<br>';

											echo __( 'Note: recommended max upload size below 8MB.','easy-upload-files-during-checkout');

    									?></span>

    								</td>

    							</tr>



                            <?php if($ufdc_custom): ?>                                

                                <tr>

                            		<th>

                                		<label for="woocommerce_ufdc_max_wh"><b><?php _e( 'Dimensions Check','easy-upload-files-during-checkout'); ?>:</b><br />

                                            <small>*<?php _e("For Images Only",'easy-upload-files-during-checkout');?></small>

                                        </label>

                            		</th>

                            		<td>

                            			<span class="min_max"><?php _e("Min Width",'easy-upload-files-during-checkout');?>:</span> <input type="text" name="woocommerce_ufdc_min_w" class="short min_max" value="<?php if(!get_option( 'woocommerce_ufdc_min_w' )) { echo ''; } else { echo stripslashes(get_option( 'woocommerce_ufdc_min_w' )); }?>"/>&nbsp;



                                        <span class="min_max"><?php _e("Max Width",'easy-upload-files-during-checkout');?>:</span> <input type="text" name="woocommerce_ufdc_max_w" class="short min_max" value="<?php if(!get_option( 'woocommerce_ufdc_max_w' )) { echo ''; } else { echo stripslashes(get_option( 'woocommerce_ufdc_max_w' )); }?>"/><br />



                                        <span class="min_max"><?php _e("Min Height",'easy-upload-files-during-checkout');?>:</span> <input type="text" name="woocommerce_ufdc_min_h" class="short min_max" value="<?php if(!get_option( 'woocommerce_ufdc_min_h' )) { echo ''; } else { echo stripslashes(get_option( 'woocommerce_ufdc_min_h' )); }?>"/>&nbsp;



                                        <span class="min_max"><?php _e("Max Height",'easy-upload-files-during-checkout');?>:</span> <input type="text" name="woocommerce_ufdc_max_h" class="short min_max" value="<?php if(!get_option( 'woocommerce_ufdc_max_h' )) { echo ''; } else { echo stripslashes(get_option( 'woocommerce_ufdc_max_h' )); }?>"/><br />

                             

                                        <span class="description"><?php

                                        echo __( 'Leave empty for no restrictions.','easy-upload-files-during-checkout');

                                        ?></span>                                       

                                	</td>

                                </tr>														

                            <?php endif; ?>                                                                

								<tr>

									<td colspan="2" style="padding:0">

										<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes','easy-upload-files-during-checkout'); ?>" /></p>

									</td>

								</tr>

							</table>

                            <div class="optional">

                            <h3><?php _e("Optional",'easy-upload-files-during-checkout'); ?></h3>

                            	<fieldset>

                                	<ul>

                                    <li>

                                	<input id="eufdc_email" name="eufdc_email" type="checkbox" value="1" <?php echo(get_option('eufdc_email', 0)?'checked="checked"':''); ?> /><label for="eufdc_email"><?php _e("Send Attachments in Email",'easy-upload-files-during-checkout'); ?></label>

                                    </li>

                                    <li <?php echo(get_option('eufdc_billing_off', 0)?'class="selected"':''); ?>>

                                	<input class="eufdc_checkout_options" id="eufdc_billing_off" name="eufdc_billing_off" type="checkbox" value="1" <?php echo(get_option('eufdc_billing_off', 0)?'checked="checked"':''); ?> /><label for="eufdc_billing_off"><?php _e('Billing Details','easy-upload-files-during-checkout'); ?> <strong><?php _e('On','easy-upload-files-during-checkout'); ?></strong>/<strong><?php _e('Off','easy-upload-files-during-checkout'); ?></strong></label>

                                    </li>

                                    <li <?php echo(get_option('eufdc_shipping_off', 0)?'class="selected"':''); ?>>

                                	<input class="eufdc_checkout_options" id="eufdc_shipping_off" name="eufdc_shipping_off" type="checkbox" value="1" <?php echo(get_option('eufdc_shipping_off', 0)?'checked="checked"':''); ?> /><label for="eufdc_shipping_off"><?php _e('Shipping Details','easy-upload-files-during-checkout'); ?> <strong><?php _e('On','easy-upload-files-during-checkout'); ?></strong>/<strong><?php _e('Off','easy-upload-files-during-checkout'); ?></strong></label>

                                    </li>

                                    <li <?php echo(get_option('eufdc_order_comments_off', 0)?'class="selected"':''); ?>>

                                	<input class="eufdc_checkout_options" id="eufdc_order_comments_off" name="eufdc_order_comments_off" type="checkbox" value="1" <?php echo(get_option('eufdc_order_comments_off', 0)?'checked="checked"':''); ?> /><label for="eufdc_order_comments_off"><?php _e("Order Comments",'easy-upload-files-during-checkout'); ?> <strong><?php _e('On','easy-upload-files-during-checkout'); ?></strong>/<strong><?php _e('Off','easy-upload-files-during-checkout'); ?></strong></label>

                                    </li>

                                                                  

                                    </ul>

                                </fieldset>

                            </div>

						</div>

					</div>

				</div>

			</div>

		</form>

	</div>

</div>

<?php }
}