<?php
// Obter Informações do Tema
function get_theme_info_from_github( $github_username, $repository_name ) {
    $api_url = 'https://api.github.com/repos/' . $github_username . '/' . $repository_name . '/releases/latest';

    $response = wp_remote_get( $api_url, array(
        'headers' => array(
            'User-Agent' => 'WordPress Theme Update Checker',
        ),
    ));

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $data = json_decode( wp_remote_retrieve_body( $response ) );

    if ( ! $data ) {
        return false;
    }

    return [
        'version' => $data->tag_name,
        'download_url' => $data->zipball_url,
    ];
}

// Verificar Atualização Disponível
function check_for_theme_update( $current_version, $theme_info ) {
    if ( ! $theme_info ) {
        return false;
    }

    if ( version_compare( $current_version, $theme_info['version'], '<' ) ) {
        return $theme_info;
    }

    return false;
}

// Função para deletar um diretório
function delete_directory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

// Baixar e Instalar Atualização
function download_and_install_theme_update( $theme_info ) {
    if ( ! $theme_info ) {
        return false;
    }

    $temp_file = download_url( $theme_info['download_url'] );

    if ( is_wp_error( $temp_file ) ) {
        return false;
    }

    $theme_dir = get_template_directory();
    $temp_dir = WP_CONTENT_DIR . '/tmp';

    // Criar diretório temporário se não existir
    if (!file_exists($temp_dir)) {
        mkdir($temp_dir, 0755, true);
    }

    $result = unzip_file( $temp_file, $temp_dir );

    // Excluir arquivo temporário
    unlink($temp_file);

    if ( is_wp_error( $result ) ) {
        return false;
    }

    // Remover arquivos e pastas existentes do tema atual
    delete_directory( $theme_dir );

    // Mover os arquivos extraídos para o diretório do tema
    rename($temp_dir . '/' . basename($theme_dir), $theme_dir);

    // Atualizar versão do tema
    update_option( 'theme_version', $theme_info['version'] );

    return true;
}

function update_theme_from_github( $github_username, $repository_name ) {
    $current_version = wp_get_theme()->get('Version');
    $theme_info = get_theme_info_from_github( $github_username, $repository_name );

    $update_available = check_for_theme_update( $current_version, $theme_info );

    if ( $update_available ) {
        if ( download_and_install_theme_update( $update_available ) ) {
            return 'Tema atualizado com sucesso para a versão ' . $update_available['version'] . '.';
        } else {
            return 'Falha na atualização do tema.';
        }
    } else {
        return 'Nenhuma atualização disponível.';
    }
}

// Função para adicionar logging
function debug_theme_update_process( $message ) {
    if ( defined('WP_DEBUG') && WP_DEBUG ) {
        error_log( $message );
    }
}

// Exemplo de uso
debug_theme_update_process( update_theme_from_github( 'manuseiro', 'lipagpt' ) );
?>
