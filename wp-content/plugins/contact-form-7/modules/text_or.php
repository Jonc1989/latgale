<?php
/**
 ** A base module for [text*], and [email*]
 **/

/* Validation filter for either or fields
	use or_field:tag
	use or_label:field label

*/

add_filter( 'wpcf7_validate_text*', 'wpcf7_textor_validation_filter', 20, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_textor_validation_filter', 20, 2 );

function wpcf7_textor_validation_filter( $result, $tag ) {
	$type = $tag['type'];
	$name = $tag['name'];
	$options = (array) $tag['options'];

	foreach ( $options as $option ) {

		if ( preg_match( '%^or_field:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
			$match = $matches[1];
			$match = trim((string)$match);
		}

		if ( preg_match( '%^or_label:([-0-9a-zA-Z_]+)$%', $option, $matches ) ) {
			$lmatch = $matches[1];
			$lmatch = trim((string)$lmatch);
			$lmatch = str_replace('_', ' ',$lmatch);
		}

	}

	$_POST[$match] = trim( strtr( (string) $_POST[$match], "\n", " " ) );
	$_POST[$name] = trim( strtr( (string) $_POST[$name], "\n", " " ) );

	$custom_response = 'This field or the '. $lmatch .'  field are required';

	if ( 'text*' == $type ) {
		if ( '' == $_POST[$name] && '' == $_POST[$match] && $match) {
			$result['valid'] = false;

			$result['reason'][$name] = $custom_response;
		} elseif ($match) {

			$result['valid'] = true;

		}
	}

	if ( 'email*' == $type ) {

		if ( '' == $_POST[$name] &&  '' == $_POST[$match] && $match) {
			$result['valid'] = false;
			$result['reason'][$name] = $custom_response;
		} elseif ( '' != $_POST[$name] && ! is_email( $_POST[$name] && $match) ) {
			$result['valid'] = false;
			$result['reason'][$name] = wpcf7_get_message( 'invalid_email' );
		} elseif($match) {

			$result['valid'] = true;

		}
	}

	return $result;

}

/* Tag generator */

add_action( 'admin_init', 'wpcf7_add_tag_generator_textor_and_emailor', 1 );

function wpcf7_add_tag_generator_textor_and_emailor() {
	wpcf7_add_tag_generator( 'text', __( 'Text field', 'wpcf7' ),
		'wpcf7-tg-pane-text', 'wpcf7_tg_pane_textor' );

	wpcf7_add_tag_generator( 'email', __( 'Email field', 'wpcf7' ),
		'wpcf7-tg-pane-email', 'wpcf7_tg_pane_emailor' );
}

function wpcf7_tg_pane_textor( &$contact_form ) {
	wpcf7_tg_pane_textor_and_emailor( 'text' );
}

function wpcf7_tg_pane_emailor( &$contact_form ) {
	wpcf7_tg_pane_textor_and_emailor( 'email' );
}

function wpcf7_tg_pane_textor_and_emailor( $type = 'text' ) {
	if ( 'email' != $type )
		$type = 'text';

	?>
	<div id="wpcf7-tg-pane-<?php echo $type; ?>" class="hidden">
		<form action="">
			<table>
				<tr><td><input type="checkbox" name="required" />&nbsp;<?php echo esc_html( __( 'Required field?', 'wpcf7' ) ); ?></td></tr>
				<tr><td><?php echo esc_html( __( 'Name', 'wpcf7' ) ); ?><br /><input type="text" name="name" class="tg-name oneline" /></td><td></td></tr>
			</table>

			<table>
				<tr>
					<td><code>id</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
						<input type="text" name="id" class="idvalue oneline option" /></td>

					<td><code>class</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
						<input type="text" name="class" class="classvalue oneline option" /></td>
				</tr>

				<tr>
					<td><code>size</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
						<input type="text" name="size" class="numeric oneline option" /></td>

					<td><code>maxlength</code> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
						<input type="text" name="maxlength" class="numeric oneline option" /></td>
				</tr>

				<tr>
					<td><code>or_field</code> <br />(<?php echo esc_html( __( 'match field tag name', 'wpcf7' ) ); ?>)<br />
						<input type="text" name="or_field" class="or_field oneline option" /></td>

					<td><code>or_label</code> <br />(<?php echo esc_html( __( 'match field pretty name (use _ for spaces', 'wpcf7' ) ); ?>)<br />
						<input type="text" name="or_label" class="or_label oneline option" /></td>
				</tr>

				<tr>
					<td colspan="2"><p> The fields above are useful only when the field you are adding is a required field.  These will make the current field and another field an either/or field. (ie.  <strong>email</strong> or <strong>phone number</strong> are required.  <br /> The format is <strong>[email* or_field:phone or_label:Phone_Number]</strong>  if phone is the other field tag name. </p></td>
				</tr>

				<tr>
					<td colspan="2"><?php echo esc_html( __( 'Akismet', 'wpcf7' ) ); ?> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br />
						<?php if ( 'text' == $type ) : ?>
							<input type="checkbox" name="akismet:author" class="exclusive option" />&nbsp;<?php echo esc_html( __( "This field requires author's name", 'wpcf7' ) ); ?><br />
							<input type="checkbox" name="akismet:author_url" class="exclusive option" />&nbsp;<?php echo esc_html( __( "This field requires author's URL", 'wpcf7' ) ); ?>
						<?php else : ?>
							<input type="checkbox" name="akismet:author_email" class="option" />&nbsp;<?php echo esc_html( __( "This field requires author's email address", 'wpcf7' ) ); ?>
						<?php endif; ?>
					</td>
				</tr>

				<tr>
					<td><?php echo esc_html( __( 'Default value', 'wpcf7' ) ); ?> (<?php echo esc_html( __( 'optional', 'wpcf7' ) ); ?>)<br /><input type="text" name="values" class="oneline" /></td>

					<td>
						<br /><input type="checkbox" name="watermark" class="option" />&nbsp;<?php echo esc_html( __( 'Use this text as watermark?', 'wpcf7' ) ); ?>
					</td>
				</tr>
			</table>

			<div class="tg-tag"><?php echo esc_html( __( "Copy this code and paste it into the form left.", 'wpcf7' ) ); ?><br /><input type="text" name="<?php echo $type; ?>" class="tag" readonly="readonly" onfocus="this.select()" /></div>

			<div class="tg-mail-tag"><?php echo esc_html( __( "And, put this code into the Mail fields below.", 'wpcf7' ) ); ?><br /><span class="arrow">⬇</span>&nbsp;<input type="text" class="mail-tag" readonly="readonly" onfocus="this.select()" /></div>
		</form>
	</div>
	<?php
}

?>