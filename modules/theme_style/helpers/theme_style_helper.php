<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Defined styling areas for the theme style feature
 * Those string are not translated to keep the language file neat
 *
 * @param string $type
 *
 * @return array
 */
function get_styling_areas($type = 'admin')
{
    $areas = [
        'admin' => [
            [
                'name'                 => _l('theme_style_sidebar_bg_color'),
                'id'                   => 'admin-menu',
                'target'               => '.admin .sidebar',
                'css'                  => 'background',
                'additional_selectors' => 'body|background+.sidebar .nav > li .nav-second-level > li:not(.active) > a:hover, .sidebar .nav > li .nav-second-level > li:not(.active) > a:focus|background',
            ],
            // [
            //     'name'                 => _l('theme_style_sidebar_open_bg_color'),
            //     'id'                   => 'admin-menu-submenu-open',
            //     'target'               => '.admin #side-menu li .nav-second-level li,.admin #setup-menu li .nav-second-level li',
            //     'css'                  => 'background',
            //     'additional_selectors' => '',
            // ],
            [
                'name'                 => _l('theme_style_sidebar_links_color'),
                'id'                   => 'admin-menu-links',
                'target'               => '.admin #side-menu li a,.admin #setup-menu li a, .admin #side-menu li a i.menu-icon',
                'css'                  => 'color',
                'additional_selectors' => '.admin #setup-menu-wrapper .customizer-heading|color+.admin #setup-menu-wrapper .close-customizer|color',
            ],
            // [
            //     'name'                 => _l('theme_style_sidebar_user_welcome_text_color'),
            //     'id'                   => 'user-welcome-text-color',
            //     'target'               => '#side-menu li.dashboard_user',
            //     'css'                  => 'color',
            //     'additional_selectors' => '',
            // ],
            [
                'name'   => _l('theme_style_sidebar_active_item_bg_color'),
                'id'     => 'admin-menu-active-item',
                'target' => '
                .admin #side-menu li.active > a,
                .admin #setup-menu li.active > a,
                #side-menu.nav > li > a:hover,
                #side-menu.nav > li > a:focus,
                #setup-menu > li > a:hover,
                #setup-menu > li > a:focus',
                'css'                  => 'background',
                'additional_selectors' => '',
            ],
            [
                'name'   => _l('theme_style_sidebar_active_item_color'),
                'id'     => 'admin-menu-active-item-color',
                'target' => '
                .admin #side-menu li.active > a:first-child,                
                .admin #side-menu li.active a i.menu-icon,
                .admin #side-menu li:hover a:first-child,
                .admin #side-menu li:hover a:first-child i.menu-icon,
                .admin #setup-menu li.active > a:first-child,                
                .admin #setup-menu li.active a i.menu-icon,
                .admin #setup-menu li:hover a:first-child,
                .admin #setup-menu li:hover a:first-child i.menu-icon',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
            // [
            //     'name'                 => _l('theme_style_sidebar_active_sub_item_bg_color'),
            //     'id'                   => 'admin-menu-active-subitem',
            //     'target'               => '.admin #side-menu li .nav-second-level li.active a,.admin #setup-menu li .nav-second-level li.active a',
            //     'css'                  => 'background',
            //     'additional_selectors' => '',
            // ],
            // [
            //     'name'                 => _l('theme_style_sidebar_active_sub_item_links_color'),
            //     'id'                   => 'admin-menu-submenu-links',
            //     'target'               => '.admin #side-menu li .nav-second-level li a,#setup-menu li .nav-second-level li a',
            //     'css'                  => 'color',
            //     'additional_selectors' => '',
            // ],
            [
                'name'                 => _l('theme_style_top_header_bg_color'),
                'id'                   => 'top-header',
                'target'               => '.admin #header',
                'css'                  => 'background',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_top_header_bg_links_color'),
                'id'                   => 'top-header-links',
                'target'               => '.admin .navbar-nav > li > a, .admin .navbar-nav > li > a > span > i, ul.mobile-icon-menu>li>a,.mobile-menu-toggle, .open-customizer-mobile, .admin .navbar-nav a.top-timers:hover i, .admin .navbar-nav a.notifications-icon:hover i',
                'css'                  => 'color',
                'additional_selectors' => '.admin button.hide-menu|color',
            ],
            [
                'name'                 => _l('theme_style_content_background_color'),
                'id'                   => 'content',
                'target'               => 'body.admin,.admin #wrapper',
                'css'                  => 'background',
                'additional_selectors' => '.admin button.hide-menu|color',
            ],
        ],
        'tables' => [
            [
                'name'                 => _l('theme_style_table_links_color'),
                'id'                   => 'table-links-color',
                'target'               => '.dataTables_wrapper table tbody a:not(.text-muted,.text-primary,.text-danger,.text-warning,.text-success,.text-info)',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_table_links_hover_focus_color'),
                'id'                   => 'table-links-hover-focus-color',
                'target'               => '.dataTables_wrapper table tbody a:hover:not(.text-muted,.text-primary,.text-danger,.text-warning,.text-success,.text-info),.dataTables_wrapper table tbody a:focus:not(.text-muted,.text-primary,.text-danger,.text-warning,.text-success,.text-info)',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_table_headings_color'),
                'id'                   => 'table-headings',
                'target'               => 'table.dataTable thead tr>th, .table.dataTable>thead:first-child>tr:first-child>th',
                'css'                  => 'color',
                'additional_selectors' => '',
                'example'              => '<table class="table dataTable"><thead><tr><th style="border-bottom: 1px solid #f0f0f0" class="sorting">' . _l('theme_style_example_table_heading') . ' 1</th><th style="border-bottom: 1px solid #f0f0f0" class="sorting">' . _l('theme_style_example_table_heading') . ' 2</th></tr></thead></table>',
            ],
            [
                'name'                 => 'Items Table Headings Background Color',
                'id'                   => 'table-items-heading',
                'target'               => '.table.items thead',
                'css'                  => 'background',
                'additional_selectors' => '.table.items>thead>tr>th|border-top-color+.table.items>thead>tr>th|border-bottom-color+.table.items>thead>tr>th|border-right-color+.table.items>thead>tr>th|border-left-color+.table.items>thead:first-child>tr:first-child>th|border-color',
                'example'              => '<table class="table items"><thead><tr><th>' . _l('theme_style_example_table_heading') . ' 1</th><th>' . _l('theme_style_example_table_heading') . ' 2</th></tr></thead></table>',
            ],
            [
                'name'                 => 'Items Table Headings Text Color',
                'id'                   => 'table-items-heading-text-color',
                'target'               => '.table.items thead th',
                'css'                  => 'color',
                'additional_selectors' => '',
                'example'              => '',
            ],
        ],
        'customers' => [
            [
                'name'                 => _l('theme_style_navigation_bg_color'),
                'id'                   => 'customers-navigation',
                'target'               => '.customers .navbar-default',
                'css'                  => 'background',
                'additional_selectors' => '.navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > li > a:hover|background+.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover|background',
            ],
            [
                'name'                 => _l('theme_style_navigation_link_color'),
                'id'                   => 'customers-navigation-links',
                'target'               => '.customers .navbar-default .navbar-nav>li>a',
                'css'                  => 'color',
                'additional_selectors' => '.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover|color',
            ],
            [
                'name'                 => _l('theme_style_footer_background'),
                'id'                   => 'customers-footer-background',
                'target'               => '.customers footer',
                'css'                  => 'background',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_footer_text_color'),
                'id'                   => 'customers-footer-text',
                'target'               => '.customers footer',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
        ],
        'general' => [
            [
                'name'                 => '<a href="#" onclick="return false;">' . _l('theme_style_links') . '</a> ' . _l('theme_style_color') . ' (href)',
                'id'                   => 'links-color',
                'target'               => 'a',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_link_hover_color'),
                'id'                   => 'links-hover-focus',
                'target'               => 'a:hover,a:focus',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],

            [
                'name'                 => _l('theme_style_admin_login_background'),
                'id'                   => 'admin-login-background',
                'target'               => 'body.login_admin',
                'css'                  => 'background',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_text_muted'),
                'id'                   => 'text-muted',
                'target'               => '.text-muted',
                'css'                  => 'color',
                'additional_selectors' => '',
                'example'              => '<p>' . _l('theme_style_example_text', '<span class="bold text-muted">' . _l('theme_style_text_muted') . '</span>') . '</p>',
            ],
            [
                'name'                 => _l('theme_style_text_danger'),
                'id'                   => 'text-danger',
                'target'               => '.text-danger',
                'css'                  => 'color',
                'additional_selectors' => '',
                'example'              => '<p>' . _l('theme_style_example_text', '<span class="bold text-danger">' . _l('theme_style_text_danger') . '</span>') . '</p>',
            ],
            [
                'name'                 => _l('theme_style_text_warning'),
                'id'                   => 'text-warning',
                'target'               => '.text-warning',
                'css'                  => 'color',
                'additional_selectors' => '',
                'example'              => '<p>' . _l('theme_style_example_text', '<span class="bold text-warning">' . _l('theme_style_text_warning') . '</span>') . '</p>',
            ],
            [
                'name'                 => _l('theme_style_text_info'),
                'id'                   => 'text-info',
                'target'               => '.text-info',
                'css'                  => 'color',
                'additional_selectors' => '',
                'example'              => '<p>' . _l('theme_style_example_text', '<span class="bold text-info">' . _l('theme_style_text_info') . '</span>') . '</p>',
            ],
            [
                'name'                 => _l('theme_style_text_success'),
                'id'                   => 'text-success',
                'target'               => '.text-success',
                'css'                  => 'color',
                'additional_selectors' => '',
                'example'              => '<p>' . _l('theme_style_example_text', '<span class="bold text-success">' . _l('theme_style_text_success') . '</span>') . '</p>',
            ],
        ],
        'tabs' => [
            // [
            //     'name'                 => _l('theme_style_tabs_bg_color'),
            //     'id'                   => 'tabs-bg',
            //     'target'               => '.nav-tabs',
            //     'css'                  => 'background',
            //     'additional_selectors' => '',
            // ],
            // [
            //     'name'                 => _l('theme_style_tabs_links_color'),
            //     'id'                   => 'tabs-links',
            //     'target'               => '.nav-tabs>li>a',
            //     'css'                  => 'color',
            //     'additional_selectors' => '',
            // ],
            // [
            //     'name'                 => _l('theme_style_tabs_active_links_color'),
            //     'id'                   => 'tabs-links-active-hover',
            //     'target'               => '.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover, .nav-tabs>li>a:focus, .nav-tabs>li>a:hover',
            //     'css'                  => 'color',
            //     'additional_selectors' => '',
            // ],

            // [
            //     'name'                 => _l('theme_style_tabs_active_border_color'),
            //     'id'                   => 'tabs-active-border',
            //     'target'               => '.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover, .nav-tabs>li>a:focus, .nav-tabs>li>a:hover',
            //     'css'                  => 'border-bottom-color',
            //     'additional_selectors' => '',
            // ],
        ],
        'modals' => [
            [
                'name'                 => _l('theme_style_modal_heading_bg'),
                'id'                   => 'modal-heading',
                'target'               => '.modal-header',
                'css'                  => 'background',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_modal_heading_color'),
                'id'                   => 'modal-heading-color',
                'target'               => '.modal-header .modal-title',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_modal_close_btn_color'),
                'id'                   => 'modal-close-button-color',
                'target'               => '.modal-header .close',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
            [
                'name'                 => _l('theme_style_modal_header_text_color'),
                'id'                   => 'modal-header-white-text-color',
                'target'               => '.modal-header > *:not(.modal-title)',
                'css'                  => 'color',
                'additional_selectors' => '',
            ],
        ],
        'buttons' => [
            [
                'name'                 => _l('theme_style_button_default'),
                'id'                   => 'btn-default',
                'target'               => '.btn-default',
                'css'                  => 'background-color',
                'additional_selectors' => '.btn-default|border-color',
                'example'              => '<button type="button" class="btn btn-default">' . _l('theme_style_button_default') . '</button>',
            ],
            [
                'name'                 => _l('theme_style_button_primary'),
                'id'                   => 'btn-primary',
                'target'               => '.btn-primary',
                'css'                  => 'background-color',
                'additional_selectors' => '.btn-primary|border-color',
                'example'              => '<button type="button" class="btn btn-primary">' . _l('theme_style_button_primary') . '</button>',
            ],
            [
                'name'                 => _l('theme_style_button_info'),
                'id'                   => 'btn-info',
                'target'               => '.btn-info',
                'css'                  => 'background-color',
                'additional_selectors' => '.btn-info|border-color',
                'example'              => '<button type="button" class="btn btn-info">' . _l('theme_style_button_info') . '</button>',
            ],
            [
                'name'                 => _l('theme_style_button_success'),
                'id'                   => 'btn-success',
                'target'               => '.btn-success',
                'css'                  => 'background-color',
                'additional_selectors' => '.btn-success|border-color',
                'example'              => '<button type="button" class="btn btn-success">' . _l('theme_style_button_success') . '</button>',
            ],
            [
                'name'                 => _l('theme_style_button_danger'),
                'id'                   => 'btn-danger',
                'target'               => '.btn-danger',
                'css'                  => 'background-color',
                'additional_selectors' => '.btn-danger|border-color',
                'example'              => '<button type="button" class="btn btn-danger">' . _l('theme_style_button_danger') . '</button>',
            ],
        ],
    ];

    $CI   = &get_instance();
    $tags = get_tags();

    $areas['tags'] = [];

    foreach ($tags as $tag) {
        array_push($areas['tags'], [
            'name'                 => $tag['name'],
            'id'                   => 'tag-' . $tag['id'],
            'target'               => '.tag-id-' . $tag['id'],
            'css'                  => 'color',
            'additional_selectors' => 'ul.tagit li.tagit-choice.tag-id-' . $tag['id'] . ' .tagit-label:not(a)|color',
            'example'              => '<span class="label label-tag tag-id-' . $tag['id'] . '">' . $tag['name'] . '</span>',
        ]);
    }

    $areas = hooks()->apply_filters('get_styling_areas', $areas);

    if (! is_array($type)) {
        return $areas[$type];
    }

    $_areas = [];

    foreach ($type as $t) {
        $_areas[] = $areas[$t];
    }

    return $_areas;
}
/**
 * Will fetch from database the stored applied styles and return
 *
 * @return object
 */
function get_applied_styling_area()
{
    $theme_style = get_option('theme_style');
    if ($theme_style == '') {
        return [];
    }

    return json_decode($theme_style);
}
/**
 * Function that will parse and render the applied styles
 *
 * @param string $type
 *
 * @return void
 */
function theme_style_render($type)
{
    $theme_style   = get_applied_styling_area();
    $styling_areas = get_styling_areas($type);

    foreach ($styling_areas as $type => $area) {
        foreach ($area as $_area) {
            foreach ($theme_style as $applied_style) {
                if ($applied_style->id == $_area['id']) {
                    echo '<style class="custom_style_' . $_area['id'] . '">' . PHP_EOL;
                    echo $_area['target'] . '{' . PHP_EOL;
                    echo $_area['css'] . ':' . $applied_style->color . ';' . PHP_EOL;
                    echo '}' . PHP_EOL;
                    if (startsWith($_area['target'], '.btn')) {
                        echo '
                        ' . $_area['target'] . ':focus,' . $_area['target'] . '.focus,' . $_area['target'] . ':hover,' . $_area['target'] . ':active,
                        ' . $_area['target'] . '.active,
                        .open > .dropdown-toggle' . $_area['target'] . ',' . $_area['target'] . ':active:hover,
                        ' . $_area['target'] . '.active:hover,
                        .open > .dropdown-toggle' . $_area['target'] . ':hover,
                        ' . $_area['target'] . ':active:focus,
                        ' . $_area['target'] . '.active:focus,
                        .open > .dropdown-toggle' . $_area['target'] . ':focus,
                        ' . $_area['target'] . ':active.focus,
                        ' . $_area['target'] . '.active.focus,
                        .open > .dropdown-toggle' . $_area['target'] . '.focus,
                        ' . $_area['target'] . ':active,
                        ' . $_area['target'] . '.active,
                        .open > .dropdown-toggle' . $_area['target'] . '{background-color:' . adjust_color_brightness($applied_style->color, -50) . ';color:#fff;border-color:' . adjust_color_brightness($applied_style->color, -50) . ';' . $applied_style->color . ';}';
                        echo '
                        ' . $_area['target'] . '.disabled,
                        ' . $_area['target'] . '[disabled],
                        fieldset[disabled] ' . $_area['target'] . ',
                        ' . $_area['target'] . '.disabled:hover,
                        ' . $_area['target'] . '[disabled]:hover,
                        fieldset[disabled] ' . $_area['target'] . ':hover,
                        ' . $_area['target'] . '.disabled:focus,
                        ' . $_area['target'] . '[disabled]:focus,
                        fieldset[disabled] ' . $_area['target'] . ':focus,
                        ' . $_area['target'] . '.disabled.focus,
                        ' . $_area['target'] . '[disabled].focus,
                        fieldset[disabled] ' . $_area['target'] . '.focus,
                        ' . $_area['target'] . '.disabled:active,
                        ' . $_area['target'] . '[disabled]:active,
                        fieldset[disabled] ' . $_area['target'] . ':active,
                        ' . $_area['target'] . '.disabled.active,
                        ' . $_area['target'] . '[disabled].active,
                        fieldset[disabled] ' . $_area['target'] . '.active {
                            background-color: ' . adjust_color_brightness($applied_style->color, 50) . ';color:#fff;border-color:' . adjust_color_brightness($applied_style->color, 50) . ';}';
                    }
                    if ($_area['additional_selectors'] != '') {
                        $additional_selectors = explode('+', $_area['additional_selectors']);

                        foreach ($additional_selectors as $as) {
                            $_temp = explode('|', $as);
                            echo $_temp[0] . ' {' . PHP_EOL;
                            echo $_temp[1] . ':' . $applied_style->color . ';' . PHP_EOL;
                            echo '}' . PHP_EOL;
                        }
                    }
                    echo '</style>' . PHP_EOL;
                }
            }
        }
    }
}
/**
 * Get selected value for some styling area for the Theme style feature
 *
 * @param string $type
 * @param string $selector
 *
 * @return string
 */
function get_custom_style_values($type, $selector)
{
    $value         = '';
    $theme_style   = get_applied_styling_area();
    $styling_areas = get_styling_areas($type);

    foreach ($styling_areas as $area) {
        if ($area['id'] == $selector) {
            foreach ($theme_style as $applied_style) {
                if ($applied_style->id == $selector) {
                    $value = $applied_style->color;

                    break;
                }
            }
        }
    }

    return $value;
}

function render_theme_styling_picker($id, $value, $target, $css, $additional = '')
{
    echo '<div class="input-group mbot15 colorpicker-component" data-target="' . $target . '" data-css="' . $css . '" data-additional="' . $additional . '">
    <input type="text" value="' . $value . '" data-id="' . $id . '" class="form-control" />
    <span class="input-group-addon"><i></i></span>
    </div>';
}

function is_admin_sidebar_background_light()
{
    if (! function_exists('determine_color_type')) {
        return true;
    }

    $styles = (array) get_applied_styling_area();

    $darkThreshold  = 40;
    $lightThreshold = 55;

    if (! empty($styles)) {
        $sidebarBgStyle = collect($styles)->first(fn ($style) => $style->id === 'admin-menu');

        if ($sidebarBgStyle) {
            $sidebarBgColor = $sidebarBgStyle->color;

            if (! empty($sidebarBgColor)) {
                $type = determine_color_type($sidebarBgColor);

                $isDarkAndLowBrightness  = $type['type'] === 'dark' && $type['percentage'] < $darkThreshold;
                $isLightAndLowBrightness = $type['type'] === 'light' && $type['percentage'] < $lightThreshold;

                return $isDarkAndLowBrightness || $isLightAndLowBrightness;
            }
        }
    }

    return false;
}

function determine_header_logo_url_based_on_background_color($url)
{
    if (! function_exists('determine_color_type')) {
        return $url;
    }

    $styles = (array) get_applied_styling_area();

    $darkThreshold  = 40;
    $lightThreshold = 55;

    if (! empty($styles)) {
        $headerBgStyle = collect($styles)->first(fn ($style) => $style->id === 'top-header');

        if ($headerBgStyle) {
            $headerBgColor = $headerBgStyle->color;

            if (! empty($headerBgColor)) {
                $type = determine_color_type($headerBgColor);

                $isDarkAndLowBrightness  = $type['type'] === 'dark' && $type['percentage'] < $darkThreshold;
                $isLightAndLowBrightness = $type['type'] === 'light' && $type['percentage'] < $lightThreshold;

                if ($isDarkAndLowBrightness || $isLightAndLowBrightness) {
                    $light_logo = get_option('company_logo');

                    if (! empty($light_logo)) {
                        $url = base_url('uploads/company/' . $light_logo);
                    }
                }
            }
        }
    }

    return $url;
}
