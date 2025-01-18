<?php
function requireRole($role) {
    if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== $role) {
        header("Location: /");
        exit();
    }
}
