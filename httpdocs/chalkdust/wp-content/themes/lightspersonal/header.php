<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- Browser Bar Titles -->
		<?php if( is_front_page() ) : ?>
            <title><?php bloginfo('name'); ?> | <?php bloginfo('description');?></title>
		<?php elseif( is_404() ) : ?>
            <title>Page Not Found | <?php bloginfo('name'); ?></title>
		<?php elseif( is_search() ) : ?>
            <title><?php  print 'Search Results for ' . wp_specialchars($s); ?> | <?php bloginfo('name'); ?></title>
		<?php else : ?>
            <title><?php wp_title($sep = ''); ?> | <?php bloginfo('name');?></title>
		<?php endif; ?>
	<!-- Meta Tags -->
        <meta name="copyright" content="Network Solutions Theme" />
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <meta name="robots" content="index,follow" />
	<!-- CSS Styles -->
        <link href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" rel="stylesheet" />
        <!--[if lte IE 6]>
            <link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/ie6.css" />
        <![endif]-->
	<!-- RSS and Pingback -->
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!-- WordPress Hook -->
		<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
			<?php wp_head(); ?>
</head>
<body>
<div id="wrapper">
<!-- Header -->
	<div id="header">
   	<!-- Header Title -->
		<h1 id="title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	<!-- Blog Description -->
        <h2 id="description"><?php bloginfo('description'); ?></h2>
    <!-- Header Search -->
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
    <!-- Header Navigation -->
		<ul id="nav">
			<li class="page_item <?php if (is_home()) echo('current_page_item');?>"><a href="<?php bloginfo('url'); ?>">Home</a></li>
			<?php $exclude_pages = get_option('NS_pages_to_exclude'); ?>
            <?php wp_list_pages('depth=1&title_li=&exclude=' . $exclude_pages); ?>
		</ul>
<!-- End Header-->
