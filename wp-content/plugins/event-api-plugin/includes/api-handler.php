<?php

function fetch_events($category = '', $sort = 'date') {

     $category = trim($category);

     error_log('Trimmed category provided: ' . var_export($category, true));
 
     $url = 'http://127.0.0.1:8000/api/v1/events';
 
     if (!empty($category)) {
         $url .= '/category/' . urlencode($category);
     } else {
         error_log('No category provided, fetching all events.');
     }

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Unable to fetch events: ' . $response->get_error_message());
    }

    $body = wp_remote_retrieve_body($response);

    $data = json_decode($body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('json_error', 'Invalid JSON response: ' . json_last_error_msg());
    }

    if (!is_array($data)) {
        return new WP_Error('data_error', 'Expected an array, received: ' . print_r($data, true));
    }

    return $data;
}

function create_event($data) {
    $response = wp_remote_post('http://127.0.0.1:8000/api/v1/events', array(
        'body' => json_encode($data),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    ));

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Unable to create event: ' . $response->get_error_message());
    }

    return json_decode(wp_remote_retrieve_body($response), true);
}

function fetch_event_by_id($id) {
    $url = 'http://127.0.0.1:8000/api/v1/events/' . intval($id);

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        error_log('API Error: ' . $response->get_error_message());
        return new WP_Error('api_error', 'Unable to fetch event: ' . $response->get_error_message());
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('JSON Error: ' . json_last_error_msg());
        return new WP_Error('json_error', 'Invalid JSON response: ' . json_last_error_msg());
    }

    error_log('Fetched Event Data: ' . print_r($data, true));

    return $data;
}

function update_event($data) {
    error_log('Incoming data: ' . print_r($data, true));

    if (empty($data['id']) || empty($data['title'])) {
        return new WP_Error('validation_error', 'Event ID and Title are required.');
    }

    $url = 'http://127.0.0.1:8000/api/v1/events/' . intval($data['id']);
    $body = json_encode(array(
        'title' => $data['title'],
        'description' => $data['description'],
        'date' => $data['date'],
        'time' => $data['time'],
        'location' => $data['location'],
        'category' => $data['category'],
    ));

    error_log('Request Body: ' . $body);

    $response = wp_remote_request($url, array(
        'method' => 'PUT', 
        'body' => $body,
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    ));

    if (is_wp_error($response)) {
        error_log('API Error: ' . $response->get_error_message());
        return new WP_Error('api_error', 'Unable to update event: ' . $response->get_error_message());
    }

    $status_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    error_log('Response Code: ' . $status_code);
    error_log('Response Body: ' . $response_body);

    if ($status_code !== 200 && $status_code !== 204) {
        return new WP_Error('api_error', 'Update failed with status code: ' . $status_code . ' and body: ' . $response_body);
    }

    return json_decode($response_body, true);
}

function delete_event($event_id) {
    $url = 'http://127.0.0.1:8000/api/v1/events/' . intval($event_id);

    $response = wp_remote_request($url, array(
        'method' => 'DELETE',
        'headers' => array('Content-Type' => 'application/json'),
    ));

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Unable to delete event: ' . $response->get_error_message());
    }

    $status_code = wp_remote_retrieve_response_code($response);
    if ($status_code !== 200 && $status_code !== 204) {
        $body = wp_remote_retrieve_body($response);
        return new WP_Error('api_error', 'Delete failed with status code: ' . $status_code);
    }

    return true;
}

function handle_ajax_delete_event() {
    check_ajax_referer('delete_event_nonce', 'nonce');

    $current_user = wp_get_current_user();
    error_log('Current user: ' . $current_user->user_login);
    error_log('User roles: ' . implode(', ', $current_user->roles));

    if (!current_user_can('delete_events')) {
        wp_send_json_error('You do not have permission to delete events.');
        wp_die();
    }

    $event_id = intval($_POST['event_id']);
    $delete_result = delete_event($event_id);

    if (is_wp_error($delete_result)) {
        wp_send_json_error($delete_result->get_error_message());
    } else {
        wp_send_json_success();
    }

    wp_die();
}
function add_event_capabilities() {
    $role = get_role('administrator'); 
    if ($role) {
        $role->add_cap('delete_events');
    }
}
add_action('admin_init', 'add_event_capabilities');
add_action('wp_ajax_delete_event', 'handle_ajax_delete_event');