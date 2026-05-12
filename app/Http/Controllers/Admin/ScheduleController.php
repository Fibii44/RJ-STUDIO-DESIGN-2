<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $availableDays = Setting::where('key', 'available_days')->first()?->value ?? json_encode([1, 2, 3, 4, 5]);
        $workingHours = Setting::where('key', 'working_hours')->first()?->value ?? json_encode([]);

        $decodedHours = json_decode($workingHours, true);
        
        // Ensure every day exists in the structure
        for ($i = 0; $i <= 6; $i++) {
            if (!isset($decodedHours[$i])) {
                $decodedHours[$i] = [['start' => '09:00', 'end' => '10:00']];
            }
        }

        return view('admin.schedule', [
            'availableDays' => json_decode($availableDays),
            'workingHours' => $decodedHours
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'available_days' => 'required|array',
            'days' => 'required|array',
        ]);

        Setting::updateOrCreate(['key' => 'available_days'], ['value' => json_encode($request->available_days)]);
        Setting::updateOrCreate(['key' => 'working_hours'], ['value' => json_encode($request->days)]);

        return back()->with('success', 'Schedule settings updated successfully.');
    }
}
