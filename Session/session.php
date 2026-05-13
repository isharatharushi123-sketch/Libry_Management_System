<?php

// App config
$APP_NAME     = 'Library Management System';
$BASE_URL     = '/Libry_management_System';
$SESSION_NAME = 'library_management_sess';

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_name($SESSION_NAME);
    session_start();
}
//this function use only this file only.
function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function current_user()
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: ' . $GLOBALS['BASE_URL'] . '/auth/login.php');
        exit;
    }
}

function require_role($role): void
{
    if (!is_logged_in() || current_user()['role'] !== $role) {
        header('Location: ' . $GLOBALS['BASE_URL'] . 'auth/login.php');
        exit;
    }
}
