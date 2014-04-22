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

require_once('PHPUnit/Extensions/AppiumTestCase/SessionCommand/Context.php');

class PHPUnit_Extensions_AppiumTestCase_Session
    extends PHPUnit_Extensions_Selenium2TestCase_Session
{
    /**
     * @var string  the base URL for this session,
     *              which all relative URLs will refer to
     */
    private $baseUrl;

    public function __construct($driver,
                                PHPUnit_Extensions_Selenium2TestCase_URL $url,
                                PHPUnit_Extensions_Selenium2TestCase_URL $baseUrl,
                                PHPUnit_Extensions_Selenium2TestCase_Session_Timeouts $timeouts)
    {
        $this->baseUrl = $baseUrl;
        parent::__construct($driver, $url, $baseUrl, $timeouts);
    }

    protected function initCommands()
    {
        $baseUrl = $this->baseUrl;
        $commands = parent::initCommands();

        $commands['contexts'] = 'PHPUnit_Extensions_Selenium2TestCase_SessionCommand_GenericAccessor';
        $commands['context'] = 'PHPUnit_Extensions_AppiumTestCase_SessionCommand_Context';

        return $commands;
    }
}
