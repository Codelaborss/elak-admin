<?php
namespace App\Http\Controllers\Admin;

use Storage;
use DateTime;
use App\Models\Item;
use App\Models\Client;
use App\Models\Segment;
use App\Models\Category;
use App\Models\GiftCard;
use App\Models\FlashSale;
use App\Models\VoucherType;
use Illuminate\Http\Request;
use App\Models\FlashSaleItem;
use App\CentralLogics\Helpers;
use App\Models\ManagementType;
use App\Models\UsageTermManagement;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class GiftcardController extends Controller
{

   public function list(Request $request)
    {
        $category = Category::get();

        $search = $request->input('search_occasion'); // correct field name
        $categoryId = $request->input('category_id'); // correct field name

        $UsageTermManagement = GiftCard::query()
            ->leftJoin('categories', 'gift_cards.business_category', '=', 'categories.id')
            ->when($search, function ($q) use ($search) {
                $q->where('gift_cards.occasion_name', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('gift_cards.business_category', $categoryId);
            })
            ->orderBy('gift_cards.occasion_name', 'asc')
            ->select(
                'gift_cards.*',
                'categories.name as category_name'
            )
            ->paginate(config('default_pagination'));

        return view('admin-views.gift_card.index', compact('UsageTermManagement','category'));
    }

    public function index(Request $request)
    {
        $category =  Category::get();
        return view('admin-views.gift_card.add', compact('category'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
       $validated = $request->validate([
            "occasion_name" => "required",
            "business_category" => "required",
            "display_priority" => "required",
            "occasion_gallery" => "nullable|array",
        ]);
       $imagePaths = [];

        if ($request->hasFile('occasion_gallery')) {
            foreach ($request->file('occasion_gallery') as $index => $image) {
                if ($image->isValid()) {
                    // Unique file name
                    $filename = 'occasion_' . uniqid() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('occasions', $filename, 'public');
                    $imagePaths[] = 'storage/' . $path;
                }
            }
        }
        // Save JSON array of relative paths in DB
        $occasion = new GiftCard();
        $occasion->occasion_name = $request->occasion_name;
        $occasion->business_category = $request->business_category;
        $occasion->display_priority = $request->display_priority;
        $occasion->occasion_gallery = json_encode($imagePaths);
        $occasion->save();

          Toastr::success('Usages Term and Condition Created successfully');
            return back();
    }


    public function edit($id)
    {
         $category = Category::get();
        $ManagementType = GiftCard::where('id', $id)->first();
         $gallery = is_string($ManagementType->occasion_gallery)
        ? json_decode($ManagementType->occasion_gallery, true)
        : $ManagementType->occasion_gallery;

        return view('admin-views.gift_card.edit', compact('ManagementType','category','gallery'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "occasion_name" => "required",
            "business_category" => "required",
            "display_priority" => "required",
            "occasion_gallery" => "nullable|array",
        ]);

        $record = GiftCard::findOrFail($id);

        // Get old gallery (array)
        $oldGallery = $record->occasion_gallery
            ? json_decode($record->occasion_gallery, true)
            : [];

        // 1️⃣ Delete selected old images
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $img) {
                // File delete karo storage se
                $filePath = str_replace('storage/', '', $img); // remove "storage/" prefix
                if (Storage::disk('public')->exists($filePath)) {
                    \Storage::disk('public')->delete($filePath);
                }
                // Array se bhi remove
                $oldGallery = array_diff($oldGallery, [$img]);
            }
        }

        // 2️⃣ Upload new images
        $newGallery = [];
        if ($request->hasFile('occasion_gallery')) {
            foreach ($request->file('occasion_gallery') as $index => $image) {
                if ($image->isValid()) {
                    $filename = 'occasion_' . uniqid() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('occasions', $filename, 'public');
                    $newGallery[] = 'storage/' . $path;
                }
            }
        }

        // 3️⃣ Merge old + new images
        $finalGallery = array_merge($oldGallery, $newGallery);

        // 4️⃣ Update record
        $record->occasion_name = $request->occasion_name;
        $record->business_category = $request->business_category;
        $record->display_priority = $request->display_priority;
        $record->occasion_gallery = json_encode(array_values($finalGallery));
        $record->save();

        Toastr::success('Usages Term and Condition updated successfully');
        return back();
    }


    public function delete(Request $request, $id)
    {
        $ManagementType = GiftCard::findOrFail($id);
          //  Delete Logo
        if ($ManagementType->logo && file_exists(public_path($ManagementType->logo))) {
            unlink(public_path($ManagementType->logo));
        }
        $ManagementType->delete();

        Toastr::success('Usages Term and Condition deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $ManagementType = GiftCard::findOrFail($id);
        // dd($ManagementType);
        // agar active hai to inactive karo, warna active karo
        $ManagementType->status = $ManagementType->status === 'active' ? 'inactive' : 'active';
        $ManagementType->save();
        Toastr::success('Usages Term and Condition Status successfully  '.$ManagementType->status);
        return back();

    }
    public function assign_to_voucher(Request $request)
    {
            $VoucherType = VoucherType::all();
            return view('admin-views.gift_card.assign_of_voucher', compact('VoucherType'));

    }
    public function getAssignments($id)
    {
        $conditions = GiftCard::all();
        // JSON banakar bhej do
        return response()->json([
            'voucherId' => $id,
            'conditions' => $conditions
        ]);

    }
    public function getAssignments_update(Request $request)
    {
        $validated = $request->validate([
            "voucher_id" => "required|integer",
            "voucher_update_ids" => "array",
        ]);

        $voucherId = $validated['voucher_id'];
        $checkedIds = $validated['voucher_update_ids'] ?? [];

        // Step 1: voucher_id ke saare records nikal lo
        $existingRecords = GiftCard::where('voucher_id', $voucherId)->pluck('id')->toArray();

        // Step 2: Jo ids checked hain unko update karo
        if (!empty($checkedIds)) {
            foreach ($checkedIds as $id) {
                GiftCard::updateOrCreate(
                    ['id' => $id],
                    ['voucher_id' => $voucherId]
                );
            }
        }

        // Step 3: Jo purane record the, par ab unchecked hain → unka voucher_id null kar do
        $uncheckedIds = array_diff($existingRecords, $checkedIds);

        if (!empty($uncheckedIds)) {
            GiftCard::whereIn('id', $uncheckedIds)
                ->update(['voucher_id' => null]);
        }

        Toastr::success('Usages Term and Condition Updated successfully');
        return back();
    }

       public function preview_terms()
    {
      $VoucherType = VoucherType::all();
            return view('admin-views.gift_card.preview_term', compact('VoucherType'));
    }

    public function preview_terms_show($id)
    {
        $conditions = GiftCard::where("voucher_id", $id)->get([
            'id',
            'occasion_name',
            'baseinfor_description',
            'timeandday_config_days',
            'timeandday_config_time_range_from',
            'timeandday_config_time_range_to',
            'timeandday_config_valid_from_date',
            'timeandday_config_valid_until_date',
            'holiday_occasions_holiday_restrictions',
            'holiday_occasions_customer_blackout_dates',
            'holiday_occasions_special_occasions',
            'usage_limits_limit_per_user',
            'usage_limits_period',
            'usage_limits_min_purch_account',
            'usage_limits_max_discount_amount',
            'usage_limits_advance_booking_required',
            'usage_limits_group_size_required',
            'location_availability_venue_types',
            'location_availability_specific_branch',
            'location_availability_city',
            'location_availability_delivery_radius',
            'customer_membership_customer_type',
            'customer_membership_age_restriction',
            'customer_membership_min_membership_radius',
            'restriction_polices_restriction_type',
            'restriction_polices_cancellation_policy',
            'restriction_polices_excluded_product',
            'restriction_polices_surchange_account',
            'restriction_polices_surchange_apple',
            'voucher_id',
            'status',
            'created_at',
            'updated_at',
        ]);

        return response()->json([
            'voucherId' => $id,
            'conditions' => $conditions
        ]);
    }


public function toggleStatus($id)
{
    $giftCard = GiftCard::findOrFail($id);

    // Toggle status
    $giftCard->status = $giftCard->status === 'active' ? 'inactive' : 'active';
    $giftCard->save();

    return response()->json([
        'success' => true,
        'status' => $giftCard->status,
    ]);
}

}
