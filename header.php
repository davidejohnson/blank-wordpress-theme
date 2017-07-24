<?php

/* 
 * The MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

?>

<!DOCTYPE html>
<!--[if lt IE 7]><html class="lt-ie9 lt-ie8 lt-ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><![endif]-->
<!--[if IE 7]><html class="lt-ie9 lt-ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><![endif]-->
<!--[if IE 8]><html class="lt-ie9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html><!--<![endif]-->

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php /** Print the <title>tag based on what is being viewed from the * pagetitle custom control. */ $title = get_post_meta($post->ID,'_pagetitle_custom',TRUE); if (!empty($title)) { echo $title['title'] . " | 121move.co.uk"; } ?>
    </title>

    <meta name="description" content="<?php 
                $metadata = get_post_meta($post->ID,'_meta_custom',TRUE);
                if (!empty($metadata)) {
                    echo $metadata['description'];
                }
            ?>">

    <link rel="canonical" href="http://yourdomain/" />
    <link href="https://plus.google.com/##########" rel="publisher" />
        
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" type="text/css" />    
        
</head>

<body>
    <header id="header">
        <div class="row ">
        	<div class="col-xs-12">
                <nav  role="navigation">
                    <?php wp_nav_menu( array( 'theme_location'=>'primary', 'menu_class' => 'nav' ) ); ?>
                </nav>
            </div>
        </div>
    </header>