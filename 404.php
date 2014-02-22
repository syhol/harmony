<?php
/**
 * 404 Page
 *
 * Uses default headers and footers with a full width 12 col content
 * Template used when a route is not matched or content is not found in 
 * the database
 */

render_template('header'); ?>

<div class="container">

    <div class="row">
        
        <section class="col-md-12">
        
            <header>
            
                <h1>404</h1>
                
            </header>
            
            <article>
            
                    <p>That page you requested does not exist.</p>
            
            </article>
        
        </section>
    
    </div>

</div>

<?php render_template('footer'); ?>