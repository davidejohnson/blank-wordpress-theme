<?php

/**
 * This function allows for pages to stand alone at the top of the page neirarchy, or contain a tree
 * of descendant pages and whilst adopting the template of the parent.
 *
 * @package WordPress
 * @subpackage quantumpress
 * To activate, include this file in the functions.php.
 * 
 */

add_action('template_redirect','hierarchical_page_template_redirect');

function hierarchical_page_template_redirect () {
	global $post;
		if ( is_page() ) { //This is a page - any page - see if it has its own page-[id].php template - that will take precedence over all other templates
			if ( file_exists( locate_template( array('/page-' . $post->ID . '.php'), true ) ) ) { // A page-[id].php template exists for current page - USE IT
			} 
			elseif ( ! $post->post_parent ) { // No parent so must be a top level page that has no page-[id].php template 
				return;  // so let WP select?
			} else { // this a sub-page with no page-[id].php template - so check to see if an ancestor page has a template
				$ancestors = get_post_ancestors($post); // assign the ancestor page IDs to an array
				foreach ($ancestors as $ancestor_page_id) { // loop through the ancestor page IDs to find the first page-[id].php template (default order = ascending)
					if ( file_exists ( locate_template( array('/page-' . $ancestor_page_id . '.php'), true ) ) ) {
        				exit; // Exit the function - an ancestor page-[ID].php template file exists - USE IT!
					} // End if (no page-[id].php file exists for the page ID selected in the array) - back to next foreach
				} // End first foreach - no page-[id].php file has been found all the way back up the tree
				foreach ($ancestors as $ancestor_page_id) { // loop through the ancestor page IDs to find the first page-[slug].php template (default order = ascending)
					$ancestor_slug = get_post($ancestor_page_id)->post_name;
					if ( file_exists ( locate_template( array('/page-' . $ancestor_slug . '.php'), true ) ) ) {
        				exit; // Exit the function - an ancestor page-[slug].php template file exists - USE IT!
					} // End if (no page-[slug].php file exists for the page ID selected in the array) - back to next foreach
				} // End second foreach - no page-[slug].php file has been found all the way back up the tree
				$current_page_template = get_post_meta($post->ID,'_wp_page_template',true); // Check if current page is assigned a custom.php template?
				if ( file_exists ( locate_template ( array('/' .  $current_page_template ), true ) ) ) {
					exit; // Exit the function - the current page does have a meta assigned custom.php template - USE IT!
				} else {  // The current page does not have a meta assigned custom.php template
					foreach ($ancestors as $ancestor_page_id) { // so loop through the ancestor pages to find the first one having a meta assigned custom.php template
						$ancestor_page_template = get_post_meta($ancestor_page_id,'_wp_page_template',true);
						if ( file_exists ( locate_template ( array('/' .  $ancestor_page_template ), true ) ) ) {
							exit; // Exit the function - an ancestor page with a custom.php template file has been located - USE IT!
						} // End if (no custom.php file assigned to the page ID selected in the array) - back to next foreach
					} // End third foreach - no custom.php file has been found all the way back up the ancestral tree
				} // end if/else - no custom.php file has been found in this page lineage
				return;  // so let WP select?
			} // End if/else (no template files of any kind exist in this page's lineage)
			exit; // so let WP select?
		} // this is not a page - function closes
}

?>