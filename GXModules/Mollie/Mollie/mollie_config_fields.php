<?php

use Mollie\Gambio\Entity\Repository\CountryRepository;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;

/**
 * Renders issuer list select element
 *
 * @param string $key_value
 * @param string $key
 *
 * @return string|string[]
 * @throws Exception
 */
function mollie_issuer_list_select($key_value, $key = '')
{
    $templatePath = PathProvider::getAdminTemplatePath('mollie_issuer_list_select.html', 'ConfigFields');
    $data         = [
        'key'   => $key,
        'value' => $key_value,
    ];

    return mollie_render_template($templatePath, $data);
}

/**
 * Renders img element
 *
 * @param string $code
 * @param string $src
 *
 * @return string|string[]
 * @throws Exception
 */
function mollie_get_payment_logo($code, $src)
{
    $templatePath = PathProvider::getAdminTemplatePath('mollie_payment_logo.html', 'ConfigFields');
    $data         = [
        'code'     => $code,
        'logo_src' => $src,
    ];

    return mollie_render_template($templatePath, $data);
}

/**
 * @param        $key_value
 * @param string $key
 *
 * @return string|string[]
 * @throws Exception
 */
function mollie_api_select($key_value, $key = '')
{
    $templatePath = PathProvider::getAdminTemplatePath('mollie_api_select.html', 'ConfigFields');
    $data         = [
        'key'   => $key,
        'value' => $key_value,
    ];

    return mollie_render_template($templatePath, $data);
}

/**
 * @param        $key_value
 * @param string $key
 *
 * @return string|string[]
 * @throws Exception
 */
function mollie_multi_language_text($key_value, $key = '')
{
    $data         = [];
    $templatePath = PathProvider::getAdminTemplatePath('multi_lang_field.html', 'ConfigFields');

    foreach (xtc_get_languages() as $language) {
        $langKey                 = $key . '_' . strtoupper($language['code']);
        $value                   = stripslashes(@constant($langKey));
        $data['lang_specific'][] = [
            'lang_key'   => $langKey,
            'lang_value' => $value,
            'image'      => DIR_WS_LANGUAGES . $language['directory'] . '/admin/images/' . $language['image'],
        ];
    }

    $currentLang              = strtoupper($_SESSION['language_code']);
    $data['default_value']    = stripslashes(@constant($key . '_' . $currentLang));
    $data['key']              = $key;
    $data['current_lang_key'] = $key . '_' . $currentLang;

    return mollie_render_template($templatePath, $data);
}

/**
 * @param        $key_value
 * @param string $key
 *
 * @return string|string[]
 * @throws Exception
 */
function mollie_multi_select_countries($key_value, $key = '')
{
    $data              = [];
    $countryRepository = new CountryRepository();
    $enabledCountries  = $countryRepository->getEnabledCountries();
    $selectedCountries = array_map('trim', explode(',', $key_value));
    /** @var LanguageTextManager $translator */
    $translator = MainFactory::create_object('LanguageTextManager', ['countries', $_SESSION['languages_id']]);
    foreach ($enabledCountries as $country) {
        $data['countries'][] = [
            'code'               => $country['countries_iso_code_2'],
            'name'               => $translator->get_text($country['countries_iso_code_2']),
            'selected_countries' => $selectedCountries,
        ];

    }

    $data['key']  = $key;
    $templatePath = PathProvider::getAdminTemplatePath('mollie_zones_multiple.html', 'ConfigFields');

    return mollie_render_template($templatePath, $data);
}

/**
 * @param        $key_value
 * @param string $key
 *
 * @return string
 */
function mollie_logo_upload($key_value, $key = '')
{

    $existingImgSrc = @constant($key);
    if (empty($existingImgSrc)) {
        $existingImgSrc = '/images/icons/payment/mollie_creditcard.png';
    }

    $templatePath = PathProvider::getAdminTemplatePath('mollie_logo_upload.html', 'ConfigFields');
    $data         = [
        'file_upload_url' => UrlProvider::generateAdminUrl('admin.php', 'MollieFileUpload'),
        'image_src'       => $existingImgSrc,
        'key'             => $key,
        'value'           => $key_value,
    ];

    return mollie_render_template($templatePath, $data);
}

/**
 * @param string $path
 * @param array  $data
 *
 * @return string|string[]
 * @throws Exception
 */
function mollie_render_template($path, $data = [])
{
    $data['css_admin'] = UrlProvider::getPluginCssUrl('');
    $data['js_admin']  = UrlProvider::getPluginJavascriptUrl('');
    /** @var ContentView $contentView */
    $contentView = MainFactory::create('ContentView');
    $contentView->set_template_dir(dirname($path));
    $contentView->set_content_template(basename($path));
    $contentView->set_flat_assigns(true);
    $contentView->set_caching_enabled(false);
    $contentView->set_content_data('mollie', $data);

    return $contentView->get_html();
}