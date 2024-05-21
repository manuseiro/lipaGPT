<?php
/*
Template Name: Página 404
*/

get_header(); ?>

<main id="main" class="site-main">

    <article class="error-404">

        <header class="entry-header">

            <h1>Página não encontrada</h1>

        </header><div class="entry-content">

            <p>Desculpe, a página que você procura não foi encontrada.</p>

            <p>Você pode tentar:</p>

            <ul>

                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Voltar para a página inicial</a></li>

                <li><a href="<?php echo esc_url( sitemap_url() ); ?>">Ver o mapa do site</a></li>

                <li><a href="<?php echo esc_url( __("#search", 'search') ); ?>">Pesquisar no site</a></li>

            </ul>

        </div></article></main><?php get_footer(); ?>
