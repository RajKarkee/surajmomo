<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard(): View
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', true)->count();
        $recentProducts = Product::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalProducts', 'activeProducts', 'recentProducts'));
    }

    /**
     * Display a listing of all products
     */
    public function products(): View
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function createProduct(): View
    {
        return view('admin.products.create_modern');
    }

    /**
     * Store a newly created product
     */
    public function storeProduct(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'image_url' => 'nullable|url',
            'status' => 'required|in:active,inactive',
            'ingredients' => 'nullable|string',
            'spice_level' => 'nullable|in:mild,medium,spicy,very_spicy'
        ]);

        Product::create($validated);

        return redirect()->route('admin.products')
                        ->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing a product
     */
    public function editProduct(Product $product): View
    {
        return view('admin.products.edit_modern', compact('product'));
    }

    /**
     * Update the specified product
     */
    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'image_url' => 'nullable|url',
            'status' => 'required|in:active,inactive',
            'ingredients' => 'nullable|string',
            'spice_level' => 'nullable|in:mild,medium,spicy,very_spicy'
        ]);

        $product->update($validated);

        return redirect()->route('admin.products')
                        ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product
     */
    public function destroyProduct(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products')
                        ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->route('admin.products')
                        ->with('success', 'Product status updated successfully!');
    }
    public function settings(){
        // Get existing settings or create empty object for form
        $settings = \App\Models\Setting::first();
        
        if (!$settings) {
            $settings = new \App\Models\Setting();
        }
        
        return view('admin.setting', compact('settings'));
    }
    public function settingsUpdate(Request $request){
        $request->validate([
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'time' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'map_link' => 'nullable|url|max:255',
        ]);

                       
        $settings = \App\Models\Setting::first();
        
        if (!$settings) {
            $settings = new \App\Models\Setting();
        }

        if ($request->hasFile('logo_path')) {
            // Delete old logo if exists
            if ($settings->logo_path && \Storage::disk('public')->exists($settings->logo_path)) {
                \Storage::disk('public')->delete($settings->logo_path);
            }
            
            $logoPath = $request->file('logo_path')->store('logos', 'public');
            $settings->logo_path = $logoPath;
        }

        $settings->site_name = $request->input('site_name');
        $settings->contact_email = $request->input('contact_email');
        $settings->contact_phone = $request->input('contact_phone');
        $settings->facebook_link = $request->input('facebook_link');
        $settings->twitter_link = $request->input('twitter_link');
        $settings->instagram_link = $request->input('instagram_link');
        $settings->time = $request->input('time');
        $settings->address = $request->input('address');
        $settings->map_link = $request->input('map_link');

        $settings->save();

        return redirect()->route('admin.settings')
                         ->with('success', 'Settings updated successfully!');
    }

    public function jumbotron(){
        $jumbotrons = \App\Models\Jumbotron::all();
        return view('admin.jumbotron', compact('jumbotrons'));
    }

    public function jumbotronStore(Request $request){
        $request->validate([
            'page' => 'required|string|max:255|unique:jumbotrons,page',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'other_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $jumbotron = new \App\Models\Jumbotron();
        $jumbotron->page = $request->input('page');
        $jumbotron->title = $request->input('title');
        $jumbotron->subtitle = $request->input('subtitle');

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            $backgroundPath = $request->file('background_image')->store('jumbotron/backgrounds', 'public');
            $jumbotron->background_image = $backgroundPath;
        }

        // Handle other image upload
        if ($request->hasFile('other_image')) {
            $otherPath = $request->file('other_image')->store('jumbotron/others', 'public');
            $jumbotron->other_image = $otherPath;
        }

        $jumbotron->save();

        return redirect()->route('admin.jumbotron')
                         ->with('success', 'Jumbotron created successfully!');
    }

    public function jumbotronUpdate(Request $request, $id){
        $jumbotron = \App\Models\Jumbotron::findOrFail($id);

        $request->validate([
            'page' => 'required|string|max:255|unique:jumbotrons,page,' . $id,
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'other_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $jumbotron->page = $request->input('page');
        $jumbotron->title = $request->input('title');
        $jumbotron->subtitle = $request->input('subtitle');

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($jumbotron->background_image && \Storage::disk('public')->exists($jumbotron->background_image)) {
                \Storage::disk('public')->delete($jumbotron->background_image);
            }
            $backgroundPath = $request->file('background_image')->store('jumbotron/backgrounds', 'public');
            $jumbotron->background_image = $backgroundPath;
        }

        // Handle other image upload
        if ($request->hasFile('other_image')) {
            // Delete old image if exists
            if ($jumbotron->other_image && \Storage::disk('public')->exists($jumbotron->other_image)) {
                \Storage::disk('public')->delete($jumbotron->other_image);
            }
            $otherPath = $request->file('other_image')->store('jumbotron/others', 'public');
            $jumbotron->other_image = $otherPath;
        }

        $jumbotron->save();

        return redirect()->route('admin.jumbotron')
                         ->with('success', 'Jumbotron updated successfully!');
    }

    public function jumbotronDestroy($id){
        $jumbotron = \App\Models\Jumbotron::findOrFail($id);

        // Delete associated images
        if ($jumbotron->background_image && \Storage::disk('public')->exists($jumbotron->background_image)) {
            \Storage::disk('public')->delete($jumbotron->background_image);
        }
        if ($jumbotron->other_image && \Storage::disk('public')->exists($jumbotron->other_image)) {
            \Storage::disk('public')->delete($jumbotron->other_image);
        }

        $jumbotron->delete();

        return redirect()->route('admin.jumbotron')
                         ->with('success', 'Jumbotron deleted successfully!');
    }
}
