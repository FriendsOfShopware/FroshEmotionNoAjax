<?php

namespace FroshEmotionNoAjax;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FroshEmotionNoAjax extends Plugin
{
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function update(UpdateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        if (!$container->hasParameter('shopware.release.version')) {
            $container->setParameter('shopware.release.version', \Shopware::VERSION);
        }
        if (!$container->hasParameter('frosh_emotion_no_ajax.plugin_dir')) {
            $container->setParameter('frosh_emotion_no_ajax.plugin_dir', $this->getPath());
        }
        parent::build($container);
    }
}
