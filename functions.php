<?php

namespace Acf_Aspect_Ratio_Validation;

function acf_image_aspect_ratio_settings($field)
{
    // the technique used for adding multiple fields to a
    // single setting is copied directly from the ACF Image
    // field code. anything that ACF does can be replicated,
    // you just need to look at how Elliot does it
    // also, any ACF field type can be used as a setting
    // field for other field types

    $args = array(
        'name' => 'ratio_width',
        'type' => 'number',
        'label' => __('Aspect Ratio'),
        'instructions' => __('Restrict the aspect ratio of uploaded images, plus-minus a percentage'),
        'default_value' => 0,
        'min' => 0,
        'step' => 1,
        'prepend' => __('Width'),
    );

    acf_render_field_setting($field, $args);

    $args = array(
        'name' => 'ratio_height',
        'type' => 'number',
        // notice that there's no label when appending a setting
        'label' => '',
        'default_value' => 0,
        'min' => 0,
        'step' => 1,
        'prepend' => __('Height'),
        // this how we append a setting to the previous one
        'wrapper'       => array(
            'data-append' => 'ratio_width',
            'width' => '',
            'class' => '',
            'id' => ''
        )
    );

    acf_render_field_setting($field, $args);

    $args = array(
        'name' => 'ratio_margin',
        'type' => 'number',
        'label' => '',
        'default_value' => 0,
        'min' => 0,
        'step' => .5,
        'prepend' => __('&plusmn;'),
        'append'        => __('%'),
        'wrapper'       => array(
            'data-append' => 'ratio_width',
            'width' => '',
            'class' => '',
            'id' => ''
        )
    );

    acf_render_field_setting($field, $args);
}

function acf_image_aspect_ratio_validate($errors, $file, $attachment, $field)
{
    // check to make sure everything has a value

    if (
        empty($field['ratio_width']) || empty($field['ratio_height']) ||
        empty($file['width']) || empty($file['height'])
    ) {

        // values we need are not set or otherwise empty
        // bail early

        return $errors;
    }
    // make sure all values are numbers, you never know

    $ratio_width = intval($field['ratio_width']);
    $ratio_height = intval($field['ratio_height']);

    // make sure we don't try to divide by 0

    if (!$ratio_width || !$ratio_height) {

        // cannot do calculations if something is 0
        // bail early

        return $errors;
    }

    $width = intval($file['width']);
    $height = intval($file['height']);

    // do simple ratio math to see how tall
    // the image is allowed to be based on width

    $allowed_height = $width / $ratio_width * $ratio_height;

    // get margin and calc min/max

    $margin = 0;

    if (!empty($field['ratio_margin'])) {
        $ratio_margin = $field['ratio_margin'];
        $margin = floatval($field['ratio_margin']);
    } else {
        $ratio_margin = false;
    }

    $margin = $margin / 100; // convert % to decimal
    $min = round($allowed_height - ($allowed_height * $margin));
    $max = round($allowed_height + ($allowed_height * $margin));

    if ($height < $min || $height > $max) {
        $errors['aspect_ratio'] = __('Image does not meet aspect ratio requirements of ', 'sage') . $ratio_width . ':' . $ratio_height . ($ratio_margin ? ' plus-minus ' . $ratio_margin . '%.' : '');
    }
    return $errors;
}
