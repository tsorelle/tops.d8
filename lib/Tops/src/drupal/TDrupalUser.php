<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/12/2015
 * Time: 4:35 AM
 */

namespace Tops\drupal;



use Drupal\Core\Session\AccountInterface;
use Tops\sys;
use Drupal;
use Tops\sys\TAbstractUser;

class TDrupalUser extends TAbstractUser  {

    function __construct(AccountInterface $user = null) {
        if (isset($user)) {
            $this->loadDrupalUser($user);
        }
    }

    /**
     * @var AccountInterface
     */
    private   $drupalUser;


    protected function loadDrupalUser(AccountInterface $user = null)
    {
        // todo: this may not work in Drupal 8
        if ($_SERVER['SCRIPT_NAME'] === '/cron.php') {
            $this->authenticated = true;
            $this->userName = 'cron';
            $this->isCurrentUser = true;
            return;
        }

        if ($user == null) {
            $user = Drupal::currentUser();
            $this->isCurrentUser = true;
        } else {
            $this->isCurrentUser = $user->id() == Drupal::currentUser()->id();
        }

        if (!$user->isAuthenticated()) {
            $this->email = $user->getEmail();
            $this->userName = $user->getUsername();
            $this->id = $user->id();
            $this->loadDrupalProfile($user);
        }
    }

    /**
     * @param AccountInterface $user
     *
     * Assign firstName, lastName, middleName and pictureFile
     */
    protected function loadDrupalProfile(AccountInterface $user) {
        // todo:implement this for drupal 8

        /* profile_load_profile not available after drupal 6
        may be better to just delegate profile storage to the custom database, would save the synchronization
        need to see how to find the user picture anyway
        */

        $field_definitions = \Drupal::entityManager()->getFieldDefinitions('user', 'user');
        if (isset($field_definitions['user_picture'])) {


        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function loadById($id)
    {
        $user = \Drupal\user\Entity\User::load($id);
        $this->loadDrupalUser($user);
    }

    /**
     * @param $userName
     * @return mixed
     */
    public function loadByUserName($userName)
    {
        // todo: is this deprecated? doesn't seem right
        $users = user_load_by_name($userName);
        if (!empty($users)) {
            $this->loadDrupalUser($users[0]);
        }
    }

    /**
     * @return mixed
     */
    public function loadCurrentUser()
    {
        $this->loadDrupalUser();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        if ($this->drupalUser) {
            return ($this->drupalUser->id() == 1 || $this->isMemberOf('Administator'));
        }
        return false;
    }

    /**
     * @return string[]
     */
    public function getRoles()
    {
        if ($this->drupalUser) {
            return $this->drupalUser->getRoles();
        }
        return array();
    }

    /**
     * @param $roleName
     * @return bool
     */
    public function isMemberOf($roleName)
    {
        if ($this->drupalUser) {
            $roles = $this->drupalUser->getRoles();
            return in_array($roleName,$roles);
        }
        return false;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isAuthorized($value = '')
    {
        if ($this->drupalUser) {
            return $this->drupalUser->hasPermission($value);
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        if ($this->drupalUser) {
            return $this->drupalUser->isAuthenticated();
        }
        return false;
    }
}