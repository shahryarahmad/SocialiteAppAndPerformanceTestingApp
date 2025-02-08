<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LighthouseController extends Controller
{
    public function testPerformance(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'platform' => 'required|in:mobile,desktop'
        ]);

        $url = $request->input('url');
        $platform = $request->input('platform');

        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&strategy={$platform}";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            $performanceScore = $data['lighthouseResult']['categories']['performance']['score'] * 100;

            return response()->json([
                'url' => $url,
                'platform' => ucfirst($platform),
                'performance_score' => $performanceScore
            ]);
        }

        return response()->json(['error' => 'Failed to fetch performance score'], 500);
    }
}
