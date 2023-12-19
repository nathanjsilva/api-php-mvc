<?php

/**
 * @range E00
 */

use Utils\ResponseMessages\Messages;

Messages::getInstance()
    ->addMessage('E023-001', 'Bad Gateway')
    ->addMessage('E023-002', 'Exceptions test');
