<?php
/*
* @copyright C UAB NFQ Technologies
*
* This Software is the property of NFQ Technologies
* and is protected by copyright law – it is NOT Freeware.
*
* Any unauthorized use of this software without a valid license key
* is a violation of the license agreement and will be prosecuted by
* civil and criminal law.
*
* Contact UAB NFQ Technologies:
* E-mail: info@nfq.lt
* http://www.nfq.lt
*
*/

namespace Log;

use DateTime;

class Writer
{
    /**
     * @param string $string
     *
     * @return void
     */
    public function debugMessage(string $string): void
    {
        $this->message("DEBUG", $string, "\033[90m");
    }

    /**
     * @param string $string
     *
     * @return void
     */
    public function infoMessage(string $string): void
    {
        $this->message("INFO", $string, "\033[32m");
    }

    /**
     * @param string $string
     *
     * @return void
     */
    public function warningMessage(string $string): void
    {
        $this->message("WARNING", $string, "\033[33m");
    }

    /**
     * @param string $string
     *
     * @return void
     */
    public function errorMessage(string $string): void
    {
        $this->message("ERROR", $string, "\033[31m");
    }

    /**
     * @param string $string
     *
     * @return void
     */
    public function criticalMessage(string $string): void
    {
        $this->message("CRITICAL", $string, "\033[31m");
    }

    /**
     * @param string $prefix
     * @param string $string
     * @param string $color
     * @return void
     */
    private function message(string $prefix, string $string, string $color): void
    {
        file_put_contents("php://stdout", $color . date_format(new DateTime(), 'Y-m-d H:i:s') . " $prefix $string\033[0m" . PHP_EOL);
    }
}