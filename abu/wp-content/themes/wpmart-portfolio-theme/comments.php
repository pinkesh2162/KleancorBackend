<?php
if (post_password_required()) {
    return;
}
?>
<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            printf(
                _nx('One comment', '%1$s comments', get_comments_number(), 'comments title'),
                number_format_i18n(get_comments_number())
            );
            ?>
        </h2>

        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'short_ping' => true,
            ));
            ?>
        </ul>

    <?php endif; ?>

    <?php comment_form(); ?>
</div>
