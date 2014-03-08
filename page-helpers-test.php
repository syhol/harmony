<?php
/**
 * Helpers Test
 * 
 * Tests the php helpers and wp helpers
 * 
 * Template Name: Helpers Test
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

render_template('header'); ?>

<div class="container">

	<div class="row">
		
		<section class="col-sm-10 col-sm-offset-1">
        
            <h1 class="text-center"><?php page_title(); ?></h1>

			<?php 

            $string = 'Hello, My name is Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque 
            quam mi, viverra dignissim tellus vel, feugiat molestie nulla. Mauris magna libero, bibendum non 
            tempus eu, pellentesque et mauris. Aliquam sed nulla adipiscing, porttitor justo eu, porta mi. 
            Aenean at pharetra ipsum. Mauris pulvinar dolor vulputate, semper nisi eu, ullamcorper lorem. 
            Nulla facilisi. Nunc condimentum magna a fringilla fermentum. Quisque congue odio et tristique 
            pretium. Duis eget venenatis ligula. Mauris rutrum diam eget risus mollis, nec consectetur justo 
            congue';

            echo '<hr>';

            echo '<p>' . $string . '</p>';

            echo '<hr>';

            echo '<p>' . str_limit($string, 43) . '</p>';
            echo '<p>' . str_limit($string, 43, '... More &raquo;') . '</p>';
            echo '<p>' . str_limit($string, 43, '... More &raquo;', false) . '</p>';
            echo '<p>' . str_limit_words($string, 10, '... More &raquo;') . '</p>';

            echo '<hr>';

            echo '<p>' . str_random() . '</p>';
            echo '<p>' . str_random(4) . '</p>';
            echo '<p>' . str_random(24) . '</p>';

            echo '<hr>';

            echo '<p>Ipsum contains "Lorem"</p>';
            var_dump(str_contains($string, 'Lorem'));
            echo '<p>Ipsum contains "ipsum" or "not-in-string"</p>';
            var_dump(str_contains($string, array('amet', 'not-in-string')));
            echo '<p>Ipsum contains "not-in-string" or "still-not-in-string"</p>';
            var_dump(str_contains($string, array('not-in-string', 'still-not-in-tsring')));
            
            echo '<hr>';

            $array = explode_multiple(array(',', '.'), $string);

            foreach($array as $item) {
                echo '<p>' . $item . '</p>';
            }

            $first = array_get_first($array);
            $last = array_get_last($array);

            echo '<hr>';

            echo '<p>First Array Item - ' . $array[$first] . '</p>';
            echo '<p>Last Array Item - ' . $array[$last] . '</p>';

            echo '<hr>';

            echo '<p>Is $first first</p>';
            var_dump(array_is_first($array, $first));
            echo '<p>Is $last first</p>';
            var_dump(array_is_first($array, $last));

            echo '<p>Is $last last</p>';
            var_dump(array_is_last($array, $last));
            echo '<p>Is $first last</p>';
            var_dump(array_is_last($array, $first));

            echo '<hr>';

            ?>

		</section>
	
	</div>

</div>

<?php render_template('footer') ?>