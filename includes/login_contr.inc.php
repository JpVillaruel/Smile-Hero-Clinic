<?php

declare(strict_types= 1);

function isInputEmpty(string $username, string $password) {
    return empty($username) || empty($password);
}

function isUsernameWrong($result) {
    return !$result;
}

function isPasswordWrong(string $password, string $hashedPassword) {
    return !password_verify($password, $hashedPassword);
}


