<?php


function bfa_the_loop() {
	
	// The LOOP. Do this for all posts:
	while (have_posts()) : the_post(); $bfa_ata['postcount']++; ?>
	
		<?php // Odd or even post
		$odd_or_even = (($bfa_ata['postcount'] % 2) ? 'odd-post' : 'even-post' ); ?> 

		<?php // Post Container starts here
		if ( function_exists('post_class') ) { ?>
		<div <?php if ( is_page() ) { post_class('post'); } else { post_class("$odd_or_even"); } ?> id="post-<?php the_ID(); ?>">
		<?php } else { ?>
		<div class="<?php echo ( is_page() ? 'page ' : '' ) . $odd_or_even . ' post" id="post-'; the_ID(); ?>">
		<?php } ?>

			<?php bfa_post_kicker('<div class="post-kicker">','</div>'); ?>

			<?php bfa_post_headline('<div class="post-headline">','</div>'); ?>

			<?php bfa_post_byline('<div class="post-byline">','</div>'); ?>

			<?php bfa_post_bodycopy('<div class="post-bodycopy clearfix">','</div>'); ?>

			<?php bfa_post_pagination('<p class="post-pagination"><strong>'.__('Pages:','atahualpa').'</strong>','</p>'); ?>

			<?php bfa_post_footer('<div class="post-footer">','</div>'); ?>

		</div><!-- / Post -->

	<?php // END of the LOOP
	endwhile; 
	
}
	
function bfa_post_kicker($before = '<div class="post-kicker">', $after = '</div>') {
	
	global $bfa_ata;
	
    // don't display on WP Email pages
    if(intval(get_query_var('email')) != 1) {
    	
    	if( (is_home() AND $bfa_ata['post_kicker_home'] != "") OR
    	(is_page() AND $bfa_ata['post_kicker_page'] != "") OR
    	(is_single() AND $bfa_ata['post_kicker_single'] != "") OR
    	( (is_archive() OR is_search() OR is_author() OR is_tag()) AND $bfa_ata['post_kicker_multi'] != "") ) {
    		
			echo $before;
			if ( is_home() ) { 
				echo postinfo($bfa_ata['post_kicker_home']); 
			} 	elseif ( is_page() ) { 
				echo postinfo($bfa_ata['post_kicker_page']); 
			} 	elseif ( is_single() ) { 
				echo postinfo($bfa_ata['post_kicker_single']); 
			} 	else { 
				echo postinfo($bfa_ata['post_kicker_multi']); 
			}
			echo $after;
			
    	}
    	
    }
    
}




function bfa_post_headline($before = '<div class="post-headline">', $after = '</div>') {
	
	global $bfa_ata;

	if ( is_single() OR is_page() ) {
		global $post;
		$bfa_ata_body_title = get_post_meta($post->ID, 'bfa_ata_body_title', true);
		if (!$bfa_ata_body_title == '') {
			$bfa_ata_body_title_saved = get_post_meta($post->ID, 'bfa_ata_body_title_saved', true);
		}
	}
	
	if ( (!is_single() AND !is_page()) OR !($bfa_ata_body_title_saved == 1 AND $bfa_ata_body_title == '' ) ) {
		
		
		echo $before; ?>
		<h<?php echo $bfa_ata['h_posttitle']; ?>><?php 
			
		if( !is_single() AND !is_page() ) { ?>
			
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php 
			if ( function_exists('the_title_attribute') ) { 
				the_title_attribute();
			} 
			elseif ( function_exists('the_title') ) { 
				the_title();
			} ?>"><?php 
		} 
		
		if ( (is_single() OR is_page()) AND $bfa_ata_body_title_saved == 1 ) {
			echo $bfa_ata_body_title;
		} else {
			the_title(); 
		}
		
		if( !is_single() AND !is_page() ) { ?>
			</a><?php 
			
		} ?>
		</h<?php echo $bfa_ata['h_posttitle']; ?>>
		<?php echo $after;
	
	}
	
}




function bfa_post_byline($before = '<div class="post-byline">', $after = '</div>') {
	
	global $bfa_ata;
	
    // don't display on WP Email pages
    if(intval(get_query_var('email')) != 1) {
    	
    	if( (is_home() AND $bfa_ata['post_byline_home'] != "") OR
    	(is_page() AND $bfa_ata['post_byline_page'] != "") OR
    	(is_single() AND $bfa_ata['post_byline_single'] != "") OR
    	( (is_archive() OR is_search() OR is_author() OR is_tag()) AND $bfa_ata['post_byline_multi'] != "") ) {
    		
    		echo $before;
    		if ( is_home() ) { 
    			echo postinfo($bfa_ata['post_byline_home']); 
    		} elseif ( is_page() ) { 
    			echo postinfo($bfa_ata['post_byline_page']); 
    		} elseif ( is_single() ) { 
    			echo postinfo($bfa_ata['post_byline_single']); 
    		} 	else { 
    			echo postinfo($bfa_ata['post_byline_multi']); 
    		}
    		echo $after;
    		
    	}
    	
    }
    
}



						
function bfa_post_bodycopy($before = '<div class="post-bodycopy clearfix">', $after = '</div>') {
	
	global $bfa_ata;
	
	echo $before; 
	if ( (is_home() AND $bfa_ata['excerpts_home'] == "Full Posts") OR 
	(is_category() AND $bfa_ata['excerpts_category'] == "Full Posts") OR 
	(is_date() AND $bfa_ata['excerpts_archive'] == "Full Posts") OR 
	(is_tag() AND $bfa_ata['excerpts_tag'] == "Full Posts") OR 
	(is_search() AND $bfa_ata['excerpts_search'] == "Full Posts") OR 
	(is_author() AND $bfa_ata['excerpts_author'] == "Full Posts") OR 
	is_single() OR is_page() OR 
	(is_home() AND !is_paged() AND $bfa_ata['postcount'] <= $bfa_ata['full_posts_homepage']) ) { 
		$bfa_ata_more_tag_final = str_replace("%post-title%", the_title('', '', false), $bfa_ata['more_tag']);
		the_content($bfa_ata_more_tag_final); 
	} else { 
		the_excerpt(); 
	} 
	echo $after;
	
}



						
function bfa_post_pagination($before = '<p class="post-pagination"><strong>Pages:', $after = '</strong></p>') {
	
	global $bfa_ata;
	
	if ( (is_home() AND $bfa_ata['excerpts_home'] == "Full Posts") OR 
	(is_category() AND $bfa_ata['excerpts_category'] == "Full Posts") OR 
	(is_date() AND $bfa_ata['excerpts_archive'] == "Full Posts") OR 
	(is_tag() AND $bfa_ata['excerpts_tag'] == "Full Posts") OR 
	(is_search() AND $bfa_ata['excerpts_search'] == "Full Posts") OR 
	(is_author() AND $bfa_ata['excerpts_author'] == "Full Posts") OR 
	is_single() OR is_page() ) {
		wp_link_pages('before='.$before.'&after='.$after.'&next_or_number=number'); 
	} 
	
}




function bfa_archives_page($before = '<div class="archives-page">', $after = '</div>') {
	
	global $bfa_ata;
	
	if ( is_page() AND $bfa_ata['current_page_id'] == $bfa_ata['archives_page_id'] ) { 
		
		echo $before;				
		if ( $bfa_ata['archives_date_show'] == "Yes" ) { ?>
			<h3><?php echo $bfa_ata['archives_date_title']; ?></h3>
			<ul>
			<?php wp_get_archives('type=' . $bfa_ata['archives_date_type'] . '&show_post_count=' . 
			($bfa_ata['archives_date_count'] == "Yes" ? '1' : '0') . ($bfa_ata['archives_date_limit'] != "" ? '&limit=' . 
			$bfa_ata['archives_date_limit'] : '')); ?>
			</ul>
		<?php } 						
		if ( $bfa_ata['archives_category_show'] == "Yes" ) { ?>
			<h3><?php echo $bfa_ata['archives_category_title']; ?></h3>
			<ul>
			<?php wp_list_categories('title_li=&orderby=' . $bfa_ata['archives_category_orderby'] . 
			'&order=' . $bfa_ata['archives_category_order'] . 
			'&show_count=' . ($bfa_ata['archives_category_count'] == "Yes" ? '1' : '0') . 
			'&depth=' . $bfa_ata['archives_category_depth'] . 
			($bfa_ata['archives_category_feed'] == "Yes" ? '&feed_image=' . get_bloginfo('template_directory') . 
			'/images/icons/feed.gif' : '')); ?>
			</ul>
		<?php } 
		echo $after;
		
	}
	
}




function bfa_post_footer($before = '<div class="post-footer">', $after = '</div>') {
	
	global $bfa_ata;
	
    // don't display on WP Email pages
    if(intval(get_query_var('email')) != 1) {
    	
    	if( (is_home() AND $bfa_ata['post_footer_home'] != "") OR
    	(is_page() AND $bfa_ata['post_footer_page'] != "") OR
    	(is_single() AND $bfa_ata['post_footer_single'] != "") OR
    	( (is_archive() OR is_search() OR is_author() OR is_tag()) AND $bfa_ata['post_footer_multi'] != "") ) {
    		
    		echo $before;
    		if ( is_home() ) { 
    			echo postinfo($bfa_ata['post_footer_home']); 
    		} elseif ( is_page() ) { 
    			echo postinfo($bfa_ata['post_footer_page']); 
    		} elseif ( is_single() ) { 
    			echo postinfo($bfa_ata['post_footer_single']); 
    		} 	else { 
    			echo postinfo($bfa_ata['post_footer_multi']); 
    		}
    		echo $after;
    		
    	}
    	
    }
    
}




function bfa_get_comments() {
	
	global $bfa_ata;
    
	// Load Comments template (on single post pages, and "Page" pages, if set on options page)
	if ( is_single() OR ( is_page() AND $bfa_ata['comments_on_pages'] == "Yes") ) {
		
		// don't display on WP-Email pages
		if( intval(get_query_var('email')) != 1 ) {
			
			if ( function_exists('paged_comments') ) {
				// If plugin "Paged Comments" is activated, for WP 2.6 and older
				paged_comments_template(); 
			} else {
				// This will load either legacy comments template (for WP 2.6 and older) or the new standard comments template (for WP 2.7 and newer)
				comments_template(); 
			}
		
		}
	
	}
    
}


?>
