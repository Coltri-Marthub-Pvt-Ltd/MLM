<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Contractor;
use App\Models\Badge;

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

        return view('contractor.dashboard', compact('contractor','referalMember','directMamber', 'badges'));
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
