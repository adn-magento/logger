<?php

/**
 * @category  Adn
 * @package   Adn\Logger
 * @copyright 2022 Adn
 * @license   OSL-3.0 https://opensource.org/licenses/OSL-3.0
 */

declare(strict_types=1);

namespace Adn\Logger\Model\Handler;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class StdoutHandler extends AbstractProcessingHandler
{
    /**
     * @param FormatterInterface $formatter
     * @param int $level
     * @param bool $bubble
     */
    public function __construct(FormatterInterface $formatter, int $level = Logger::INFO, bool $bubble = true)
    {
        $this->setFormatter($formatter);

        if (getenv('MAGE_DEBUG')) {
            $level = Logger::DEBUG;
        }

        parent::__construct($level, $bubble);
    }

    /**
     * @param array $record
     *
     * @return void
     */
    protected function write(array $record)
    {
        exec(sprintf("echo '%s' >> /proc/1/fd/1", trim($record['formatted'])));
    }
}