<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Notification;
use App\Models\Card;

class User extends Authenticatable implements JWTSubject,HasMedia
{
    use HasFactory, Notifiable;
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }

    protected $with=['skills','hobbies','City','work'];
    protected $appends = [
        'has_media',
        'full_name',
    ];

   /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'city',
        'hour',
        'coffee_cat',
        'work',
        'phone',
        'password',
        'status',
        'role',
        'param1',
        'param2',
        'param3',
        'remember_token',
        'fcm_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'phone',
        'param1',
        'param2',
        'param3',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'age'=>'integer',
        'gender'=>'boolean',
        'city' => 'integer',
        'hour'=>'integer',
        'coffee_cat'=>'integer',
        'work' => 'integer',
        'phone' => 'string',
        'password' => 'string',
        'status' => 'integer',
        'role' => 'integer',
        'param1' => 'string',
        'param2' => 'string',
        'param3' => 'string',
        'remember_token' => 'string',
        'fcm_token' => 'string'
    ];

      /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

     /*    protected $with=['stories']; */
     /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->sharpen(10);
    }

    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl($collectionName = 'default', $conversion = '')
    {
        $url = $this->getFirstMediaUrlTrait($collectionName);
        $array = explode('.', $url);
        $extension = strtolower(end($array));
        if (in_array($extension, config('medialibrary.extensions_has_thumb'))) {
            return asset($this->getFirstMediaUrlTrait($collectionName, $conversion));
        } else {
            return null;
        }
    }

      /**
     * Add Media to api results
     * @return bool
     */
    public function getHasMediaAttribute()
    {
        return $this->hasMedia('images') ? true : false;
    }

    /**
     * Get fullName to user
     * @return string
    */
    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

     /**
      * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
      */
      public function skills(){
        return $this->belongsToMany(Skill::class);
      }

       /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hobbies(){
        return  $this->belongsToMany(Hobby::class);
     }

       /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return  $this->hasMany(Order::class);
     }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function card()
    {
        return $this->hasMany(Card::class);
    }

      /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function City()
    {
        return $this->belongsTo(City::class,'city');
    }

      /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function work()
    {
        return $this->belongsTo(Work::class,'work');
    }

}
