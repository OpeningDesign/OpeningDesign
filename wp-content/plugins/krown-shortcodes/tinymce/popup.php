<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new krown_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="krown-popup">

	<div id="krown-shortcode-wrap">
		
		<div id="krown-sc-form-wrap">
		
			<div id="krown-sc-form-head">
			
				<?php echo $shortcode->popup_title; ?>
			
			</div>
			<!-- /#krown-sc-form-head -->
			
			<form method="post" id="krown-sc-form">
			
				<table id="krown-sc-form-table">
				
					<?php echo $shortcode->output; ?>
					
					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary krown-insert">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#krown-sc-form-table -->
				
			</form>
			<!-- /#krown-sc-form -->
		
		</div>
		<!-- /#krown-sc-form-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#krown-shortcode-wrap -->

</div>
<!-- /#krown-popup -->

</body>
</html>