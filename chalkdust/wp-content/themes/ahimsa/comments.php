<?php

if ( function_exists('wp_list_comments') ) :

// new comments.php stuff

    // password check
    if (!empty($_SERVER['SCRIPT_FILENAME']) &&
            'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
    if ( post_password_required() )
    {
        print '
            <p class="nocomments">This post is password protected.
            Enter the password to view comments.</p>
            ';
        return;
    }

    if ( have_comments() ) : ?>

        <fieldset id='comments'>

            <legend>
            <?php comments_number('No Responses', 'One Response', '% Responses' );?>
            </legend>

            <!--
                The &nbsp; below is to workaround what seems to be a bug in Safari.
                Without it, the 'comments' container fieldset (above) is overlapped
                by the first comment fieldset.
            -->
            &nbsp;

            <ul>
                <?php wp_list_comments('type=all&style=ul&callback=custom_comment'); ?>
            </ul>

            <br clear='all' />

            <div class="postmetadata">
                <?php
                    previous_comments_link('<span class="capsule actbubble" style="float: left;">' .
                                            '&laquo; previous</span>');
                    next_comments_link('<span class="capsule actbubble" style="float: right;">' .
                                            'next &raquo;</span>');
                ?>
                <br clear='all'/>
            </div>

        </fieldset>

    <?php else : // this is displayed if there are no comments so far ?>

        <?php if ('open' == $post->comment_status) :
            // If comments are open, but there are no comments.

        else : // comments are closed ?>
            <!-- If comments are closed. -->
            <span class='capsule nocomments'>Comments are closed</span>
            <br/>
            <br/>

        <?php endif;

    endif;

else : // old WP < 2.7

    include_once("comments-old.php");

endif; // WP 2.7 check (old vs new style of comments) ?>

<?php if('open' == $post->comment_status) : ?>

    <div id='respond'>

    <fieldset id='responsebox'>

    <legend>Leave a Reply</legend>

    <?php if( get_option('comment_registration') && !$user_ID ) : ?>

        <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
        
    <?php else : ?>

        <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

        <?php if( $user_ID ) : ?>

            <p>
            Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php">
                <?php echo $user_identity; ?></a>.
            <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout"
                title="Log out of this account">Logout &raquo;</a>
            </p>

        <?php else : ?>

            <p>
            <input type="text" name="author" id="author" class='inptext'
                   value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
            <label for="author"><small>Name <?php if($req) echo "(required)"; ?></small></label>
            </p>

            <p>
            <input type="text" name="email" id="email" class='inptext'
                   value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
            <label for="email"><small>Mail (will not be published) <?php if($req) echo "(required)"; ?>
                </small></label></p>

            <p>
            <input type="text" name="url" id="url" class='inptext'
                   value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
            <label for="url"><small>Website</small></label></p>

        <?php endif; ?>

        <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

        <p><textarea name="comment" id="comment" cols="60%" rows="10" tabindex="4"></textarea></p>

        <input name="submit" type="submit" id="submit" class='capsule actbubble'
             tabindex="5" value="Submit Comment" />
            
        <?php
            if ( function_exists('comment_id_fields') ) :

                // WP > 2.7
                comment_id_fields();
            ?>
                <div id="cancel-comment-reply">
	                <small><?php cancel_comment_reply_link() ?></small>
                </div>

            <?php else : ?>

                <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />

        <?php endif; ?>

        <?php do_action('comment_form', $post->ID); ?>

        </form>

    <?php endif; // If registration required and not logged in ?>

    </fieldset>

    </div>

<?php endif; // if you delete this the sky will fall on your head ?>

