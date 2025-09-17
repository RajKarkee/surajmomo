<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;   
use Illuminate\Support\Facades\DB;

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
            'map_link' => 'nullable|url',
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

        // Clear settings cache so global settings get updated
        clearSettingsCache();

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

    public function about(){
        // Get existing about data or create empty object for form
        $about = \App\Models\About::first();
        
        if (!$about) {
            $about = new \App\Models\About();
            // Set default empty values for JSON fields
            $about->what_we_do = [];
            $about->our_mission = [];
            $about->our_story = [];
        }
        
        return view('admin.about', compact('about'));
    }

    public function aboutUpdate(Request $request)
    {
        // Simple validation
        $request->validate([
            'what_we_do_img' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'our_story_img' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        try {
            // Debug: Log what files are being received
            \Log::info('About Update - Files received:', [
                'what_we_do_img' => $request->hasFile('what_we_do_img'),
                'our_story_img' => $request->hasFile('our_story_img'),
                'what_we_do_img_name' => $request->hasFile('what_we_do_img') ? $request->file('what_we_do_img')->getClientOriginalName() : 'none',
                'our_story_img_name' => $request->hasFile('our_story_img') ? $request->file('our_story_img')->getClientOriginalName() : 'none'
            ]);

            // Get or create about record
            $about = About::firstOrNew([]);
            
            // Prepare data for storage with fallbacks
            $whatWeDoData = [
                'title' => $request->input('what_we_do.title', 'What We Do'),
                'lead' => $request->input('what_we_do.lead', 'Default lead text'),
                'features' => $request->input('what_we_do.features', []),
                'stats' => $request->input('what_we_do.stats', []),
            ];

            $ourStoryData = [
                'title' => $request->input('our_story.title', 'Our Story'),
                'content' => $request->input('our_story.content', []),
            ];

            $ourMissionData = [
                'statement' => $request->input('our_mission.statement', 'Default mission'),
                'values' => $request->input('our_mission.values', []),
            ];

            // Handle What We Do image upload
            if ($request->hasFile('what_we_do_img')) {
                \Log::info('Processing what_we_do_img upload');
                
                // Delete old image if exists
                if ($about->what_we_do_img && Storage::disk('public')->exists($about->what_we_do_img)) {
                    Storage::disk('public')->delete($about->what_we_do_img);
                    \Log::info('Deleted old what_we_do_img: ' . $about->what_we_do_img);
                }

                $whatWeDoImage = $request->file('what_we_do_img')->store('about/what-we-do', 'public');
                $about->what_we_do_img = $whatWeDoImage;
                \Log::info('Saved new what_we_do_img: ' . $whatWeDoImage);
            }

            // Handle Our Story image upload
            if ($request->hasFile('our_story_img')) {
                \Log::info('Processing our_story_img upload');
                
                // Delete old image if exists
                if ($about->our_story_img && Storage::disk('public')->exists($about->our_story_img)) {
                    Storage::disk('public')->delete($about->our_story_img);
                    \Log::info('Deleted old our_story_img: ' . $about->our_story_img);
                }

                $ourStoryImage = $request->file('our_story_img')->store('about/our-story', 'public');
                $about->our_story_img = $ourStoryImage;
                \Log::info('Saved new our_story_img: ' . $ourStoryImage);
            }

            // Update the about record
            $about->what_we_do = $whatWeDoData;
            $about->our_story = $ourStoryData;
            $about->our_mission = $ourMissionData;
            
            $saved = $about->save();
            \Log::info('About record saved: ' . ($saved ? 'success' : 'failed'));

            return redirect()->route('admin.about')
                ->with('success', 'About page content updated successfully!');

        } catch (\Exception $e) {
            \Log::error('About update error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while updating: ' . $e->getMessage())
                ->withInput();
        }
    }
    
}
