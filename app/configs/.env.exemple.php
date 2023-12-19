<?php

# DB
define('DB_HOST', 'localhost');
define('DB_NAME', 'micro_servico_php_base');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_DRIVER', 'mysql');

# Time
define('DEFAULT_TIME_ZONE', 'America/Fortaleza');

# Locale
define('DEFAULT_LOCALE', 'pt_BR');

# Environment
define('ENVIRONMENT', 'development');
// define('ENVIRONMENT', 'homologation');
// define('ENVIRONMENT', 'production');

# API secret
# É importante criar novos secrets para cada aplicação > bin2hex(random_bytes(256))
define('SECRET', '8d0c035dbf3e222eb761e4ac35b516d699288d9283594d4627ef8e2ac5b4e00c');
