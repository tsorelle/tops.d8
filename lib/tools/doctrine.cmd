@echo off
SET TOPS_TARGET=D:\Projects\websites\scym.org\next\public_html
cd D:\Projects\websites\tops\tops.test
SET BIN_TARGET="D:\Projects\websites\tops\tops.libraries\core\vendor\doctrine\orm\bin\doctrine.php"
rem SET BIN_TARGET="D:\Projects\websites\tops\tops.test\vendor\doctrine\orm\bin\doctrine.php"
php "%BIN_TARGET%" %*
