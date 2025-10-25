<?php
namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\Item;
use App\Models\Client;
use App\Models\Segment;
use App\Models\FlashSale;
use Illuminate\Http\Request;
use App\Models\FlashSaleItem;
use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\GiftOccasions;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;
use App\Models\VoucherType;

class GiftOccasionsController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $GiftOccasions = GiftOccasions::query()
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title', 'asc')
            ->paginate(config('default_pagination'));
            // dd($clients);
        return view('admin-views.gift_occasions.index', compact('GiftOccasions'));
    }

     public function store(Request $request)
    {
         $request->validate([
            'title' => 'required|max:100',
             'icon' => 'required',
        ]);
        $GiftOccasions = new GiftOccasions();
        $GiftOccasions->title = $request->title;
        $GiftOccasions->status = "active";

            //  Logo Upload
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/gift_occasions');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $GiftOccasions->icon = 'uploads/gift_occasions/' . $imageName; // save path in DB
        }

        $GiftOccasions->save();

        Toastr::success('icon added successfully');
        return back();
    }

    public function edit($id)
    {
        $GiftOccasions = GiftOccasions::where('id', $id)->first();

        return view('admin-views.gift_occasions.edit', compact('GiftOccasions'));
    }


   public function update(Request $request, $id)
    {
         $request->validate([
            'title' => 'required|max:100',
        ]);

        $GiftOccasions = GiftOccasions::findOrFail($id);

        $GiftOccasions->title = $request->title;
            //  icon Upload
    if ($request->hasFile('icon')) {
        if ($GiftOccasions->icon && file_exists(public_path($GiftOccasions->icon))) {
            unlink(public_path($GiftOccasions->icon)); // old delete
        }
        $file = $request->file('icon');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;

        $destination = public_path('uploads/gift_occasions');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $imageName);
        $GiftOccasions->icon = 'uploads/gift_occasions/' . $imageName;
    }

        $GiftOccasions->save();

        Toastr::success('Gift Occasions updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $GiftOccasions = GiftOccasions::findOrFail($id);
          //  Delete Logo
        if ($GiftOccasions->icon && file_exists(public_path($GiftOccasions->icon))) {
            unlink(public_path($GiftOccasions->icon));
        }
        $GiftOccasions->delete();

        Toastr::success(' deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $GiftOccasions = GiftOccasions::findOrFail($id);
        // dd($Voucher);
        // agar active hai to inactive karo, warna active karo
        $GiftOccasions->status = $GiftOccasions->status === 'active' ? 'inactive' : 'active';
        $GiftOccasions->save();
        Toastr::success('GiftOccasions Status successfully  '.$GiftOccasions->status);
        return back();

    }
}
