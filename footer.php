<?php
/**
* Rodapé do Tema
*/

?>

</div><?php get_template_part( 'template-parts/footer-widgets' ); ?>

<footer id="colophon" class="site-footer">

    <div class="site-info">

        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentytwentytwo' ) ); ?>"><?php printf( __( 'Orgulhosamente desenvolvido com %s', 'twentytwentytwo' ), 'WordPress' ); ?></a>

        <a href="<?php echo esc_url( __( 'https://theme.wordpress.com/', 'twentytwentytwo' ) ); ?>"><?php printf( __( 'Tema %s por WordPress.com', 'twentytwentytwo' ), 'Twenty Twenty-Two' ); ?></a>

    </div></footer><?php wp_footer(); ?>

</body>
</html>
