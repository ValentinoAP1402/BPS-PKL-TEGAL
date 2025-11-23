# TODO: Implement Admin Registration Approval System

## Overview

Change the admin registration logic so that new admin accounts require Super Admin approval before they can access the dashboard.

## Tasks

-   [x] Add 'status' column to admins table migration
-   [x] Update Admin model to handle status
-   [x] Modify AdminAuthController::register() to create pending admin
-   [x] Update SuperAdminController to approve/reject pending admins
-   [x] Update user_roles/index.blade.php to show pending admins
-   [x] Add middleware to prevent pending admins from accessing dashboard
-   [x] Update routes to protect admin areas from pending admins
-   [x] Test the approval workflow

## Files to Modify

-   database/migrations/ (new migration for status column)
-   app/Models/Admin.php
-   app/Http/Controllers/AdminAuthController.php
-   app/Http/Controllers/SuperAdminController.php
-   resources/views/admin/user_roles/index.blade.php
-   app/Http/Middleware/ (new middleware for pending admin check)
-   routes/web.php
