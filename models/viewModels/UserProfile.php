<?php

namespace app\models\viewModels;

use app\models\UserProfile as ModelsUserProfile;
use yii\base\Model;

class UserProfile extends Model
{
    public $firstname;
    public $lastname;
    public $middlename;
    public $designation;

    public function getUserProfileById($id)
    {
        $profile = ModelsUserProfile::findOne(['id' => $id]);
        $this->firstname = $profile->firstname;
        $this->lastname = $profile->lastname;
        $this->middlename = $profile->middlename;
        $this->designation = $profile->designation;

        return $this;
    }
}
