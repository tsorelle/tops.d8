<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/11/2015
 * Time: 5:42 AM
 */

use Tops\test\TTestUser;

class TestUserTest extends PHPUnit_Framework_TestCase {

    public function testAutoInit() {
        $user = new TTestUser();
        $this->assertFalse($user->isAuthenticated());

        $user = new TTestUser('~current');

        // $user->loadByCurrentUser();
        $this->assertTrue($user->isAdmin());

    }

    public function testAuthorization() {

        TTestUser::addUser('testguy',2,'fools,rascals,angels');
        TTestUser::addUser('badguy',3,'fools,rascals');
        TTestUser::addAuthorization('angels','delete database');

        $user = new TTestUser('testguy');
        $this->assertTrue($user->isAuthenticated());
        // $user->loadByUserName('testguy');
        $this->assertEquals('testguy',$user->getUserName());
        $this->assertEquals(2,$user->getId());
        $this->assertTrue($user->isAuthorized('delete database'));

        $user = new TTestUser('badguy');
        // $user->loadByUserName('badguy');
        $this->assertTrue($user->isAuthenticated());
        $this->assertEquals('badguy',$user->getUserName());
        $this->assertEquals(3,$user->getId());
        $this->assertFalse($user->isAuthorized('delete database'));

    }

    public function testStaticUser() {
        \Tops\sys\TObjectContainer::clear();
        \Tops\sys\TObjectContainer::register('user','\Tops\test\TTestUser');

        TTestUser::addUser('testguy',2,'fools,rascals,angels');
        TTestUser::addUser('badguy',3,'fools,rascals');
        TTestUser::addAuthorization('angels','delete database');
        TTestUser::setCurrentUserName('testguy');

        $current = \Tops\sys\TUser::getCurrent();
        $this->assertEquals('testguy',$current->getUserName());
    }

}
