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
use App\Models\App;
use App\Models\Banner;
use App\Models\ColorTheme;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
      $clients = Client::all();
        $Banner = Banner::all();
        $ColorTheme = ColorTheme::all();
        $Apps = \App\Models\App::query()
            ->leftJoin('banners', 'apps.banner', '=', 'banners.id')
            ->leftJoin('color_themes', 'apps.color_theme', '=', 'color_themes.id')
            ->select(
                'apps.*',
                'banners.title as banner_title',
                'banners.image as banner_image',
                'color_themes.color_name',
                'color_themes.color_code',
                'color_themes.color_gradient',
                'color_themes.color_type'
            )
            ->when($search, function ($q) use ($search) {
                $q->where('apps.app_name', 'like', "%{$search}%")
                ->orWhere('apps.app_type', 'like', "%{$search}%")
                ->orWhere('banners.title', 'like', "%{$search}%")
                ->orWhere('color_themes.color_name', 'like', "%{$search}%");
            })
            ->orderBy('apps.app_name', 'asc')
            ->paginate(config('default_pagination'));

        return view('admin-views.app.index', compact('Apps','clients','ColorTheme','Banner'));
    }

     public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
             'logo_image' => 'nullable',
             'descrption' => 'required',
             'color_theme' => 'required',
             'banner' => 'required',
        ]);

        $app = new App();
        $app->app_name = $request->name;
        $app->app_dec = $request->descrption;
        $app->app_type = $request->type;
        $app->color_theme = $request->color_theme;
        $app->banner = $request->banner;
        //  Logo Upload
    if ($request->hasFile('logo_image')) {
        $file = $request->file('logo_image');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;

        $destination = public_path('uploads/app/logos');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $imageName);
        $app->app_logo = 'uploads/app/logos/' . $imageName; // save path in DB
    }

        $app->save();
        Toastr::success('App added successfully');
        return back();
    }


    public function edit($id)
    {
        $clients = Client::all();
        $Banner = Banner::all();
        $ColorTheme = ColorTheme::all();

        $App = \App\Models\App::query()
            ->leftJoin('banners', 'apps.banner', '=', 'banners.id')   // 👈 yahan column ka naam sahi karna
            ->leftJoin('color_themes', 'apps.color_theme', '=', 'color_themes.id')
            ->select(
                'apps.*',
                'banners.title as banner_title',
                'banners.image as banner_image',
                'color_themes.color_name',
                'color_themes.color_code',
                'color_themes.color_gradient',
                'color_themes.color_type'
            )
            ->where('apps.id', $id)
            ->first();

        return view('admin-views.app.edit', compact('App', 'clients', 'Banner', 'ColorTheme'));
    }


   public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required|max:100',
            'type' => 'required',
            'descrption' => 'required',
            'color_theme' => 'required',
            'banner' => 'required',
        ]);


        $app = App::findOrFail($id);
       $app->app_name = $request->name;
        $app->app_dec = $request->descrption;
        $app->app_type = $request->type;
        $app->color_theme = $request->color_theme;
        $app->banner = $request->banner;
    //  Logo Upload
        if ($request->hasFile('logo_image')) {
            if ($app->app_logo && file_exists(public_path($app->app_logo))) {
                unlink(public_path($app->app_logo)); // old delete
            }
            $file = $request->file('logo_image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;

            $destination = public_path('uploads/app/logos');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $imageName);
            $app->app_logo = 'uploads/app/logos/' . $imageName;
        }

        $app->save();

        Toastr::success('App updated successfully');
        return back();
    }

    public function delete(Request $request, $id)
    {
        $App = App::findOrFail($id);
        //  Delete Logo
        if ($App->app_logo && file_exists(public_path($App->app_logo))) {
            unlink(public_path($App->app_logo));
        }
        $App->delete();

        Toastr::success('App deleted successfully');
        return back();
    }

    public function status( $id)
    {
        $App = App::findOrFail($id);
        // dd($Segment);
        // agar active hai to inactive karo, warna active karo
        $App->status = $App->status === 'active' ? 'inactive' : 'active';
        $App->save();
        Toastr::success('App Status successfully  '.$App->status);
        return back();

    }
}
