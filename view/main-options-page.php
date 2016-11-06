<form name="" action="options.php" method="post">
<?php
    settings_fields( 'custom_cat_main' );
    do_settings_sections(class_main_options_page::PAGE_SLUG);
    submit_button();
?>
</form>
