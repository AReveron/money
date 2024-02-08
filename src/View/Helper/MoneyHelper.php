<?php
/**
 * Copyright 2021, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2021, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace CakeDC\Money\View\Helper;


use Cake\View\Helper;
use CakeDC\Money\Utility\MoneyUtil;
use CakeDC\Money\Money;

/**
 * Class MoneyHelper
 * @package CakeDC\Money\View\Helper
 */
class MoneyHelper extends Helper
{
    protected array $helpers = ['Html', 'Number'];

    /**
     * @param array $config
     */
    public function initialize(array $config): void
    {
        $this->getView()->loadHelper('Form', ['typeMap' => ['money' => 'money']]);
        $this->getView()->Form->addWidget('money', ['CakeDC/Money.Money']);

        parent::initialize($config);
    }

    /**
     * Format number or money as currency.
     * @param $value
     * @return string
     */
    public function currency($value): string
    {
        $class = '';
        if ($value instanceof Money) {
            $output = MoneyUtil::format($value);
        } else {
            $output = $this->Number->currency($value);
        }
        if ((is_numeric($value) && $value < 0) ||
            ($value instanceof Money && MoneyUtil::lessThanZero($value))
        ) {
            $class = 'negative-balance';
        }

        return $this->Html->tag('span', $output, ['class' => $class]);
    }
}
