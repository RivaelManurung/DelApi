<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ValidRencanaDateTime implements Rule
{
    public function passes($attribute, $value)
    {
        // Convert the input date and time to a Carbon instance
        $dateTime = Carbon::parse($value);

        // Check if the day is Friday and the time is after 17:00
        if ($dateTime->dayOfWeek == Carbon::FRIDAY && $dateTime->hour >= 17) {
            return true;
        }

        // Check if the day is Saturday and the time is between 08:00 and 17:00
        if ($dateTime->dayOfWeek == Carbon::SATURDAY && $dateTime->hour >= 8 && $dateTime->hour < 17) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'The :attribute must be on Friday after 17:00 or on Saturday between 08:00 and 17:00.';
    }
}
