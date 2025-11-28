<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ZakaatController extends Controller
{
    /**
     * Display the Zakaat calculator page.
     */
    public function index()
    {
        return Inertia::render('ZakaatCalculator');
    }

    /**
     * Calculate Zakaat based on provided assets.
     */
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'cash' => 'nullable|numeric|min:0',
            'bankBalance' => 'nullable|numeric|min:0',
            'gold' => 'nullable|numeric|min:0',
            'silver' => 'nullable|numeric|min:0',
            'investments' => 'nullable|numeric|min:0',
            'businessAssets' => 'nullable|numeric|min:0',
            'otherAssets' => 'nullable|numeric|min:0',
            'debts' => 'nullable|numeric|min:0',
        ]);

        // Convert empty values to 0
        $assets = [
            'cash' => $validated['cash'] ?? 0,
            'bankBalance' => $validated['bankBalance'] ?? 0,
            'gold' => $validated['gold'] ?? 0,
            'silver' => $validated['silver'] ?? 0,
            'investments' => $validated['investments'] ?? 0,
            'businessAssets' => $validated['businessAssets'] ?? 0,
            'otherAssets' => $validated['otherAssets'] ?? 0,
            'debts' => $validated['debts'] ?? 0,
        ];

        // Calculate total wealth
        $totalAssets = $assets['cash'] + $assets['bankBalance'] + $assets['gold'] 
                     + $assets['silver'] + $assets['investments'] + $assets['businessAssets'] 
                     + $assets['otherAssets'];
        
        $totalDeductions = $assets['debts'];
        $zakaatableAmount = $totalAssets - $totalDeductions;

        // Nisab threshold (approximate value in currency)
        // This should be updated based on current gold/silver prices
        // Using 85g of gold or 595g of silver as standard
        $nisab = 5000; // Default nisab, should be configurable

        // Zakaat is 2.5% of zakatable amount if it exceeds nisab
        $zakaatDue = 0;
        $isZakaatDue = false;

        if ($zakaatableAmount >= $nisab) {
            $zakaatDue = $zakaatableAmount * 0.025; // 2.5%
            $isZakaatDue = true;
        }

        return response()->json([
            'totalAssets' => $totalAssets,
            'totalDeductions' => $totalDeductions,
            'zakaatableAmount' => $zakaatableAmount,
            'nisab' => $nisab,
            'isZakaatDue' => $isZakaatDue,
            'zakaatDue' => $zakaatDue,
            'breakdown' => $assets,
        ]);
    }
}
