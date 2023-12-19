<?php

/**
 * @range E00
 */

use Utils\ResponseMessages\Messages;

Messages::getInstance()
    ->addMessage('E000-000', 'Internal server error')
    ->addMessage('E000-001', 'Not found')
    ->addMessage('E000-002', 'Undefined middleware')
    ->addMessage('E000-003', 'Database connection failed')
    ->addMessage('E000-004', 'Curl request failed')
    ->addMessage('E000-005', 'Failed to create log file');
