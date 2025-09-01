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
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class SegmentsController extends Controller
{

      public function index(Request $request)
        {
            $search = $request->input('search');

            $Segments = Segment::query()
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
                })
                ->orderBy('name', 'asc')
                ->paginate(config('default_pagination'));
                // dd($clients);
            return view('admin-views.client-segmets.index', compact('Segments'));
        }


     public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
             'validation_date' => 'required',
        ]);

        $Segment = new Segment();
        $Segment->name = $request->name;
        $Segment->type = $request->type;
        $Segment->validation_date = $request->validation_date;
        $Segment->save();

        Toastr::success('Segment added successfully');
        return back();
    }


    public function edit($id)
    {
        $clients = Client::all();
        $Segments = Segment::where('id', $id)->first();

        // if (!$Segments) {
        //     dd("Record not found for ID: " . $id);
        // }

        return view('admin-views.client-segmets.edit', compact('Segments','clients'));
    }


   public function update(Request $request, $id)
    {
        $request->validate([
             'name' => 'required|max:100',
            'type' => 'required',
            'validation_date' => 'required',
        ]);

        $client = Segment::findOrFail($id);

        $client->name = $request->name;
        $client->type = $request->type;
        $client->validation_date = $request->validation_date;
        $client->save();

        Toastr::success('Segment updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $Segment = Segment::findOrFail($id);
        $Segment->delete();

        Toastr::success('Segment deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $Segment = Segment::findOrFail($id);
        // dd($Segment);
        // agar active hai to inactive karo, warna active karo
        $Segment->status = $Segment->status === 'active' ? 'inactive' : 'active';
        $Segment->save();
        Toastr::success('Segment Status successfully  '.$Segment->status);
        return back();

    }
}
