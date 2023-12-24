<?php

namespace App\Models;

use App\Jobs\SavePatient;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthday
 * @property int $age
 * @property string $age_type
 */
class Patient extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'age',
        'age_type',
    ];

    const CACHE_KEY = 'patients';

    public function saveNewPatient()
    {
        $this->setAdditionalAgeData();

        $this->addPatientToDb();
        $this->addPatientToCache();
        $this->addPatientToQueue();
    }

    public function addPatientToDb () {
        $this->save();
    }

    public function setAdditionalAgeData()
    {
        if (empty($this->birthday)) {
            return;
        }

        try {
            $obBirthday = Carbon::parse($this->birthday);
        } catch (InvalidFormatException) {
            throw new InvalidFormatException('Указана некорректная дата рождения');
        }

        $curDateTime = now();

        $yearsCount = $curDateTime->diffInYears($obBirthday);
        if ($yearsCount > 0) {
            $this->age = $yearsCount;
            $this->age_type = 'year';
            return;
        }

        $monthsCount = $curDateTime->diffInMonths($obBirthday);
        if ($monthsCount > 0) {
            $this->age = $monthsCount;
            $this->age_type = 'month';
            return;
        }

        $this->age = $curDateTime->diffInDays($obBirthday);
        $this->age_type = 'day';
    }

    private function addPatientToCache()
    {
        $patients = Cache::get(self::CACHE_KEY, []);
        $patients[] = $this;
        Cache::put(self::CACHE_KEY, $patients, now()->addMinutes(5));
    }

    private function addPatientToQueue()
    {
        Queue::push(new SavePatient($this));
    }

    public function getBirthdayRusAttribute()
    {
        return Carbon::parse($this->birthday)->format('d.m.Y');
    }

    public function getAgeTypeRusAttribute()
    {
        if ($this->age_type === 'year') {
            return 'год';
        }

        if ($this->age_type === 'month') {
            return 'месяц';
        }

        if ($this->age_type === 'day') {
            return 'день';
        }
    }
}
