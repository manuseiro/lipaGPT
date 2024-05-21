<?php
/*
Template Name: Post Único
*/

get_header(); ?>

<main id="main" class="site-main">

<?php if ( have_posts() ) : ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">

                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                <div class="entry-meta">

                    <span class="published-on"><time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'j \F M \Y' ); ?></time></span>

                    <span class="byline">Por <a href="<?php the_author_posts_url(); ?>"><?php the_author(); ?></a></span>

                    <span class="comments-link"><?php comments_popup_link( 'Nenhum Comentário', '1 Comentário', '%d Comentários' ); ?></span>

                </div></header><div class="entry-content">

                    <?php the_content(); ?>

                    <?php wp_link_pages(); ?>

                </div><footer class="entry-footer">

                    <?php if ( has_category() ) : ?>

                        <span class="cat-links">Publicado em: <?php the_category( ', ' ); ?></span>

                    <?php endif; ?>

                    <?php if ( has_tag() ) : ?>

                        <span class="tag-links">Marcado com: <?php the_tags( ', ' ); ?></span>

                    <?php endif; ?>

                    <?php edit_post_link( 'Editar', '<span class="edit-link">', '</span>' ); ?>

                </footer></article><?php endwhile; ?>

<?php else : ?>

    <p>Nenhum post encontrado.</p>

<?php endif; ?>

</main><?php get_sidebar(); ?><?php get_footer(); ?>
