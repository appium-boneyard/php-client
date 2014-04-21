<?php

/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 **/

require_once('PHPUnit/Extensions/AppiumTestCase/SessionStrategy/Isolated.php');


abstract class PHPUnit_Extensions_AppiumTestCase extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @var array
     */
    private static $lastBrowserParams;

    /**
     * @var array
     */
    private $parameters;

    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        // Make sure we are using the Appium session
        self::setUpSessionStrategy(array("sessionStrategy" => "isolated"));
    }

    private static function defaultSessionStrategy()
    {
        return new PHPUnit_Extensions_AppiumTestCase_SessionStrategy_Isolated;
    }

    /**
     * @param boolean
     */
    public static function shareSession($shareSession)
    {
        if (!is_bool($shareSession)) {
            throw new InvalidArgumentException("The shared session support can only be switched on or off.");
        }
        if (!$shareSession) {
            self::$sessionStrategy = self::defaultSessionStrategy();
        } else {
            self::$sessionStrategy = new PHPUnit_Extensions_AppiumTestCase_SessionStrategy_Shared(self::defaultSessionStrategy());
        }
    }


    // We want to inject an Appium session into the PHPUnit-Selenium logic.
    protected function setUpSessionStrategy($params)
    {
        // This logic enables us to have a session strategy reused for each
        // item in self::$browsers. We don't want them both to share one
        // and we don't want each test for a specific browser to have a
        // new strategy
        if ($params == self::$lastBrowserParams) {
            // do nothing so we use the same session strategy for this
            // browser
        } elseif (isset($params['sessionStrategy'])) {
            $strat = $params['sessionStrategy'];
            if ($strat != "isolated" && $strat != "shared") {
                throw new InvalidArgumentException("Session strategy must be either 'isolated' or 'shared'");
            } elseif ($strat == "isolated") {
                self::$browserSessionStrategy = new PHPUnit_Extensions_AppiumTestCase_SessionStrategy_Isolated;
            } else {
                self::$browserSessionStrategy = new PHPUnit_Extensions_AppiumTestCase_SessionStrategy_Shared(self::defaultSessionStrategy());
            }
        } else {
            self::$browserSessionStrategy = self::defaultSessionStrategy();
        }
        self::$lastBrowserParams = $params;
        $this->localSessionStrategy = self::$browserSessionStrategy;
    }
}
