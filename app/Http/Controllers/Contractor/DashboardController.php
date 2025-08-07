<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Contractor;
use App\Models\Badge;
use App\Models\Brand;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:contractor');
    }

    /**
     * Show the contractor dashboard.
     */
    public function index(): View
    {
        $contractor = Auth::guard('contractor')->user();
        $referalMember  = $this->refrelmember($contractor->id);
        $directMamber  = Contractor::where('referenced_by',$contractor->id)->count();
        $badges = Badge::all();
        $currentBadge = Badge::getAllEarnedBadges($contractor->points);
        $nextBadge = Badge::getNextBadge($contractor->points);
        $sponsorsToday = Contractor::where('referenced_by', $contractor->id)->whereDate('created_at', today())->count();
        $brands = Brand::whereNot('order_by','1')->get();
        $top_brands = Brand::where('order_by','1')->first();
        return view('contractor.dashboard', compact('brands','top_brands','sponsorsToday','currentBadge','nextBadge','contractor','referalMember','directMamber', 'badges'));
    }

    /**
     * Show the contractor profile page.
     */
    public function profile(): View
    {
        $contractor = Auth::guard('contractor')->user();
        $referalMember = $this->refrelmember($contractor->id);
        $directMamber = Contractor::where('referenced_by', $contractor->id)->count();
        
        return view('contractor.profile', compact('contractor', 'referalMember', 'directMamber'));
    }

    /**
     * Show the leaderboard page.
     */
    public function leaderboard(): View
    {
        $contractor = Auth::guard('contractor')->user();
        $badges = Badge::all(); 

        // Static leaderboard data
        $leaders = [
            [
                'name' => 'Rajesh Kumar',
                'badges' => 'gold,platinum,diamond',
                'points' => 15420,
                'sponsors' => 45,
                'orders' => 128
            ],
            [
                'name' => 'Priya Sharma',
                'badges' => 'silver,gold,platinum',
                'points' => 12850,
                'sponsors' => 38,
                'orders' => 95
            ],
            [
                'name' => 'Amit Patel',
                'badges' => 'bronze,silver,gold',
                'points' => 11200,
                'sponsors' => 32,
                'orders' => 87
            ],
            [
                'name' => 'Neha Singh',
                'badges' => 'gold,diamond',
                'points' => 9850,
                'sponsors' => 28,
                'orders' => 76
            ],
            [
                'name' => 'Vikram Malhotra',
                'badges' => 'bronze,silver',
                'points' => 8750,
                'sponsors' => 25,
                'orders' => 64
            ],
            [
                'name' => 'Anjali Gupta',
                'badges' => 'platinum,diamond',
                'points' => 8200,
                'sponsors' => 22,
                'orders' => 58
            ],
            [
                'name' => 'Suresh Reddy',
                'badges' => 'silver,gold',
                'points' => 7650,
                'sponsors' => 20,
                'orders' => 52
            ],
            [
                'name' => 'Meera Iyer',
                'badges' => 'bronze',
                'points' => 6800,
                'sponsors' => 18,
                'orders' => 45
            ],
            [
                'name' => 'Karan Verma',
                'badges' => 'gold,platinum',
                'points' => 6200,
                'sponsors' => 16,
                'orders' => 41
            ],
            [
                'name' => 'Pooja Joshi',
                'badges' => 'silver',
                'points' => 5800,
                'sponsors' => 15,
                'orders' => 38
            ],
            [
                'name' => 'Rahul Mehta',
                'badges' => 'bronze,silver,gold',
                'points' => 5200,
                'sponsors' => 14,
                'orders' => 35
            ],
            [
                'name' => 'Divya Kapoor',
                'badges' => 'diamond',
                'points' => 4800,
                'sponsors' => 12,
                'orders' => 32
            ]
        ];

        return view('contractor.leaders', compact('contractor', 'badges', 'leaders'));
    }

        public function refrelmember($id)
    {
        $currentLevel = Contractor::find($id);
        if ($currentLevel) {

            $maxLevels = Contractor::count();
            $count = 0;
            for ($i = 0; $i <= $maxLevels; $i++) {
               
                if (!empty($currentLevel) && !empty($currentLevel->id)) {
                    $nextLevel = Contractor::where('referenced_by', $currentLevel->id)->first();
                    if ($nextLevel) {
                        $currentLevel = $nextLevel;
                        $count += 1;
                    } else {
                        break;
                    }
                } else {
                    break;
                }
            }
            return  $count;
        }
    }
}
