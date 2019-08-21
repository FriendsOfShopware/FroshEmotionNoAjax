<?php

namespace FroshEmotionNoAjax\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Action;
use Enlight_Controller_ActionEventArgs;

class TemplateSubscriber implements SubscriberInterface
{
    /**
     * @var string
     */
    private $emotionNoAjaxViewDir;

    /**
     * @var string
     */
    private $version;

    /**
     * @var boolean
     */
    private $emotionPreLoading;

    /**
     * @param string $emotionNoAjaxViewDir
     * @param string $version
     */
    public function __construct($emotionNoAjaxViewDir, $version)
    {
        $this->emotionNoAjaxViewDir = $emotionNoAjaxViewDir;
        $this->version = $version;
        $this->emotionPreLoading = true;

        if (version_compare($this->version, '5.6.0', '>=')) {
            $this->emotionPreLoading = false;
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Widgets' => 'addTemplateDir',
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'addTemplateDir',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'onCollectJavascriptFiles',
        ];
    }

    public function addTemplateDir(Enlight_Controller_ActionEventArgs $args)
    {
        if ($this->emotionPreLoading) {
            /** @var Enlight_Controller_Action $controller */
            $controller = $args->get('subject');
            $controller->View()->addTemplateDir($this->emotionNoAjaxViewDir);
        }
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onCollectJavascriptFiles(\Enlight_Event_EventArgs $args)
    {
        $collection = new ArrayCollection();

        if ($this->emotionPreLoading) {
            $collection->add($this->emotionNoAjaxViewDir . '/frontend/_public/js/jquery.emotion.js');
        }

        return $collection;
    }
}
