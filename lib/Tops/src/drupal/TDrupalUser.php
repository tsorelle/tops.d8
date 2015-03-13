<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/12/2015
 * Time: 4:35 AM
 */

namespace Tops\drupal;



use Drupal\Core\Session\AccountProxyInterface;
use Tops\sys\TUser;
use Tops\sys;
use Drupal;

class TDrupalUser extends TUser {

    function __construct(AccountProxyInterface $user = null) {
        if (isset($user)) {
            $this->loadDrupalUser($user);
        }
    }

    /**
     * @var AccountProxyInterface
     */
    private   $drupalUser;


    /**
     * @param $id
     * @return mixed
     */
    public function loadById($id)
    {
    }

    /**
     * @param $userName
     * @return mixed
     */
    public function loadByUserName($userName)
    {
        // TODO: Implement loadByUserName() method.
    }

    /**
     * @return mixed
     */
    public function loadCurrentUser()
    {
        // TODO: Implement loadCurrentUser() method.
    }

    /**
     * @param $roleName
     * @return bool
     */
    public function isMemberOf($roleName)
    {
        // TODO: Implement isMemberOf() method.
    }

    /**
     * @return int
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        // TODO: Implement isAuthenticated() method.
    }

    /**
     * @param string $value
     * @return bool
     */
    public function isAuthorized($value = '')
    {
        // TODO: Implement isAuthorized() method.
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        // TODO: Implement getFirstName() method.
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        // TODO: Implement getLastName() method.
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        // TODO: Implement getUserName() method.
    }

    /**
     * @param bool $defaultToUsername
     * @return string
     */
    public function getFullName($defaultToUsername = true)
    {
        // TODO: Implement getFullName() method.
    }

    /**
     * @param bool $defaultToUsername
     * @return string
     */
    public function getUserShortName($defaultToUsername = true)
    {
        // TODO: Implement getUserShortName() method.
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        // TODO: Implement getEmail() method.
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        // TODO: Implement isAdmin() method.
    }

    /**
     * @return bool
     */
    public function isCurrent()
    {
        // TODO: Implement isCurrent() method.
    }

    protected function loadDrupalUser(Drupal\user\Entity\User $user) {
        $this->userName = 'guest';

        if ($_SERVER['SCRIPT_NAME'] === '/cron.php') {
            $this->authenticated = true;
            $this->userName = 'cron';
            return;
        }

            $user = Drupal::currentUser();
        // $this->uid = $user->get
        $roles = $user->getRoles();

        // todo:implement user role loading
        /*
        if (isset ($user->roles)) {
            if (!in_array('anonymous user', $user->roles)) {
                $this->authenticated = true;
                $this->roles = $user->roles;
            }
        }
        if ($this->isAuthenticated()) {  // || $offLine) {
            $this->userName = $user->getUsername();
                $this->email = $user->getEmail();
          */

            // todo: need drupal 8 way to determine admin
            /*
            if ($user->uid == 1)
                array_push($this->roles,$this->adminRole);
            */

            $this->loadDrupalProfile($user);

        }

    protected function loadDrupalProfile($user) {
        // todo:implement this for drupal 8
        /*
        if (function_exists('profile_load_profile')) {
            // TTracer::Trace('Loading profile');
            profile_load_profile($user);
            if (!empty($user->profile_firstname))
                $this->firstName = $user->profile_firstname;
            if (!empty($user->profile_lastname))
                $this->lastName = $user->profile_lastname;
            if (!empty($user->picture))
                $this->pictureFile = $user->picture;
        }
        // else            TTracer::Trace('Not loading profile');
        */
    }
}