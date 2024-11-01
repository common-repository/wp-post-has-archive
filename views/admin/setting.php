<?php
namespace WP_Post_Has_Archive;
?>
<div class="wrap">
<h1>WP Post Has Archive Setting</h1>

<?php
if (is_wp_error($result)) {
    Functions::display_notice('error', 'Error');
} elseif (!empty($result)) {
    Functions::display_notice('updated', 'Saved. <a href="'.$post_archive_url.'">See post archive page.</a>');
}
?>

<form method="post" action="">
<?php wp_nonce_field(Config::NONCE); ?>

<table class="form-table">
<tr>
<th>Current Post Archive URL</th>
<td>
    <a href="<?php echo $post_archive_url ?>"><?php echo $post_archive_url ?></a>
</td>
</tr>
<tr>
<th>Slug</th>
<td><input name="has_archive" type="text" value="<?php echo esc_html($option['has_archive']) ?>" class="" /></td>
</tr>
</table>

<input type="hidden" name="save_setting" value="1">
<?php submit_button(); ?>
</form>
</div>
