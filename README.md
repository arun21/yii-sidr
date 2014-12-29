#yii-sidr
This is a Yii Widget for the Sidr JQuery plugin

This is a Yii Widget for the Sidr JQuery plugin. This plugin enables you to build slide-out menus like JPanel, but for either or both sides of the browser. Also supports touch via the TouchSwipe JQuery plugin.
Requirements

Yii 1.1 or above

##Usage
Copy to your extensions directory, then use like so:
```php
$this->widget('ext.yii-sidr.YiiSidr', array(
    'enableTouch'=>false, //optional: enable swipe control on touch devices
    'touchSelector'=>'.body', //optional: swipe selector
    'theme'=>'dark',
    'sidrs'=>array(
        array(
            'btnName'=>'#leftNavBtn',
            'name'=>'leftNav',
            'side'=>'left',
            'speed: //optional: A string or number determining how long the animation will run.
            'source: //optional: A jQuery selector, an url or a callback function.
            'renaming: //optional: When filling the sidr with existing content, choose to rename or not the classes and ids.
            'body: //optional: For doing the page movement the 'body' element is animated by default, you can select another element to animate with this option.
            'displace: //optional: Displace the body content or not.
            'onOpen: function() {} //optional: Callback that will be executed on open.
            'onClose: function() {} //optional: Callback that will be executed on close.
        ),
        array(
            'btnName'=>'#rightNavBtn',
            'name'=>'rightNav',
            'side'=>'right',
        ),
    )
));
```
##Resources
* Sidr JQuery plugin (http://www.berriart.com/sidr/)
* TouchSwipe JQuery plugin (https://github.com/mattbryson/TouchSwipe-Jquery-Plugin)
