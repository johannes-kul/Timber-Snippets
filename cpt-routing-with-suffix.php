<?php

/*
/
/   Timber Routing for CPTs with URL-Suffix (.html in this case)
/   You can put this in your functions.php file.
/
/   Timber Upstatement doesn't support HEAD Request (it may be important for SEO)
/   If you need still need the HEAD Request, then you need to overwrite Upstatement Class. (Snippet on the way)
/
/   Dont forget to swap "your_cpt_slug", "your_term_slug" and "your_template".
/
*/


addHeadRequest::map('/:term/:name'.'.html', function($params){

    # Check if the CPT Name exists
  
    function get_post_by_name(string $name, string $post_type = "your_cpt_clug") {
        $query = new WP_Query([
            "post_type" => $post_type,
            "name" => $name
        ]);
        return $query->have_posts() ? reset($query->posts) : null;
    }
  
    $term = $params['term']; // Save the term (category) from the URL
    $postname = $params['name']; // Save the name from the URL
    $post = get_post_by_name($postname); // Load CPT with that name, if it exists
    $termCheck = has_term($term, 'your_term_slug', $post); // Check if that CPT contains requested term

    if($termCheck) { // Show template if the CPT contains requests term
        $query = 'post_type=your_cpt_slug&name='.$params['name']; // CPT Query with requested name
        addHeadRequest::load('your_template.php', null, $query, 200); // Load your Template and send status response code 200
    }

    // else = let the 404 do the rest
  
  ?>
