<?php

// require_once "vendor/autoload.php";
define("APP_PATH", realpath(dirname(__FILE__).'/../../apps/ApiDemos-debug.apk'));
if (!APP_PATH) {
    die("App did not exist!");
}
require_once('PHPUnit/Extensions/AppiumTestCase.php');

class ContextTests extends PHPUnit_Extensions_AppiumTestCase
{
    public function testFindByAndroidUIAutomator()
    {
        $el = $this->byAndroidUIAutomator('new UiSelector().description("Animation")');
        $this->assertNotNull($el);
    }

    public function testFindByAccessibilityId()
    {
        $el = $this->byAccessibilityId('Animation');
        $this->assertNotNull($el);
    }

    public static $browsers = array(
        array(
            'local' => true,
            'port' => 4723,
            'browserName' => '',
            'desiredCapabilities' => array(
                'app' => APP_PATH
            )
        )
    );
}
