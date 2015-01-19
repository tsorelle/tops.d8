<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/17/2015
 * Time: 9:26 AM
 */

use Tops\db\TEntityManagers;
use App\db\Person;

class EntityTest extends PHPUnit_Framework_TestCase {
    public function testLoadEntity() {
        $this->assertTrue(class_exists('App\db\Person',true),'Person class not found.');
        $this->assertTrue(class_exists('\Doctrine\ORM\EntityManager',true),'EntityManager class not found.');

        \Tops\sys\TObjectContainer::clear();
        \Tops\sys\TObjectContainer::register('configManager','\Tops\sys\TYmlConfigManager');

        $em = TEntityManagers::Get();
        $repository = $em->getRepository('App\db\Person');
        $person = $repository->findOneBy(array('lastname' => 'SoRelle', 'firstname' => 'Terry'));
        $this->assertNotNull($person,'Person 180 not loaded.');

        $this->assertEquals('Terry',$person->getFirstName());
        $this->assertEquals('SoRelle',$person->getLastName());

    }
}
