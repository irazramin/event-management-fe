<div class="event-list-wrapper">
    <div class="event-header">
        <h2 class="section-title">All events</h2>
        <div class="tool-wrapper">
            <div class="event-category-filter">
                <select id="category-filter">
                    <option value="">Select Categories</option>
                    <option value="">All Categories</option>
                    <option value="Music">Music</option>
                    <option value="Art">Art</option>
                    <option value="Sports">Sports</option>
                    <option value="Technology">Technology</option>
                    <option value="Blog">Blog</option>
                </select>
            </div>

            <div class="event-view-toggle">
                <button class="active toggle-button <?php echo esc_attr($atts['view']) === 'grid' ? 'active' : ''; ?>"
                    data-view="grid">
                    <i class="fas fa-th-large"></i>
                </button>
                <button class="toggle-button <?php echo esc_attr($atts['view']) === 'list' ? 'active' : ''; ?>"
                    data-view="list">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="event-list <?php echo esc_attr($atts['view']); ?>">
        <?php if (!empty($events) && is_array($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event-list__item" id="event-<?php echo esc_attr($event['id']); ?>">
                    <div class="event-list__time-block">
                        <p class="event-list__date"><?php echo esc_html($event['date']); ?></p>
                        <p class="event-list__time"><?php echo esc_html($event['time']); ?></p>
                    </div>
                    <div class="event-list__details">
                        <div class="event-list__info">
                            <h2 class="event-list__title"><?php echo esc_html($event['title']); ?></h2>
                            <p class="event-list__description"><?php echo esc_html($event['description']); ?></p>
                            <div class="event-list__wrapper">
                                <p class="event-list__category"> <i class="fas fa-tag"></i>
                                    <?php echo esc_html($event['category']); ?></p>
                                <p class="event-list__category"> <i class="fas fa-map-marker-alt"></i>
                                    <?php echo esc_html($event['location']); ?></p>
                            </div>
                        </div>
                        <div class="event-list__actions">
                            <a href="<?php echo esc_url(add_query_arg('event_id', $event['id'], site_url('edit-event'))); ?>"
                                class="event-list__edit-link"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="" class="event-list__delete-form" style="display:inline;">
                                <?php wp_nonce_field('delete_event_action_' . $event['id'], 'delete_event_nonce'); ?>
                                <input type="hidden" name="event_id" value="<?php echo esc_attr($event['id']); ?>" />

                            </form>
                            <button type="button" class="event-list__delete-button delete-event-button"
                                data-id="<?php echo esc_attr($event['id']); ?>"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="event-list__no-events">No events found</p>
        <?php endif; ?>
    </div>
</div>