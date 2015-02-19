<?php
/**
 * Initialize dependency injection.
 *
 * Created by PhpStorm.
 * User: Terry
 * Date: 11/8/2014
 * Time: 6:02 PM
 */

\Tops\sys\TErrorException::SetErrorHandler();
\Tops\sys\TObjectContainer::Register('configManager','\Tops\sys\TYmlConfigManager');
\Tops\sys\TObjectContainer::Register('user','\Tops\test\TTestUser');
\Tops\sys\TObjectContainer::Register('mailer','\Tops\sys\TSwiftMailer','configManager');
\Tops\sys\TObjectContainer::Register('logManager','\Tops\sys\TLogManager','configManager,mailer');
\Tops\sys\TObjectContainer::Register('errorLogger','\Tops\sys\TLogger');
\Tops\sys\TObjectContainer::Register('traceLogger','\Tops\sys\TLogger',':trace');
\Tops\sys\TObjectContainer::Register('tracer','\Tops\sys\TTracer','configManager,traceLogger');
\Tops\sys\TObjectContainer::Register('exceptionHandler','\Tops\sys\TExceptionHandler','errorLogger,configManager');
\Tops\sys\TObjectContainer::Register('serviceFactory','\Tops\services\TServiceFactory','configManager');
\Tops\sys\TObjectContainer::Register('serviceHost','\Tops\services\TServiceHost','serviceFactory,user,exceptionHandler');
// \Tops\sys\TObjectContainer::Register('mailboxManager','\Tops\sys\T','serviceFactory,user,exceptionHandler');

// Application specific objects should be registered in /App/start/init.php (or corresponding directory)
// e.g.
/*
     \Tops\sys\TObjectContainer::Register('mailbox','\App\db\ScymMailbox');
     \Tops\sys\TObjectContainer::LoadConfig('di.yml');
*/

