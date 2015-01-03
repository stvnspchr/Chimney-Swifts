<?php
/**
 * Define the Tabs appearing on the Theme Options page
 * Tabs contains sections
 * Options are assigned to both Tabs and Sections
 * See README.md for a full list of option types
 */

$general_settings_tab = array(
    "name" => "general_tab",
    "title" => __( "General", "gpp" ),
    "sections" => array(
        "general_section_1" => array(
            "name" => "general_section_1",
            "title" => __( "General", "gpp" ),
            "description" => __( "", "gpp" )
        )
    )
);

gpp_register_theme_option_tab( $general_settings_tab );

$colors_tab = array(
    "name" => "colors_tab",
    "title" => __( "Colors", "gpp" ),
    "sections" => array(
        "colors_section_1" => array(
            "name" => "colors_section_1",
            "title" => __( "Colors", "gpp" ),
            "description" => __( "", "gpp" )
        )
    )
);

gpp_register_theme_option_tab( $colors_tab );

 /**
 * The following example shows you how to register theme options and assign them to tabs and sections:
*/
$options = array(
    'logo' => array(
        "tab" => "general_tab",
        "name" => "logo",
        "title" => __( "Logo", "gpp" ),
        "description" => __( "Use a transparent png or jpg image", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "image",
        "default" => ""
    ),
    'favicon' => array(
        "tab" => "general_tab",
        "name" => "favicon",
        "title" => __( "Favicon", "gpp" ),
        "description" => __( "Use a transparent png or ico image", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "image",
        "default" => ""
    ),
    'font' => array(
        "tab" => "general_tab",
        "name" => "font",
        "title" => __( "Headline Font", "gpp" ),
        "description" => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=header&height=600&width=640" class="thickbox">Preview and choose a font</a>', "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "select",
        "default" => "Goudy Bookletter 1911",
        "valid_options" => gpp_font_array()
    ),
    'font_alt' => array(
        "tab" => "general_tab",
        "name" => "font_alt",
        "title" => __( "Body Font", "gpp" ),
        "description" => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=body&height=600&width=640" class="thickbox">Preview and choose a font</a>', "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "select",
        "default" => "Cardo:400,400italic,700",
        "valid_options" => gpp_font_array()
    ),
    "css" => array(
        "tab" => "colors_tab",
        "name" => "css",
        "title" => __( "Custom CSS", "gpp" ),
        "description" => __( "Add some custom CSS to your theme.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "textarea",
        "sanitize" => "html",
        "default" => ""
    ),
    "standard" => array(
        "tab" => "colors_tab",
        "name" => "standard",
        "title" => __( "Standard Background Color", "gpp" ),
        "description" => __( "Select background color for stardard post format.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "color",
        "sanitize" => "html",
        "default" => "#ffffff"
    ),
    "image" => array(
        "tab" => "colors_tab",
        "name" => "image",
        "title" => __( "Image Background Color", "gpp" ),
        "description" => __( "Select background color for Image post format.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "color",
        "sanitize" => "html",
        "default" => "#66a5c9"
    ),
    "video" => array(
        "tab" => "colors_tab",
        "name" => "video",
        "title" => __( "Video Background Color", "gpp" ),
        "description" => __( "Select background color for Video post format.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "color",
        "sanitize" => "html",
        "default" => "#71ad49"
    ),
    "quote" => array(
        "tab" => "colors_tab",
        "name" => "quote",
        "title" => __( "Quote Background Color", "gpp" ),
        "description" => __( "Select background color for Quote post format.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "color",
        "sanitize" => "html",
        "default" => "#ffefb0"
    ),
    "gallery" => array(
        "tab" => "colors_tab",
        "name" => "gallery",
        "title" => __( "Gallery Background Color", "gpp" ),
        "description" => __( "Select background color for Gallery post format.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "color",
        "sanitize" => "html",
        "default" => "#e55b5b"
    )
);

gpp_register_theme_options( $options );
