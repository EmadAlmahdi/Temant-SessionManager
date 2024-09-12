# Temant Session Manager PHP Package

![Build Status](https://github.com/EmadAlmahdi/Temant-SessionManager/actions/workflows/ci.yml/badge.svg) 
![Coverage Status](https://codecov.io/gh/EmadAlmahdi/Temant-SessionManager/branch/main/graph/badge.svg)
![License](https://img.shields.io/github/license/EmadAlmahdi/Temant-SessionManager)
![PHPStan](https://img.shields.io/badge/PHPStan-level%20max-brightgreen)

**Temant Session Manager** is a PHP package that simplifies session management in PHP applications. It provides an easy-to-use interface for starting and managing sessions, setting and getting session variables, and more.

## Table of Contents

- [Temant\\Session PHP Package](#temantsession-php-package)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Contributing](#contributing)
  - [Issues](#issues)
  - [License](#license)

## Installation

You can install this package via Composer:
composer require temant/session-manager

## Usage
To start using this package, follow these simple steps:

Require your composer autoloader:
```php
require_once('path/to/vendor/autoload.php');
```

Create a SessionManager Instance:
```php
use Temant\SessionManager\SessionManager;
```

Create a new session instance
```php
$session = new SessionManager();
```

Start a new session:
```php
$session->start();
```

Set a session variable:
```php
$session->set('user_id', 123);
```

Get the value of a session variable:
```php
$userID = $session->get('user_id');
```

Check if a session variable exists:
```php
if ($session->has('user_id')) {
    // Do something
}
```

Remove a session variable:
```php
$session->remove('user_id');
```

Regenerate the session ID:
```php
$session->regenerate();
```

Destroy the session:
```php
$session->destroy();
```