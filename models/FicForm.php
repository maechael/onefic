<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fic".
 *
 * @property int $id
 * @property string $name
 * @property int $region_id
 * @property string|null $address
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Facility[] $facilities
 * @property FicFacility[] $ficFacilities
 * @property Region $region
 */
class FicForm extends Fic
{
     public $facilityIds;
}
