<?php
/**
 * Comments template
 */
?>

<?php if ( post_password_required() ) : ?>
				<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'krown' ); ?></p>
<?php
		return;
	endif;
?>

	<aside id="comments">

		<div class="comments-wrapper">
	
		<?php if ( have_comments() ) : ?>
		
			<h5 id="comments-title"><?php comments_number( __( 'Comments (0)', 'krown' ), __( 'Comments (1)', 'krown' ), __( 'Comments (%)', 'krown' ) ); ?></h5>

		<?php else : 
			if ( ! comments_open() ) {
				_e('Comments are closed.', 'krown');
			} else {
				?>
				<h5 id="comments-title"><?php comments_number( __( 'Comments (0)', 'krown' ), __( 'Comments (1)', 'krown' ), __( 'Comments (%)', 'krown' ) ); ?></h5>
			<?php }
		?>

		<?php endif; // end have_comments() ?>

			<?php if ( !have_comments() ) : ?>

				<p style="margin:35px 0"><?php _e('There are not comments on this post yet. Be the first one!', 'krown'); ?></p>

			<?php endif; ?>

				<ol id="comments-list"><?php wp_list_comments( array( 'callback' => 'krown_comment' ) ); ?></ol>

			</div>

			<?php paginate_comments_links(); ?>

			<div class="comments-wrapper krown-column-row clearfix">

			<?php 
			
			 $defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
				'author' => '<div class="krown-column-container span4 first"><label for="autor">' . __('Name', 'krown') . '<span> ' . __(' (required)', 'krown') . '</span></label><input id="author" name="author" type="text" value=""/></div>',
				'email'  => '<div class="krown-column-container span4"><label for="email">' . __('Email', 'krown') . '<span> ' . __(' (required)', 'krown') . '</span></label><input id="email" name="email" type="text" value="" /></div>',
				'url'    => '<div class="krown-column-container span4 last"><label for="url">' . __('Website', 'krown') . '<span> ' . __(' (optional)', 'krown') . '</span></label><input id="url" name="url" type="text" value="" /></div>' ) ),
				'comment_field' => '<div class="krown-column-container span12 first last"><label for="comment">' . __('Your Message', 'krown') . '<span> ' . __(' (required)', 'krown') . '</span></label><textarea id="comment" name="comment" rows="8"></textarea></div>',
				'must_log_in' => '<p style="margin-bottom:25px" class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'krown' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
				'logged_in_as' => '<p style="margin-bottom:25px" class="logged-in-as">' . sprintf( __( 'You are logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) , 'krown') . '</p>',
				'comment_notes_before' => '',
				'comment_notes_after' => '',
				'id_form' => 'comment-form',
				'id_submit' => 'submit',
				'title_reply' => __( 'Add Your Comment', 'krown' ),
				'title_reply_to' => __( 'Leave a Reply to %s', 'krown' ),
				'cancel_reply_link' => __( 'Cancel reply', 'krown' ),
				'label_submit' => __( 'Submit Comment', 'krown' ),
			); 
			
			comment_form($defaults); 
			
			?>

		</div>
		
	</aside>

	