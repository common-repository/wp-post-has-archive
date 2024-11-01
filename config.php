<?php
namespace WP_Post_Has_Archive;
class Config
{
    const MODE = 'PRD'; // PRD, STG, DEV
    const NAME = 'WP Post has archive';
    const SLUG = 'post-has-archive';
    const TEXT_DOMAIN = 'post-has-archive';
    const OPTION = 'post-has-archive';
    const NONCE = 'post-has-archive';
    const DEFAULT_OPTION = array(
        'has_archive' => 'archives',
    );

    public static function plugin_url(){
        return plugin_dir_url(__FILE__);
    }

    public static function plugin_dir(){
        return plugin_dir_path(__FILE__);
    }
}
