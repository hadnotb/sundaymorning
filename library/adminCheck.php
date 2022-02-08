<?php
use App\Model\UserModel;
use App\Framework\UserSession;
if (!UserSession::hasRoles(UserModel::ROLE_ADMIN)) {
            http_response_code(403);
            echo 'Accès interdit';
            exit;
    }