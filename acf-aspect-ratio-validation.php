<?php

/**
 * Plugin Name: ACF Image field aspect ratio validation
 * Description: Adds a validation to ACF image fields checking whether the uploaded image conforms to a certain aspect ratio.
 * Version: 0.0.2
 * Author: John Huebner
 * Text Domain: acfaspratval
 * Domain Path: /languages
 */
namespace Acf_Aspect_Ratio_Validation;

if (!defined('ABSPATH'))
    exit;

class Acf_Aspect_Ratio_Validation
{

    public function load()
    {
        include_once 'functions.php';

        // add new settings for aspect ratio to image field
        add_filter('acf/render_field_settings/type=image', __NAMESPACE__ . '\\acf_image_aspect_ratio_settings', 20);

        // add filter to validate images to ratio
        add_filter('acf/validate_attachment/type=image', __NAMESPACE__ . '\\acf_image_aspect_ratio_validate', 20, 4);
    }

    public function acf_aspect_ratio_validation_load_plugin_textdomain()
    {
        load_plugin_textdomain('acfaspratval', FALSE, basename(dirname(__FILE__)) . '/languages/');
    }
}

function acf_aspect_ratio_validation_load()
{
    $acf_aspect_ratio_validation = new Acf_Aspect_Ratio_Validation();
    $acf_aspect_ratio_validation->acf_aspect_ratio_validation_load_plugin_textdomain();
    $acf_aspect_ratio_validation->load();
}

add_action('plugins_loaded', __NAMESPACE__ . '\\acf_aspect_ratio_validation_load');
