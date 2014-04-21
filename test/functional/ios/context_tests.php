<?php

// require_once "vendor/autoload.php";
define("APP_PATH", realpath(dirname(__FILE__).'/../../apps/TestApp.app.zip'));
if (!APP_PATH) {
    die("App did not exist!");
}
require_once('PHPUnit/Extensions/AppiumTestCase.php');

class ContextTests extends PHPUnit_Extensions_AppiumTestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://www.example.com/');
    }

    public function testCurrentContext()
    {
        // $this->setBrowserUrl('http://www.example.com/');
        $caps = array(
            'app' => APP_PATH
        );

        $el = $this->byName('Test Gesture');
    }
    // protected $numValues = array();

    public static $browsers = array(
        array(
            'local' => true,
            'port' => 4723,
            'browserName' => '',
            'desiredCapabilities' => array(
                'device' => 'iPhone Simulator',
                'version' => '6.0',
                'platform' => 'Mac',
                'app' => APP_PATH
            )
        )
    );

    // public function elemsByTag($tag)
    // {
    //     return $this->elements($this->using('tag name')->value($tag));
    // }

    // protected function populate()
    // {
    //     $elems = $this->elemsByTag('textField');
    //     foreach ($elems as $elem) {
    //         $randNum = rand(0, 10);
    //         $elem->value($randNum);
    //         $this->numValues[] = $randNum;
    //     }
    // }

    // public function testUiComputation()
    // {
    //     $this->populate();
    //     $buttons = $this->elemsByTag('button');
    //     $buttons[0]->click();
    //     $texts = $this->elemsByTag('staticText');
    //     $this->assertEquals(array_sum($this->numValues), (int)($texts[0]->text()));
    // }
}
