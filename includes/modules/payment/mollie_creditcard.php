<?php

use Mollie\Gambio\Utility\PathProvider;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_ccard
 */
class mollie_creditcard extends mollie
{
    public $title = 'Credit card';

    /**
     * @inheritDoc
     * @return string[][]
     */
    public function _configuration()
    {
        $config = parent::_configuration();
        $config['COMPONENTS_STATUS'] = [
            'configuration_value' => 'True',
            'set_function' => 'gm_cfg_select_option(array(\'True\', \'False\'), ',
        ];

        return $config;
    }

    /**
     * @return array|bool
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     */
    public function selection()
    {
        $selection = parent::selection();
        if (!$selection) {
            return false;
        }

        $configKey = $this->_formatKey('COMPONENTS_STATUS');
        if (@constant($configKey) === 'True') {
            $selection['fields'] = [
                [
                    'title' => $this->_renderCreditCardInfo(),
                    'field' => '',
                ]
            ];
        }

        return $selection;
    }

    /**
     * @return string|string[]
     * @throws Exception
     */
    private function _renderCreditCardInfo()
    {
        /** @var \Mollie\Gambio\Services\Business\ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $template = PathProvider::getShopTemplatePath('mollie_credit_card.html');

        return mollie_render_template(
            $template,
            [
                'profile_id' => $configService->getWebsiteProfile()->getId(),
                'test_mode' => $configService->isTestMode(),
            ]
        );
    }
}