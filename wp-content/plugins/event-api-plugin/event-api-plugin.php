<?php
/*
Plugin Name: Event Management Plugin
Description: Handles API communication and event management.
Version: 1.0
Author: Iraz Ramin
*/

include_once(plugin_dir_path(__FILE__) . 'includes/api-handler.php');

function my_plugin_enqueue_styles()
{
    wp_enqueue_style('my-plugin-styles', plugin_dir_url(__FILE__) . 'css/my-plugin-styles.css');
}

function my_custom_plugin_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('delete-event', plugin_dir_url(__FILE__) . 'js/delete-event.js', array('jquery'), null, true);
    wp_enqueue_script('view-toggle', plugin_dir_url(__FILE__) . 'js/view-toggle.js', array('jquery'), null, true);

    wp_localize_script('delete-event', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('delete_event_nonce')
    ));
}

add_action('wp_enqueue_scripts', 'my_plugin_enqueue_styles');
add_action('admin_menu', 'my_custom_plugin_menu');
add_action('wp_enqueue_scripts', 'my_custom_plugin_enqueue_scripts');


function event_list_shortcode($atts)
{

    $atts = shortcode_atts(array(
        'category' => '',
        'sort' => 'date',
        'view' => 'grid',
    ), $atts);

    $selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

    $events = fetch_events($selected_category, $atts['sort']);

    if (is_wp_error($events)) {
        return '<p>Error fetching events: ' . esc_html($events->get_error_message()) . '</p>';
    }

    ob_start();

    include(plugin_dir_path(__FILE__) . 'templates/event-list.php');

    return ob_get_clean();
}

function my_custom_plugin_menu()
{
    add_menu_page('Add Event', 'Add Event', 'manage_options', 'add-event', 'my_add_event_page', 'dashicons-calendar', 6);
}

function add_event_shortcode()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/add-event-form.php');
    return ob_get_clean();
}

if (!function_exists('edit_event_shortcode')) {
    function edit_event_shortcode()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_event'])) {

            if (!isset($_POST['edit_event_nonce']) || !wp_verify_nonce($_POST['edit_event_nonce'], 'edit_event_action')) {
                return '<div class="error"><p>Nonce verification failed.</p></div>';
            }

            $data = array(
                'id' => intval($_POST['event_id']),
                'title' => sanitize_text_field($_POST['event_title']),
                'description' => sanitize_textarea_field($_POST['event_description']),
                'date' => sanitize_text_field($_POST['event_date']),
                'time' => sanitize_text_field($_POST['event_time']),
                'location' => sanitize_text_field($_POST['event_location']),
                'category' => sanitize_text_field($_POST['event_category']),
            );

            $result = update_event($data);

            if (is_wp_error($result)) {
                return '<div class="error"><p>' . esc_html($result->get_error_message()) . '</p></div>';
            } else {
                return '
                     <script type="text/javascript">
                            window.location.href = "' . esc_url(home_url()) . '";
                     </script>
                ';
            }
        }

        $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

        if ($event_id <= 0) {
            return '<p>No valid event ID provided.</p>';
        }

        $event = fetch_event_by_id($event_id);

        if (is_wp_error($event)) {
            return '<div class="error"><p>' . esc_html($event->get_error_message()) . '</p></div>';
        }

        ob_start();
        include(plugin_dir_path(__FILE__) . 'templates/edit-event-form.php');
        return ob_get_clean();
    }
}




add_shortcode('event_list', 'event_list_shortcode');
add_shortcode('add_event', 'add_event_shortcode');
add_shortcode('edit_event', 'edit_event_shortcode');


