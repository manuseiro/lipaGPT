<?php
/**
* Cabeçalho do Tema
*/

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php get_template_part( 'template-parts/navigation' ); ?>

<header id="masthead" class="site-header">

    <div class="site-branding">

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

            <?php if ( is_home() || is_front_page() ) : ?>

                <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>

            <?php else : ?>

                <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>

            <?php endif; ?>

        </a>

    </div><nav id="site-navigation" class="main-navigation">

        <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

    </nav></header><div class="container">