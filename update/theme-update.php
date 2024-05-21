<?php
function check_for_theme_updates($checked_data) {
    // Adicione log para início da verificação de atualização
    error_log('Checking for theme updates...');

    if (empty($checked_data->checked)) {
        return $checked_data;
    }

    $theme_data = wp_get_theme();
    $theme_slug = $theme_data->get_stylesheet(); 
    $theme_version = $theme_data->get('Version');

    // Log a versão atual do tema
    error_log('Current theme version: ' . $theme_version);

    $github_url = 'https://api.github.com/repos/manuseiro/lipagpt/releases/latest';
    $request_args = array(
        'headers' => array(
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'WordPress Theme Update Checker',
        ),
    );

    $response = wp_remote_get($github_url, $request_args);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        error_log('Error fetching release data from GitHub');
        return $checked_data;
    }

    $release_data = json_decode(wp_remote_retrieve_body($response));

    if (!empty($release_data)) {
        // Log a versão da release do GitHub
        error_log('GitHub release version: ' . $release_data->tag_name);
    }

    if (!empty($release_data) && version_compare($release_data->tag_name, $theme_version, '>')) {
        $checked_data->response[$theme_slug] = array(
            'new_version' => $release_data->tag_name,
            'package' => $release_data->zipball_url,
            'url' => $release_data->html_url,
        );
    }

    return $checked_data;
}

add_filter('pre_set_site_transient_update_themes', 'check_for_theme_updates');

function theme_api_check($false, $action, $response) {
    if ($action === 'theme_information' && isset($response->slug) && $response->slug === 'lipagpt') {
        $github_url = 'https://api.github.com/repos/manuseiro/lipagpt/releases/latest';
        $request_args = array(
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'WordPress Theme Update Checker',
            ),
        );

        $response = wp_remote_get($github_url, $request_args);

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            error_log('Error fetching theme information from GitHub');
            return false;
        }

        $release_data = json_decode(wp_remote_retrieve_body($response));
        if (!empty($release_data)) {
            // Log a versão da release do GitHub
            error_log('GitHub release version (theme info): ' . $release_data->tag_name);
            
            $response = (object) array(
                'slug' => 'lipagpt',
                'name' => 'LipaGPT',
                'version' => $release_data->tag_name,
                'author' => 'manuseiro',
                'requires' => '5.0', 
                'tested' => '5.9',
                'requires_php' => '7.0',
                'download_link' => $release_data->zipball_url,
                'sections' => array(
                    'description' => 'Descrição do Tema.',
                    'changelog' => 'Notas da versão do tema.',
                ),
            );
        }
    }

    return $response;
}

add_filter('themes_api', 'theme_api_check', 10, 3);
