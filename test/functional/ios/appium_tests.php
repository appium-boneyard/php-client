<?php

// require_once "vendor/autoload.php";
define("APP_PATH", realpath(dirname(__FILE__).'/../../apps/UICatalog.app.zip'));
if (!APP_PATH) {
    die("App did not exist!");
}
require_once('PHPUnit/Extensions/AppiumTestCase.php');

class AppiumTests extends PHPUnit_Extensions_AppiumTestCase
{
    public function testSetImmediateValue()
    {
        $this->byAccessibilityId('Uses of UITextField')->click();
        $el = $this->byClassName('XCUIElementTypeTextField');
        $el->click();

        $el->setImmediateValue('Testing');

        $this->assertEquals('Testing', $el->text());
    }

    public function testLock()
    {
        $el = $this->byId('ButtonsExplain');
        $this->assertNotNull($el);
        $this->lock(1);
        try {
            $this->byId('ButtonsExplain');
        } catch (Exception $e) {
            // we should not be able to find this anymore
        }
        sleep(10);
    }

    public function testShake()
    {
        $this->shake();
    }

    public function testTouchId()
    {
        $this->touchId(true);
        $this->touchId(false);
    }

    public function testToggleTouchIdEnrollment() {
        $this->toggleTouchIdEnrollment();
    }

    public function testHideKeyboard()
    {
        $this->byName('Uses of UITextField')->click();

        # get focus on text field, so keyboard comes up
        $el = $this->byClassName('UIATextField');
        $el->value('Testing');

        $keyboard = $this->byClassName('UIAKeyboard');
        $this->assertTrue($keyboard->displayed());

        $this->hideKeyboard(array(
            'keyName' => 'Done'
        ));

        $this->assertFalse($keyboard->displayed());
    }

    public function testHideKeyboardPressKeyStrategy()
    {
        $this->byName('TextFields, Uses of UITextField')->click();

        # get focus on text field, so keyboard comes up
        $el = $this->byClassName('UIATextField');
        $el->value('Testing');

        $keyboard = $this->byClassName('UIAKeyboard');
        $this->assertTrue($keyboard->displayed());

        $this->hideKeyboard(array(
            'strategy' => 'pressKey',
            'key' => 'Done'
        ));

        $this->assertFalse($keyboard->displayed());
    }

    public function testHideKeyboardNoKeyname()
    {
        $this->byName('Uses of UITextField')->click();

        # get focus on text field, so keyboard comes up
        $el = $this->byClassName('XCUIElementTypeTextField');
        $el->value('Testing');

        $keyboard = $this->byClassName('XCUIElementTypeKeyboard');
        $this->assertTrue($keyboard->displayed());

        $this->hideKeyboard();

        // currently fails
        $this->assertFalse($keyboard->displayed());
    }


    public function testGetDeviceTime()
    {
        $this->getDeviceTime();
    }

    public static $browsers = array(
        array(
            'local' => true,
            'port' => 4723,
            'browserName' => '',
            'desiredCapabilities' => array(
                'app' => APP_PATH,
                'platformName' => 'iOS',
                'platformVersion' => '10.2',
                'deviceName' => 'iPhone Simulator',
                'allowTouchIdEnroll' => True
            )
        )
    );
}
