<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '';

    /**
     * The attributes that arn't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($this->isDateAttribute($key)) {
            $value->setTimezone(config('app.timezone_display'));
        }

        return $value;
    }

    /**
     * Fill the Datetime field with current time in UTC.
     *
     * @param  string  $field
     * @param  \Carbon\Carbon  $datetime
     * @return $this
     */
    protected function fillDatetime($field, $datetime = null)
    {
        if (! $datetime instanceof \DateTimeInterface) {
            $datetime = Carbon::now();
        }

        return $this->setAttribute($field, $datetime);
    }

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function create(array $attributes = [])
    {
        if (static::CREATED_AT) {
            $attributes[static::CREATED_AT] = Carbon::now();
        }

        return static::query()->create($attributes);
    }
}
