<?php

class Session
{
    private array $messages;
    private $csrfToken;

    public function __construct()
    {
        session_start();
        define('BASE_URL', '../../index.php');
        $this->csrfToken = Session::generateCsrfToken();

        $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
        unset($_SESSION['messages']);
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['username']);
    }

    public function logout()
    {
        session_destroy();
    }

    public static function setToken($token, $value)
    {
        $_SESSION[$token] = $value;
    }

    public static function getToken($token)
    {
        return isset($_SESSION[$token]) ? $_SESSION[$token] : null;
    }

    public static function generateCsrfToken($token = 'csrf_token')
    {
        if (!isset($_SESSION[$token])) {
            $_SESSION[$token] = bin2hex(random_bytes(32));
        }
        return $_SESSION[$token];
    }

    public function validateCsrfToken($csfr)
    {
        return $csfr === $this->csrfToken;
    }

    public function getUsername(): ?string
    {
        return isset($_SESSION['username']) ? $_SESSION['username'] : null;
    }

    public function setUsername(string $username)
    {
        $_SESSION['username'] = $username;
    }

    public function setId(int $id)
    {
        $_SESSION['id'] = $id;
    }

    public function getId(): ?int
    {
        return isset($_SESSION['id']) ? $_SESSION['id'] : null;
    }

    public function addMessage(string $type, string $text)
    {
        $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
