<?php
/*
Template Name: Página Inicial
*/

get_header(); ?>

<main id="main" class="site-main">

<?php if ( have_posts() ) : ?>

    <div class="post-grid">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">

                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                    <div class="entry-meta">

                        <span class="published-on"><time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'j \F M \Y' ); ?></time></span>

                        <span class="byline">Por <a href="<?php the_author_posts_url(); ?>"><?php the_author(); ?></a></span>

                        <span class="comments-link"><?php comments_popup_link( 'Nenhum Comentário', '1 Comentário', '%d Comentários' ); ?></span>

                    </div></header><div class="entry-content">

                    <?php the_excerpt(); ?>

                    <a href="<?php the_permalink(); ?>" class="read-more">Ler Mais</a>

                </div></article><?php endwhile; ?>

    </div><?php else : ?>

    <p>Nenhum post encontrado.</p>

<?php endif; ?>

</main><?php get_footer(); ?>