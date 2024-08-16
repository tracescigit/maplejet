<?php
if (!function_exists('tracescicss')) {
    function tracescicss($path)
    {
        // Remove the public_path() function and use only the relative path
        $css_path = '/assets/css/';
        // Use the base URL directly without using env() helper
        return url($css_path . $path);
    }
}

if (!function_exists('tracesciimg')) {
    function tracesciimg($path)
    {
        // Remove the public_path() function and use only the relative path
        $css_path = '/assets/img/';
        // Use the base URL directly without using env() helper
        return url($css_path . $path);
    }
}

if (!function_exists('tracesciicon')) {
    function tracesciicon($path)
    {
        // Remove the public_path() function and use only the relative path
        $font_path = '/assets/fonts/';
        // Use the base URL directly without using env() helper
        return url($font_path . $path);
    }
}
if (!function_exists('tracescijs')) {
    function tracescijs($path)
    {
        // Remove the public_path() function and use only the relative path
        $css_path = '/assets/js/';
        // Use the base URL directly without using env() helper
        return url($css_path . $path);
    }
}
if (!function_exists('tracescifont')) {
    function tracescifont($path)
    {
        // Remove the public_path() function and use only the relative path
        $font_path = '/assets/fonts/';
        // Use the base URL directly without using env() helper
        return url($font_path . $path);
    }
}
if (!function_exists('tracesci_dash')) {
    function tracesci_dash($path)
    {
        // Remove the public_path() function and use only the relative path
        $dash_path = '/assets/';
        // Use the base URL directly without using env() helper
        return url($dash_path . $path);
    }
}
if (!function_exists('cssVer')) {
    function cssVer()
    {
    //    return '?ver='.config('webconf')['cssversion'];
       return '?ver=2';
    }
}
if (!function_exists('imgVer')) {
    function imgVer()
    {
        // return '?ver='.config('webconf')['imgversion'];
        return '?ver=2';
    }
}
if (!function_exists('jsVer')) {
    function jsVer()
    {
        // return '?ver='.config('webconf')['jsversion'];
        return '?ver=2';
    }
}
