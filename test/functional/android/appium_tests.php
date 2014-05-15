<?php

// require_once "vendor/autoload.php";
define("APP_PATH", realpath(dirname(__FILE__).'/../../apps/ApiDemos-debug.apk'));
if (!APP_PATH) {
    die("App did not exist!");
}
require_once('PHPUnit/Extensions/AppiumTestCase.php');

class AppiumTests extends PHPUnit_Extensions_AppiumTestCase
{
    public function testAppReset()
    {
        $this->byAccessibilityId('App')->click();

        $this->reset();
        sleep(5);

        $el = $this->byAccessibilityId('App');
        $this->assertNotNull($el);
    }

    public function testAppStrings()
    {
        $strings = $this->appStrings();
        $this->assertEquals('You can\'t wipe my data, you are a monkey!', $strings['monkey_wipe_data']);
    }

    public function testAppStringsNonDefault()
    {
        $strings = $this->appStrings("en");
        $this->assertEquals('You can\'t wipe my data, you are a monkey!', $strings['monkey_wipe_data']);
    }

    public function testKeyEvent()
    {
        $this->byAccessibilityId('App')->click();
        $this->keyEvent(4);
        sleep(1);

        $el = $this->byAccessibilityId('App');
        $this->assertNotNull($el);
    }

    public function testCurrentActivity()
    {
        $activity = $this->currentActivity();
        $this->assertEquals(".ApiDemos", $activity);
    }

    public function testPullFile()
    {
        $data = $this->pullFile('data/local/tmp/strings.json');
        $strings = json_decode(base64_decode($data), true);
        $this->assertEquals('You can\'t wipe my data, you are a monkey!', $strings['monkey_wipe_data']);
    }

    public function testPushFile()
    {
        $path = 'data/local/tmp/test_push_file.txt';
        $data = 'This is the contents of the file to push to the device.';
        $this->pushFile($path, base64_encode($data));

        $data_ret = base64_decode($this->pullFile($path));
        $this->assertEquals($data, $data_ret);
    }

    public function testBackgroundApp()
    {
        $this->backgroundApp(1);
        try {
            $el = $this->byName('Animation');
            $this->assertNull($el);
        } catch (Exception $e) {
            // we expect this
        }

        sleep(5);

        $el = $this->byName('Animation');
        $this->assertEquals('Animation', $el->text());
    }

    public function testIsAppInstalled()
    {
        $this->assertFalse($this->isAppInstalled('sdfsdf'));
        $this->assertTrue($this->isAppInstalled('com.example.android.apis'));
    }

    // this fails for some reason
    public function testInstallApp()
    {
        $this->assertFalse($this->isAppInstalled('io.selendroid.testapp'));
        $this->installApp('/Users/isaac/code/python-client/test/apps/selendroid-test-app.apk');
        $this->assertTrue($this->isAppInstalled('io.selendroid.testapp'));
    }

    public function testRemoveApp()
    {
        $this->assertTrue($this->isAppInstalled('com.example.android.apis'));
        $this->removeApp('com.example.android.apis');
        $this->assertFalse($this->isAppInstalled('com.example.android.apis'));
    }

    public function testCloseAndLaunchApp()
    {
        $el = $this->byName('Animation');
        $this->assertNotNull($el);

        $this->closeApp();

        $this->launchApp();

        $el = $this->byName('Animation');
        $this->assertNotNull($el);
    }

    public function testComplexFind()
    {
        $el = $this->complexFind([[[2, 'Ani']]]);
        $this->assertEquals('Animation', $el->text());
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
