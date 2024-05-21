<?php
// Função para verificar atualizações do tema
function check_for_theme_updates($checked_data) {
    if (empty($checked_data->checked)) {
        return $checked_data;
    }

    // Obter dados do tema atual
    $theme_data = wp_get_theme();
    $theme_slug = $theme_data->get_stylesheet(); // Slug do tema atual
    $theme_version = $theme_data->get('Version');

    // URL do repositório GitHub
    $github_url = 'https://api.github.com/repos/manuseiro/lipagpt/releases/latest';

    // Configurar argumentos da requisição HTTP
    $request_args = array(
        'headers' => array(
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'WordPress Theme Update Checker',
            // Descomente a linha abaixo se você precisar de autenticação para um repositório privado
            //'Authorization' => 'token ' . GITHUB_ACCESS_TOKEN,
        ),
    );

    // Fazer a requisição HTTP para o GitHub
    $response = wp_remote_get($github_url, $request_args);

    // Verificar se a resposta é válida
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        return $checked_data;
    }

    $release_data = json_decode(wp_remote_retrieve_body($response));

    // Verificar se há dados de lançamento e se a versão do GitHub é maior que a versão atual do tema
    if (!empty($release_data) && version_compare($release_data->tag_name, $theme_version, '>')) {
        // Adicionar informações de atualização ao $checked_data
        $checked_data->response[$theme_slug] = array(
            'new_version' => $release_data->tag_name,
            'package' => $release_data->zipball_url,
            'url' => $release_data->html_url,
        );
    }

    return $checked_data;
}

// Hook para verificar atualizações de tema
add_filter('pre_set_site_transient_update_themes', 'check_for_theme_updates');

// Adicionar informações adicionais sobre o tema
function theme_api_check($false, $action, $response) {
    if ($action === 'theme_information' && isset($response->slug) && $response->slug === 'azulsolar') {
        $github_url = 'https://api.github.com/repos/manuseiro/lipagpt/releases/latest';
        $request_args = array(
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'WordPress Theme Update Checker',
                // Descomente a linha abaixo se você precisar de autenticação para um repositório privado
                //'Authorization' => 'token ' . GITHUB_ACCESS_TOKEN,
            ),
        );

        $response = wp_remote_get($github_url, $request_args);

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return false;
        }

        $release_data = json_decode(wp_remote_retrieve_body($response));
        if (!empty($release_data)) {
            $response = (object) array(
                'slug' => 'lipagpt',
                'name' => 'LipaGPT',
                'version' => $release_data->tag_name,
                'author' => 'Manuseiro',
                'requires' => '5.0', // Versão mínima do WordPress
                'tested' => '5.9', // Última versão do WordPress testada
                'requires_php' => '7.0', // Versão mínima do PHP
                'download_link' => $release_data->zipball_url,
                'sections' => array(
                    'description' => 'Teste de Tema',
                    'changelog' => 'Notas da versão do tema.',
                ),
            );
        }
    }

    return $response;
}

// Hook para adicionar informações adicionais sobre o tema
add_filter('themes_api', 'theme_api_check', 10, 3);
?>
