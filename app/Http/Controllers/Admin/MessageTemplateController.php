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
use App\Models\DeliveryOption;
use App\Models\GiftOccasions;
use App\Models\MessageTemplate;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;
use App\Models\VoucherType;

class MessageTemplateController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $MessageTemplate = MessageTemplate::query()
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title', 'asc')
            ->paginate(config('default_pagination'));
            // dd($clients);
        return view('admin-views.message_templates.index', compact('MessageTemplate'));
    }

     public function store(Request $request)
    {
         $request->validate([
            'title' => 'required|max:100',
            'des' => 'required|max:1000',
             'icon' => 'required',
        ]);
        $MessageTemplate = new MessageTemplate();
        $MessageTemplate->title = $request->title;
        $MessageTemplate->des = $request->des;
        $MessageTemplate->status = "active";

            //  Logo Upload
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/MessageTemplate');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $MessageTemplate->icon = 'uploads/MessageTemplate/' . $imageName; // save path in DB
        }

        $MessageTemplate->save();

        Toastr::success('Message Template added successfully');
        return back();
    }

    public function edit($id)
    {
        $MessageTemplate = MessageTemplate::where('id', $id)->first();

        return view('admin-views.message_templates.edit', compact('MessageTemplate'));
    }


   public function update(Request $request, $id)
    {
         $request->validate([
            'title' => 'required|max:100',
        ]);

        $MessageTemplate = MessageTemplate::findOrFail($id);

        $MessageTemplate->title = $request->title;
        $MessageTemplate->des = $request->des;
            //  icon Upload
    if ($request->hasFile('icon')) {
        if ($MessageTemplate->icon && file_exists(public_path($MessageTemplate->icon))) {
            unlink(public_path($MessageTemplate->icon)); // old delete
        }
        $file = $request->file('icon');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;

        $destination = public_path('uploads/MessageTemplate');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $imageName);
        $MessageTemplate->icon = 'uploads/MessageTemplate/' . $imageName;
    }

        $MessageTemplate->save();

        Toastr::success('Message Template updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $MessageTemplate = MessageTemplate::findOrFail($id);
          //  Delete Logo
        if ($MessageTemplate->icon && file_exists(public_path($MessageTemplate->icon))) {
            unlink(public_path($MessageTemplate->icon));
        }
        $MessageTemplate->delete();

        Toastr::success(' deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $MessageTemplate = MessageTemplate::findOrFail($id);
        // dd($Voucher);
        // agar active hai to inactive karo, warna active karo
        $MessageTemplate->status = $MessageTemplate->status === 'active' ? 'inactive' : 'active';
        $MessageTemplate->save();
        Toastr::success('Message Template Status successfully  '.$MessageTemplate->status);
        return back();

    }
}
