<?php 

extract($args);

?>
<div id="acf-upgrade-wrap" class="wrap">
	
	<h2><?php _e("Advanced Custom Fields Database Upgrade",'acf'); ?></h2>
	
<?php if( !empty($updates) ): ?>
	
	<p><?php _e('Reading upgrade tasks...', 'acf'); ?></p>
	
	<p class="show-on-ajax"><i class="acf-loading"></i> <?php printf(__('Upgrading data to version %s', 'acf'), $plugin_version); ?></p>
	
	<p class="show-on-complete"><?php _e('Database Upgrade complete', 'acf'); ?>. <a href="<?php echo admin_url('edit.php?post_type=acf-field-group&page=acf-settings-info'); ?>"><?php _e("See what's new",'acf'); ?></a>.</p>

	<style type="text/css">
		
		/* hide show */
		.show-on-ajax,
		.show-on-complete {
			display: none;
		}		
		
	</style>
	
	<script type="text/javascript">
	(function($) {
		
		var upgrader = {
			
			init: function(){
				
				// reference
				var self = this;
				
				
				// allow user to read message for 1 second
				setTimeout(function(){
					
					self.upgrade();
					
				}, 1000);
				
				
				// return
				return this;
			},
			
			upgrade: function(){
				
				// reference
				var self = this;
				
				
				// show message
				$('.show-on-ajax').show();
				
				
				// get results
			    var xhr = $.ajax({
			    	url:		'<?php echo admin_url('admin-ajax.php'); ?>',
					dataType:	'json',
					type:		'post',
					data:		{
						action:		'acf/admin/data_upgrade',
						nonce:		'<?php echo wp_create_nonce('acf_upgrade'); ?>',
					},
					success: function( json ){
						
						// bail early if no success
						if( !json || !json.data ) {
							
							return;
							
						}
						
						
						// message
						if( json.data.message ) {
							
							$('.show-on-ajax').html( json.data.message );
							
						}
						
					},
					complete: function(){
						
						// remove spinner
						$('.acf-loading').hide();
						
						
						// show complete
						$('.show-on-complete').show();
						
					}
				});
				
				
			}
			
		}.init();
				
	})(jQuery);	
	</script>
	
<?php else: ?>

	<p><?php _e('No updates available', 'acf'); ?>.</p>
	
<?php endif; ?>

</div>