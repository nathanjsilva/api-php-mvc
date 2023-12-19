<?php

/**
 * @range E01
 */

use Utils\ResponseMessages\Messages;

Messages::getInstance()
    ->addMessage('E013-001', 'Invalid credentials')
    ->addMessage('E011-001', 'Insert user failed')
    ->addMessage('E011-002', 'User token update failed')
    ->addMessage('E011-003', 'Select user failed')
    ->addMessage('E011-004', 'Login failed');
