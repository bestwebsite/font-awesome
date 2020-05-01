<?php
/*
Plugin Name: Bestwebsite Font Awesome Icons
Plugin URI: http://www.bestwebsite.com
Description: Use the Font Awesome icon set within WordPress.
Version: 1.0
Author: bestwebsite
Author URI: https://github.com/bestwebsite/font-awesome
 */

define('FONTAWESOME_VERSION', '4.7.0');

function bestwebsite_register_plugin_styles()
{
    global $wp_styles;

    wp_enqueue_style('font-awesome-styles', plugins_url('assets/css/font-awesome.css', __FILE__), array(), FONTAWESOME_VERSION, 'all');
}
add_action('wp_enqueue_scripts', 'bestwebsite_register_plugin_styles');
add_action('admin_enqueue_scripts', 'bestwebsite_register_plugin_styles');

function bestwebsite_setup_shortcode($params)
{
    return '<i class="fa fa-' . esc_attr($params['name']) . '">&nbsp;</i>';
}
add_shortcode('icon', 'bestwebsite_setup_shortcode');

add_filter('widget_text', 'do_shortcode');

function bestwebsite_add_tinymce_hooks()
{
    if ((current_user_can('edit_posts') || current_user_can('edit_pages')) && get_user_option('rich_editing')) {
        add_filter('mce_external_plugins', 'bestwebsite_register_tinymce_plugin');
        add_filter('mce_buttons', 'bestwebsite_add_tinymce_buttons');
        add_filter('teeny_mce_buttons', 'bestwebsite_add_tinymce_buttons');
        add_filter('mce_css', 'bestwebsite_add_tinymce_editor_sytle');
    }
}
add_action('admin_init', 'bestwebsite_add_tinymce_hooks');

function bestwebsite_register_tinymce_plugin($plugin_array = array())
{
    $plugin_array['font_awesome_glyphs'] = plugins_url('assets/js/font-awesome.js', __FILE__);

    return $plugin_array;
}

function bestwebsite_add_tinymce_buttons($buttons = array())
{
    $buttons = (array) $buttons;
    array_push($buttons, '|', 'font_awesome_glyphs');

    return $buttons;
}

function bestwebsite_add_tinymce_editor_sytle($mce_css)
{
    $mce_css .= ', ' . plugins_url('assets/css/font-awesome.min.css', __FILE__);

    return $mce_css;
}
