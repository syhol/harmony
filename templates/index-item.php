<div <?php post_class(); ?>>
    
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <h2><?php the_title(); ?></h2>
    </a>

    <?php the_excerpt(); ?>

    <a class="btn btn-default" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        Read More&nbsp;&raquo;
    </a>

</div>