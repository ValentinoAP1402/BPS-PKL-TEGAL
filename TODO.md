# TODO: Implement Automatic Deletion of Pending Registrations

## Current Status

-   ✅ Created DeletePendingRegistrations command
-   ✅ Implemented logic to delete pending registrations older than 3 days
-   ✅ Scheduled the command to run daily in Kernel.php

## Tasks

-   ✅ Create artisan command for deleting pending registrations
-   ✅ Add logic to delete registrations older than 3 days with status 'pending'
-   ✅ Handle deletion of associated files (surat_keterangan_pkl, surat_tanda_tangan, etc.)
-   ✅ Schedule the command to run daily
-   ✅ Update TODO.md with progress

## Previous TODO: Implement Forgot Password Feature

## Current Status

-   ✅ Login view has functional "Lupa password?" link
-   ✅ UserAuthController has password reset methods
-   ✅ Routes for password reset added
-   ✅ Views for forgot/reset password forms created

## Tasks

-   ✅ Add forgot password routes to web.php
-   ✅ Add forgot password methods to UserAuthController
-   ✅ Create forgot-password.blade.php view
-   ✅ Create reset-password.blade.php view
-   ✅ Update login.blade.php to link to forgot password
-   ✅ Test the functionality
