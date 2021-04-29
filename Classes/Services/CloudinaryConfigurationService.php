<?php

/*
 * This file is part of the Visol/Cloudinary project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

namespace Visol\Cloudinary\Services;


/**
 * Class CloudinaryConfigurationService
 */
class CloudinaryConfigurationService
{

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @var array
     */
    protected $fileConfiguration;

    /**
     * @var array
     */
    protected $environmentVariableMappings = [
        'cloudName' => 'CLOUDINARY_CLOUD_NAME',
        'apiKey' => 'CLOUDINARY_API_KEY',
        'apiSecret' => 'CLOUDINARY_API_SECRET',
        'timeout' => 'CLOUDINARY_TIMEOUT',
    ];

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;

        $configurationFile = trim($this->configuration['configurationFile']);
        if ($configurationFile && file_exists($configurationFile)) {
            $this->fileConfiguration = (array)json_decode(
                file_get_contents($configurationFile),
                true
            );
        }
    }

    /**
     * @return array
     */
    public function getFinalConfiguration()
    {
        return [
            'cloud_name' => $this->get('cloudName'),
            'api_key' => $this->get('apiKey'),
            'api_secret' => $this->get('apiSecret'),
            'timeout' => $this->get('timeout'),
            'secure' => true
        ];
    }

    /**
     * @return bool
     */
    public function hasConfigurationFile(): bool
    {
        return trim($this->configuration['configurationFile']) !== '';
    }

    /**
     * @return bool
     */
    public function configurationFileExists(): bool
    {
        $configurationFile = trim($this->configuration['configurationFile']);
        return file_exists($configurationFile);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function get(string $key): string
    {
        $value = $this->configuration[$key];
        if (isset($this->fileConfiguration[$key])) {
            $value = $this->fileConfiguration[$key];
        } elseif (getenv($this->environmentVariableMappings[$key])) {
            $value = getenv($this->environmentVariableMappings[$key]);
        }
        return (string)$value;
    }
}
