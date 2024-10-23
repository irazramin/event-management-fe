<div class="event-form">
    <h1 class="event-form__title">Edit Event</h1>
    <form method="POST" action="" class="event-form__body">
        <?php wp_nonce_field('edit_event_action', 'edit_event_nonce'); ?>

        <input type="hidden" name="event_id" value="<?php echo esc_attr($event['id'] ?? ''); ?>" />

        <div class="event-form__wrapper">
            <div class="event-form__group">
                <label for="event_title" class="event-form__label">Event Title</label>
                <input name="event_title" type="text" id="event_title" class="event-form__input"
                    value="<?php echo esc_attr($event['title'] ?? ''); ?>" required />
            </div>

            <div class="event-form__group">
                <label for="event_location" class="event-form__label">Location</label>
                <input name="event_location" type="text" id="event_location" class="event-form__input"
                    value="<?php echo esc_attr($event['location'] ?? ''); ?>" required />
            </div>
        </div>

        <div class="event-form__wrapper">
            <div class="event-form__group">
                <label for="event_date" class="event-form__label">Date</label>
                <input name="event_date" type="date" id="event_date" class="event-form__input"
                    value="<?php echo esc_attr($event['date'] ?? ''); ?>" required />
            </div>

            <div class="event-form__group">
                <label for="event_category" class="event-form__label">Category</label>
                <select name="event_category" id="event_category" class="event-form__select"
                    value="<?php echo esc_attr($event['category'] ?? ''); ?>" required>
                    <option value="">Select a category</option>
                    <option value="Music" <?php selected($event['category'] ?? '', 'Music'); ?>>Music</option>
                    <option value="Art" <?php selected($event['category'] ?? '', 'Art'); ?>>Art</option>
                    <option value="Sports" <?php selected($event['category'] ?? '', 'Sports'); ?>>Sports</option>
                    <option value="Technology" <?php selected($event['category'] ?? '', 'Technology'); ?>>Technology
                    </option>
                </select>
            </div>
        </div>

        <div class="event-form__group">
            <label for="event_time" class="event-form__label">Time</label>
            <input name="event_time" type="time" id="event_time" class="event-form__input"
                value="<?php echo esc_attr($event['time'] ?? ''); ?>" required />
        </div>

        <div class="event-form__group">
            <label for="event_description" class="event-form__label">Description</label>
            <textarea name="event_description" id="event_description" class="event-form__textarea" rows="5"
                required><?php echo esc_textarea($event['description'] ?? ''); ?></textarea>
        </div>

        <div class="event-form__action-wrapper">
            <?php submit_button('Update Event', 'event-form__button', 'submit_event'); ?>
        </div>
    </form>
</div>