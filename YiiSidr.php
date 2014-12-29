<?php
/**
 * Created by PhpStorm.
 * User: mckracken83
 * Date: 12/28/14
 * Time: 8:03 PM
 */

/**
 * Class QuoteCarousel
 */
class YiiSidr extends CWidget
{
    /**
     * Widget options overwrite default available options
     * @var array
     */
    public $options = array();

    /**
     * @var array default options
     */
    public static $defaultOptions = array('debug' => YII_DEBUG);

    public $assets;
    public $sidrs;
    public $sidrScript;
    public $touchScript;
    public $enableTouch = false;
    public $touchSelector;
    public $theme;

    public function init()
    {
        $assetsDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $this->assets = Yii::app()->assetManager->publish($assetsDir);

        $this->registerClientScript();
    }

    /**
     * Register CSS and scripts.
     */
    protected function registerClientScript()
    {
        $cs = Yii::app()->clientScript;

        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($this->assets.'/sidr/jquery.sidr.min.js', CClientScript::POS_END);
        if($this->enableTouch) $cs->registerScriptFile($this->assets.'/touchswipe/jquery.touchSwipe.min.js', CClientScript::POS_END);

        $this->theme=='dark' ?
            $cs->registerCssFile($this->assets.'/sidr/stylesheets/jquery.sidr.dark.css') :
            $cs->registerCssFile($this->assets.'/sidr/stylesheets/jquery.sidr.light.css');

        foreach($this->sidrs as $sidr) {
            $this->sidrScript .= '$(\''.$sidr['btnName'].'\').sidr({';
            $this->sidrScript .=    'name: \''.$sidr['name'].'\',';
            $this->sidrScript .=    'side: \''.$sidr['side'].'\',';
            if($sidr['speed']) $this->sidrScript .=    'speed: \''.$sidr['speed'].'\',';
            if($sidr['source']) $this->sidrScript .=    'source: \''.$sidr['source'].'\',';
            if($sidr['renaming']) $this->sidrScript .=    'renaming: \''.$sidr['renaming'].'\',';
            if($sidr['body']) $this->sidrScript .=    'body: \''.$sidr['body'].'\',';
            if($sidr['displace']) $this->sidrScript .=    'displace: \''.$sidr['displace'].'\',';
            if($sidr['onOpen']) $this->sidrScript .=    'onOpen: \''.$sidr['onOpen'].'\',';
            if($sidr['onClose']) $this->sidrScript .=    'onClose: \''.$sidr['onClose'].'\',';
            $this->sidrScript .= '});';
        }

        $cs->registerScript('sidrScript', $this->sidrScript, CClientScript::POS_READY);

        if($this->enableTouch) {
            foreach($this->sidrs as $sidr) {
                $this->touchScript .= $sidr->body ? '$("'.$sidr->body.'").swipe({' : '$("'.$this->touchSelector.'").swipe({';

                $sidr->side == 'right' ?
                    $this->touchScript .= 'swipeLeft: function(event, direction, distance, duration, fingerCount) {
                            if(direction=="left") {
                                $.sidr(\'open\', \''.$sidr->name.'\');
                            } else {
                                $.sidr(\'close\', \''.$sidr->name.'\');
                            }
                        },' :
                    $this->touchScript .= 'swipeRight: function(event, direction, distance, duration, fingerCount) {
                            if(direction=="right") {
                                $.sidr(\'open\', \''.$sidr->name.'\');
                            } else {
                                $.sidr(\'close\', \''.$sidr->name.'\');
                            }
                        },';
            }

            $this->touchScript .= ' });';

            $cs->registerScript('sidrTouchSwipe', $this->touchScript, CClientScript::POS_READY);
        }
    }

    /** Render Widget */
    public function run()
    {
        foreach($this->sidrs as $sidr) {
            echo '<div id="'.$sidr['name'].'"></div>';
        }
    }
}