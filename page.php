<?php
/*
Template Name: Página
*/

get_header(); ?>

<main id="main" class="site-main">

<?php if ( have_posts() ) : ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">

                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

            </header><div class="entry-content">

                <?php the_content(); ?>

            </div><footer class="entry-footer">

                <?php edit_post_link( 'Editar', '<span class="edit-link">', '</span>' ); ?>

            </footer></article><?php endwhile; ?>

<?php else : ?>

    <p>Nenhuma página encontrada.</p>

<?php endif; ?>

</main><?php get_footer(); ?>
