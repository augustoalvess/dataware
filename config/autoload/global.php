<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'max_featured_products' => 8, // Máximo de produtos em destaques.
    'max_banner_images' => 4, // Máximo de imagens para o banner.
    'no_image_path' => '/img/site/sem-imagem.png', // Caminho da imagem de identificação de "sem imagem".
    'upload_image_base_path' => '', // Caminho das imagens para upload
    
    // Dados da empresa contratante do site.
    'site_company_name' => 'METAL ESTRELA IND. & COM. DE FERRAGENS LT',
    'site_company_phone' => '(51) 3712-2244',
    'site_company_contact_email' => 'contato@metalestrela.ind.br',
    'site_company_contact_email_recipient' => 'Contato site Metal Estrela',
    'site_company_state' => 'RS',
    'site_company_city' => 'Estrela',
    'site_company_zipcode' => '95880­000',
    'site_company_neighborhood' => 'Centro',
    'site_company_address' => 'Rua Olinda Mallmann',
    'site_company_number' => '484',
    'site_company_complement' => '',
    
    // Dados da empresa contratada
    'site_employee_phone' => '(51) 9856-1814',
    'site_employee_email' => 'contato@tecnonsistemas.com.br'
);
