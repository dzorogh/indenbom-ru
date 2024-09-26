<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace Dzorogh\Family\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $first_person_id
 * @property int|null $second_person_id
 * @property int|null $order
 * @property string|null $marriage_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Dzorogh\Family\Models\FamilyPerson> $children
 * @property-read int|null $children_count
 * @property-read \Dzorogh\Family\Models\FamilyPerson|null $firstPerson
 * @property-read \Dzorogh\Family\Models\FamilyPerson|null $secondPerson
 * @method static \Dzorogh\Family\Database\Factories\FamilyCoupleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple whereFirstPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple whereMarriageDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple whereSecondPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyCouple whereUpdatedAt($value)
 */
	class FamilyCouple extends \Eloquent {}
}

namespace Dzorogh\Family\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $birth_date
 * @property string|null $death_date
 * @property \Dzorogh\Family\Enums\DatePrecision $birth_date_precision
 * @property \Dzorogh\Family\Enums\DatePrecision $death_date_precision
 * @property int|null $decade_of_birth
 * @property int|null $year_of_birth
 * @property int|null $month_of_birth
 * @property int|null $day_of_birth
 * @property int|null $decade_of_death
 * @property int|null $year_of_death
 * @property int|null $month_of_death
 * @property int|null $day_of_death
 * @property int|null $parent_couple_id
 * @property string $full_name
 * @property string|null $place_of_birth
 * @property string|null $article
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Dzorogh\Family\Models\FamilyPersonContact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Dzorogh\Family\Models\FamilyCouple|null $parentCouple
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Dzorogh\Family\Models\FamilyPhoto> $photos
 * @property-read int|null $photos_count
 * @method static \Dzorogh\Family\Database\Factories\FamilyPersonFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereBirthDatePrecision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereDayOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereDayOfDeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereDeathDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereDeathDatePrecision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereDecadeOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereDecadeOfDeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereMonthOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereMonthOfDeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereParentCoupleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereYearOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPerson whereYearOfDeath($value)
 */
	class FamilyPerson extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace Dzorogh\Family\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $family_person_id
 * @property string $type
 * @property string $value
 * @property-read \Dzorogh\Family\Models\FamilyPerson|null $person
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact whereFamilyPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonContact whereValue($value)
 */
	class FamilyPersonContact extends \Eloquent {}
}

namespace Dzorogh\Family\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPersonPhoto query()
 */
	class FamilyPersonPhoto extends \Eloquent {}
}

namespace Dzorogh\Family\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $description
 * @property string|null $approximate_date
 * @property string|null $place
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto whereApproximateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FamilyPhoto whereUpdatedAt($value)
 */
	class FamilyPhoto extends \Eloquent {}
}

