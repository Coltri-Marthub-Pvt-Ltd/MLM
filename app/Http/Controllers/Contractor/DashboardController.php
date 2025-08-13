<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Contractor;
use App\Models\Badge;
use App\Models\Brand;
use App\Models\GitCard;
use App\Models\NewScheme;
use App\Models\LimitedScheme;
use App\Models\Event;
use App\Models\Deal;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware("auth:contractor");
    }

    /**
     * Show the contractor dashboard.
     */
    public function index(): View
    {
        $contractor = Auth::guard("contractor")->user();
        $referalMember = $this->refrelmember($contractor->id);
        $directMamber = Contractor::where(
            "referenced_by",
            $contractor->id
        )->count();
        $badges = Badge::all();
        $currentBadge = Badge::getAllEarnedBadges($contractor->points);
        $nextBadge = Badge::getNextBadge($contractor->points);
        $sponsorsToday = Contractor::where("referenced_by", $contractor->id)
            ->whereDate("created_at", today())
            ->count();
        $brands = Brand::whereNot("order_by", "1")->get();
        $top_brands = Brand::where("order_by", "1")->first();
        $giuft_card = GitCard::all();
        $limitschame = LimitedScheme::all();
        $new = NewScheme::all();
        $deal = Deal::with("product", "accepted")->get();

        return view(
            "contractor.dashboard",
            compact(
                "deal",
                "new",
                "limitschame",
                "giuft_card",
                "brands",
                "top_brands",
                "sponsorsToday",
                "currentBadge",
                "nextBadge",
                "contractor",
                "referalMember",
                "directMamber",
                "badges"
            )
        );
    }

    /**
     * Show the contractor profile page.
     */
        public function partner()
        {
            $maxLevels = Contractor::count();

          $currentLevel = Contractor::with('orders')->where('id', Auth::user()->id)->first();

            $num = 0;
            $sponserPoints = 0;
            $sponser = 0;
            $data = [];
            $testing = [];
            for ($i = 0; $i <= $maxLevels; $i++) {
                if ($currentLevel && $currentLevel->id) {
                    $sponser = Contractor::where('referenced_by', $currentLevel->id)->count();
                    $nextLevel = Contractor::where('referenced_by', $currentLevel->id)->first();

                    if ($nextLevel) {
                        $currentLevel = $nextLevel;
                        $num++;
                         $sponserPoints += $currentLevel->points;
                         $testing[] = $currentLevel;
                    } else {
                        break;
                    }

                } else {
                    break;
                }
            }
            $user = Contractor::with('orders')->where('id', Auth::user()->id)->first();
            $sponser = Contractor::where('referenced_by', $user->id)->count();
            // $coinsOrdeers = CoinsOders::where('user_id',Auth::user()->id)
           return [
            'tier_user'=>$num,
            'direct_user'=> $sponser,
            'sponser_point'=>$sponserPoints,
            'gain_point'=>$user->points,
            'total_users'=>$sponser+$num,
            'used_points'=>0,
           ];


        }
    public function profile(): View
    {
        $contractor = Auth::guard("contractor")->user();
        $referalMember = $this->refrelmember($contractor->id);
        $directMamber = Contractor::where(
            "referenced_by",
            $contractor->id
        )->count();
        $partners = $this->partner();

        return view("contractor.profile",compact("contractor",'partners')
        );
    }

    /**
     * Show the leaderboard page.
     */
    public function leaderboard(): View
    {
        $contractor = Auth::guard("contractor")->user();
        $badges = Badge::all();

        return view("contractor.leader-ship_board");
    }

            public function totireWiseUser($type)
        {
            $maxLevels = Contractor::count();
            $user = [];

            if($type =='tire'){
                $data = Contractor::with('orders')->get();
            }else if($type=='coin'){
                $data = Contractor::with('orders')->orderBy('points', 'desc')->take(10)->get();
            }else{
                $data = Contractor::with('orders')->get();
            }

            foreach ($data as $val) {

                $currentLevel = $val;

                $num = 0;
                $totalPoints = 0;
                $sponser = 0;
                for ($i = 0; $i <= $maxLevels; $i++) {
                    if ($currentLevel && $currentLevel->id) {

                        $nextLevel = Contractor::where('referenced_by', $currentLevel->id)->first();

                        if ($nextLevel) {
                            $num++;
                            $totalPoints += $currentLevel->points;
                            $currentLevel = $nextLevel;
                        } else {
                            break;
                        }
                    } else {
                        break;
                    }
                    // direct sponser iwse
                        $sponser = Contractor::where('referenced_by', $val->id)->get()->count();
                }

                $user[] = [
                    'id'              => $val->id,
                    'name'            => $val->name ?? 'Unknown',
                    'total_referrals' => $num,
                    'badges'          => $this->gadgesString($val->points),
                    'points'          => $val->points,
                    'tire'            => $num,
                    'sponsors'        => $sponser,
                    'orders'          => $val->orders->count(),
                ];
            }
            if($type=='tire'){
                usort($user, function($a, $b) {
                    return $b['total_referrals'] <=> $a['total_referrals'];
                });
            }
            else if($type=='coin'){
                usort($user, function($a, $b) {
                    return $b['points'] <=> $a['points'];
                });
            }else if($type == 'sponser'){
            usort($user, function($a, $b) {
                    return $b['sponsors'] <=> $a['sponsors'];
                });
            }
            else if($type == 'oldest'){
            usort($user, function($a, $b) {
                return $a['id'] <=> $b['id'];
            });
            }
            $user = array_slice($user, 0, 10);
            return $user;
        }

    public function gadgesString($points){
            $badgesArr = [];
            foreach (Badge::getAllEarnedBadges($points) as $badge) {
                $badgesArr[] = $badge->name;
            }

           return implode(",", $badgesArr);
    }

    public function topWise($type): View
    {
        $contractor = Auth::guard("contractor")->user();
        $badges = Badge::all();

         $leaders = $this->totireWiseUser($type);

        return view(
            "contractor.leaders",
            compact("contractor", "badges", "leaders")
        );
    }

    public function upcommingEvent()
    {
        $data = Event::where("type", "upcoming")->get();

        return view("contractor.upcomming_event", compact("data"));
    }
    public function eventGallery()
    {
        $data = Event::where("type", "current")->get();
        return view("contractor.event_gallery", compact("data"));
    }
    public function refrelmember($id)
    {
        $currentLevel = Contractor::find($id);
        if ($currentLevel) {
            $maxLevels = Contractor::count();
            $count = 0;
            for ($i = 0; $i <= $maxLevels; $i++) {
                if (!empty($currentLevel) && !empty($currentLevel->id)) {
                    $nextLevel = Contractor::where(
                        "referenced_by",
                        $currentLevel->id
                    )->first();
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
            return $count;
        }
    }
}
