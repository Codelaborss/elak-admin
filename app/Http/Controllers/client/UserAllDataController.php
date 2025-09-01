<?php

namespace App\Http\Controllers\client;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Store;
use App\Models\Review;
use App\Models\Wishlist;
use App\Scopes\ZoneScope;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class UserAllDataController extends Controller
{

    public function index(Request $request)
    {
        // dd("fdbdfbdf");
        return view("client-views.user_management");

    }
    public function notification_show(Request $request)
    {
        // dd("fdbdfbdf");
        return view("client-views.usernotification");

    }




    }


