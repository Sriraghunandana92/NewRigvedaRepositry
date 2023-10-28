<?php

// db table names
define('BASEDATA_TABLE', 'basedata');
define('CONCORDANCE_TABLE', 'concordance');

// Defaults
define('DEFAULT_RIK', '1.1.1');
define('DEFAULT_QUADRUPLET', '1.1.1.1');

define('DEFAULT_MANDALA', '1');
define('DEFAULT_SUKTA', '1');
define('DEFAULT_RIk', '1');

define('DEFAULT_ASHTAKA', '1');
define('DEFAULT_ADHYAYA', '1');
define('DEFAULT_VARGA', '1');

define('DEFAULT_ATTR', 'rishi');
define('DEFAULT_PADA_FROM', 'अ');
define('DEFAULT_MANTRA_FROM', 'अ');


// search settings
define('SEARCH_OPERAND', 'AND');

// user settings (login and registration)
define('SALT', 'rigveda');
define('REQUIRE_EMAIL_VALIDATION', False);//Set these values to True only
define('REQUIRE_RESET_PASSWORD', False);//if outbound mails can be sent from the server

// mailer settings
define('SERVICE_EMAIL', 'arjun.kashyap@srirangadigital.com');
define('SERVICE_NAME', 'Team Rigveda, Sriranga');

?>
