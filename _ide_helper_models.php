<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{
    /**
     * App\Models\Role.
     *
     * @property int $id
     * @property string $name
     * @property string $guard_name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
     * @property-read int|null $permissions_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
     * @property-read int|null $users_count
     * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
     * @method static \Illuminate\Database\Eloquent\Builder|Role query()
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
     */
    class Role extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Souvenir.
     *
     * @property int $id
     * @property int $store_id
     * @property string $souvenir_name
     * @property int $souvenir_price
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir query()
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir whereSouvenirName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir whereSouvenirPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir whereStoreId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Souvenir whereUpdatedAt($value)
     */
    class Souvenir extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Store.
     *
     * @property int $id
     * @property int $user_id
     * @property int $tour_id
     * @property string $regency_id
     * @property string $province_id
     * @property string $store_name
     * @property string $store_address
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Store query()
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereProvinceId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereRegencyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereTourId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Store whereUserId($value)
     */
    class Store extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Ticket.
     *
     * @property int $id
     * @property int $tour_id
     * @property int $ticket_qty
     * @property int $ticket_price
     * @property string $checkin
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCheckin($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereTicketPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereTicketQty($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereTourId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
     */
    class Ticket extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Tour.
     *
     * @property int $id
     * @property string $tour_name
     * @property string $regency_id
     * @property string $province_id
     * @property int $user_id
     * @property string $tour_address
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Tour newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Tour newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Tour query()
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereProvinceId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereRegencyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTourAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTourName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tour whereUserId($value)
     */
    class Tour extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\User.
     *
     * @property int $id
     * @property string $username
     * @property string $name
     * @property string $email
     * @property \Illuminate\Support\Carbon|null $email_verified_at
     * @property string $birthdate
     * @property int $gender 1) Laki-laki; 2) Perempuan
     * @property string $password
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
     * @property-read int|null $permissions_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
     * @property-read int|null $roles_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
     * @property-read int|null $tokens_count
     * @method static \Database\Factories\UserFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthdate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
     */
    class User extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Virtualtour.
     *
     * @property int $id
     * @property int $user_id
     * @property int $tour_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour query()
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour whereTourId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtour whereUserId($value)
     */
    class Virtualtour extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Virtualtourgallery.
     *
     * @property int $id
     * @property string $name
     * @property string $gallery
     * @property int $virtualtour_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery query()
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery whereGallery($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Virtualtourgallery whereVirtualtourId($value)
     */
    class Virtualtourgallery extends \Eloquent
    {
    }
}
