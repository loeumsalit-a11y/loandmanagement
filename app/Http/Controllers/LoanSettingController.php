<?php

namespace App\Http\Controllers;

use App\Models\LoanSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanSettingController extends Controller
{
    /**
     * Admin: show the loan settings page.
     */
    public function edit(): View
    {
        $settings = LoanSetting::all()->keyBy('key');

        return view('loans.settings', compact('settings'));
    }

    /**
     * Admin: update loan settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_interest_rate' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        LoanSetting::where('key', 'default_interest_rate')
            ->update(['value' => $validated['default_interest_rate']]);

        return back()->with('success', 'អត្រាការប្រាក់បានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ!');
    }
}
