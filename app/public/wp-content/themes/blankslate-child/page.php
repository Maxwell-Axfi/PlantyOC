<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="entry-content" itemprop="mainContentOfPage">

<?php the_content(); ?>

<p>Hello on est sur une page !</p>

<div class="entry-links"><?php wp_link_pages(); ?></div>

</div>
</article>

<?php get_footer(); ?>