<?php
namespace App\Core;

abstract class Controller {
    protected function view(string $path, array $data = []): void {
        extract($data);
        $file = APP_ROOT . '/views/' . $path . '.php';
        if (!file_exists($file)) {
            die("View not found: $path");
        }
        require $file;
    }

    protected function redirect(string $url): void {
        header("Location: " . APP_URL . $url);
        exit;
    }

    protected function redirectBack(): void {
        $ref = $_SERVER['HTTP_REFERER'] ?? APP_URL . '/admin/dashboard';
        header("Location: $ref");
        exit;
    }

    protected function json(mixed $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function post(string $key, mixed $default = null): mixed {
        return $_POST[$key] ?? $default;
    }

    protected function get(string $key, mixed $default = null): mixed {
        return $_GET[$key] ?? $default;
    }

    protected function sanitize(string $value): string {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    protected function setFlash(string $type, string $message): void {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function requireAuth(): void {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    protected function requireRole(string ...$roles): void {
        $this->requireAuth();
        if (!in_array($_SESSION['user_role'] ?? '', $roles)) {
            $this->setFlash('danger', 'Access denied.');
            $this->redirect('/admin/dashboard');
        }
    }
}
