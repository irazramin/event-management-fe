<div class="event-form">
    <h1 class="event-form__title">Add New Event</h1>
    <form method="POST" action="" class="event-form__body">
        <?php wp_nonce_field('add_event_action', 'add_event_nonce'); ?>

        <div class="event-form__wrapper">
            <div class="event-form__group">
                <label for="event_title" class="event-form__label">Event Title</label>
                <input name="event_title" type="text" id="event_title" class="event-form__input" required />
            </div>

            <div class="event-form__group">
                <label for="event_location" class="event-form__label">Location</label>
                <input name="event_location" type="text" id="event_location" class="event-form__input" required />
            </div>

        </div>

        <div class="event-form__wrapper">
            <div class="event-form__group">
                <label for="event_date" class="event-form__label">Date</label>
                <input name="event_date" type="date" id="event_date" class="event-form__input" required />
            </div>
            <div class="event-form__group">
                <label for="event_category" class="event-form__label">Category</label>
                <select name="event_category" id="event_category" class="event-form__select" required>
                    <option value="">Select a category</option>
                    <option value="Music">Music</option>
                    <option value="Art">Art</option>
                    <option value="Sports">Sports</option>
                    <option value="Technology">Technology</option>
                </select>
            </div>
        </div>

        <div class="event-form__group">
            <label for="event_time" class="event-form__label">Time</label>
            <input name="event_time" type="time" id="event_time" class="event-form__input" required />
        </div>

        <div class="event-form__group">
            <label for="event_description" class="event-form__label">Description</label>
            <textarea name="event_description" id="event_description" class="event-form__textarea" rows="5"
                required></textarea>
        </div>

        <div class="event-form__action-wrapper">
            <?php submit_button('Add Event', 'event-form__button', 'submit_event'); ?>
        </div>
    </form>

    <?php
    // Handle form submission securely
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer('add_event_action', 'add_event_nonce')) {
        $event_data = array(
            'title' => sanitize_text_field($_POST['event_title']),
            'description' => sanitize_textarea_field($_POST['event_description']),
            'date' => sanitize_text_field($_POST['event_date']),
            'time' => sanitize_text_field($_POST['event_time']),
            'location' => sanitize_text_field($_POST['event_location']),
            'category' => sanitize_text_field($_POST['event_category']),
        );

        $result = create_event($event_data);

        if (is_wp_error($result)) {
            echo '<div class="error"><p>' . esc_html($result->get_error_message()) . '</p></div>';
        } else {
            echo '<div class="updated"><p>Event added successfully!</p></div>';
        }
    }
    ?>
</div>