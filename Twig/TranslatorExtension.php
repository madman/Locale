<?php

namespace FDevs\Locale\Twig;

use Doctrine\Common\Collections\Collection;
use FDevs\Locale\Util\ChoiceText;

class TranslatorExtension extends \Twig_Extension
{
    /** @var array */
    private $twigExtensions = [];

    /** @var string */
    private $defaultLocale = '';

    /**
     * init
     *
     * @param array  $twigExtensions
     * @param string $defaultLocale
     */
    public function __construct(array $twigExtensions = [], $defaultLocale = '')
    {
        $this->twigExtensions = $twigExtensions;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                't',
                [$this, 'trans'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    /**
     * translate Collection
     *
     * @param |FDevs\Locale\Model\LocaleText[]|string $data
     * @param string $locale
     *
     * @return string
     */
    public function trans(\Twig_Environment $env, $data, $locale = '')
    {
        if ($data instanceof Collection) {
            $twig = new \Twig_Environment(new \Twig_Loader_String());
            foreach ($this->twigExtensions as $ext) {
                if (!$ext instanceof \Twig_ExtensionInterface) {
                    $ext = $env->getExtension($ext);
                }
                $twig->addExtension($ext);
            }

            $data = $twig->render(ChoiceText::getTextByCollection($data, $locale ?: $this->getDefaultLocale()));
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'translator_extension';
    }

    /**
     * get Default Locale
     *
     * @return string
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * set Default Locale
     *
     * @param string $defaultLocale
     *
     * @return $this
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;

        return $this;
    }
}
