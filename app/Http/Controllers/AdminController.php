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
use Illuminate\Support\Facades\Log;

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
            'spice_level' => 'nullable|in:mild,medium,spicy,very_spicy',
            'sort_order' => 'nullable|integer|min:0'
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
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'accent_color' => 'nullable|string|max:7',
            'dark_color' => 'nullable|string|max:7',
            'light_color' => 'nullable|string|max:7',
            'white_color' => 'nullable|string|max:7',
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
        $settings->primary_color = $request->input('primary_color', '#e74c3c');
        $settings->secondary_color = $request->input('secondary_color', '#27ae60');
        $settings->accent_color = $request->input('accent_color', '#8e44ad');
        $settings->dark_color = $request->input('dark_color', '#34495e');
        $settings->light_color = $request->input('light_color', '#ecf0f1');
        $settings->white_color = $request->input('white_color', '#ffffff');

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

    /**
     * Display Why Choose Us management page
     */
    public function whyChooseUs()
    {
        $items = \App\Models\Why_choose_us::latest()->get();
        return view('admin.why_choose_us', compact('items'));
    }

    /**
     * Store a new Why Choose Us item
     */
    public function whyChooseUsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        try {
            $item = new \App\Models\Why_choose_us();
            $item->title = $request->title;
            $item->description = $request->description;
            $item->tagline = $request->tagline;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('why-choose-us', 'public');
                $item->image = $imagePath;
            }

            $item->save();

            return redirect()->route('admin.why_choose_us')
                           ->with('success', 'Reason added successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error adding reason: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Update a Why Choose Us item
     */
    public function whyChooseUsUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tagline' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ]);

        try {
            $item = \App\Models\Why_choose_us::findOrFail($id);
            $item->title = $request->title;
            $item->description = $request->description;
            $item->tagline = $request->tagline;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($item->image && \Storage::disk('public')->exists($item->image)) {
                    \Storage::disk('public')->delete($item->image);
                }

                $imagePath = $request->file('image')->store('why-choose-us', 'public');
                $item->image = $imagePath;
            }

            $item->save();

            return redirect()->route('admin.why_choose_us')
                           ->with('success', 'Reason updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error updating reason: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Delete a Why Choose Us item
     */
    public function whyChooseUsDestroy($id)
    {
        try {
            $item = \App\Models\Why_choose_us::findOrFail($id);

            // Delete associated image
            if ($item->image && \Storage::disk('public')->exists($item->image)) {
                \Storage::disk('public')->delete($item->image);
            }

            $item->delete();

            return redirect()->route('admin.why_choose_us')
                           ->with('success', 'Reason deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting reason: ' . $e->getMessage());
        }
    }
    
    /**
     * Display Customer Testimonials management page
     */
    public function customerTestimonials()
    {
        $testimonials = \App\Models\What_our_customer_say::orderBy('created_at', 'desc')->get();
        return view('admin.what_our_customer_say', compact('testimonials'));
    }

    /**
     * Store a new customer testimonial
     */
    public function customerTestimonialsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_work' => 'nullable|string|max:255',
            'feedback' => 'required|string',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $data = [
                'customer_name' => $request->customer_name,
                'customer_work' => $request->customer_work,
                'feedback' => $request->feedback,
                'rating' => $request->rating
            ];

            // Handle image upload
            if ($request->hasFile('customer_image')) {
                $image = $request->file('customer_image');
                $imageName = time() . '_customer_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('testimonials', $imageName, 'public');
                $data['customer_image'] = $imagePath;
            }

            \App\Models\What_our_customer_say::create($data);

            return redirect()->route('admin.customer_testimonials')
                           ->with('success', 'Customer testimonial added successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error adding testimonial: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Update a customer testimonial
     */
    public function customerTestimonialsUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_work' => 'nullable|string|max:255',
            'feedback' => 'required|string',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|integer|min:1|max:5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $testimonial = \App\Models\What_our_customer_say::findOrFail($id);

            $data = [
                'customer_name' => $request->customer_name,
                'customer_work' => $request->customer_work,
                'feedback' => $request->feedback,
                'rating' => $request->rating
            ];

            // Handle image upload
            if ($request->hasFile('customer_image')) {
                // Delete old image if exists
                if ($testimonial->customer_image && \Storage::disk('public')->exists($testimonial->customer_image)) {
                    \Storage::disk('public')->delete($testimonial->customer_image);
                }

                $image = $request->file('customer_image');
                $imageName = time() . '_customer_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('testimonials', $imageName, 'public');
                $data['customer_image'] = $imagePath;
            }

            $testimonial->update($data);

            return redirect()->route('admin.customer_testimonials')
                           ->with('success', 'Customer testimonial updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error updating testimonial: ' . $e->getMessage());
        }
    }

    /**
     * Delete a customer testimonial
     */
    public function customerTestimonialsDestroy($id)
    {
        try {
            $testimonial = \App\Models\What_our_customer_say::findOrFail($id);

            // Delete associated image
            if ($testimonial->customer_image && \Storage::disk('public')->exists($testimonial->customer_image)) {
                \Storage::disk('public')->delete($testimonial->customer_image);
            }

            $testimonial->delete();

            return redirect()->route('admin.customer_testimonials')
                           ->with('success', 'Customer testimonial deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting testimonial: ' . $e->getMessage());
        }
    }
    public function specialOffers(Request $request, $id = null){
        $offers = \App\Models\Offer::all();
        $offer = null;
        $showForm = false;
        
        if ($id) {
            $offer = \App\Models\Offer::findOrFail($id);
            $showForm = true;
        } elseif ($request->has('create')) {
            $showForm = true;
        }
        
        return view('admin.offer', compact('offers', 'offer', 'showForm'));
    }
    public function specialOffersStore(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $offer = new \App\Models\Offer();
        $offer->title = $request->input('title');
        $offer->description = $request->input('description');
        $offer->start_date= $request->input('start_date');
        $offer->end_date= $request->input('end_date');

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('offers', 'public');
            $offer->image_path = $imagePath;
        }

        $offer->save();

        return redirect()->route('admin.specialOffers')
                         ->with('success', 'Special offer created successfully!');
    }

    public function specialOffersUpdate(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $offer = \App\Models\Offer::findOrFail($id);
        $offer->title = $request->input('title');
        $offer->description = $request->input('description');
        $offer->start_date = $request->input('start_date');
        $offer->end_date = $request->input('end_date');

        // Handle image upload
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists
            if ($offer->image_path) {
                \Storage::disk('public')->delete($offer->image_path);
            }
            $imagePath = $request->file('image_path')->store('offers', 'public');
            $offer->image_path = $imagePath;
        }

        $offer->save();

        return redirect()->route('admin.specialOffers')
                         ->with('success', 'Special offer updated successfully!');
    }

    public function specialOffersDestroy($id){
        try {
            $offer = \App\Models\Offer::findOrFail($id);
            
            // Delete associated image file if it exists
            if ($offer->image_path) {
                \Storage::disk('public')->delete($offer->image_path);
            }
            
            $offer->delete();
            
            return redirect()->route('admin.specialOffers')
                           ->with('success', 'Special offer deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error deleting offer: ' . $e->getMessage());
        }
    }

    public function homeSettings(){
        $homecontrol = DB::table('home_controls')->get();

        return view('admin.homesetting', compact('homecontrol'));
    }

    // Show form to add a new home_control entry
    public function homeSettingsAdd()
    {
        // Pull lists for products and why_choose_us to populate select fields
        $products = Product::orderBy('name')->get(['id', 'name']);
        $why = DB::table('why_choose_uses')->orderBy('title')->get(['id', 'title']);
        return view('admin.homesettingaddd', compact('products', 'why'));
    }

    public function homeSettingsStore(Request $request)
    {
        $request->validate([
            'item' => 'required|string',
            'product_id' => 'nullable|integer|exists:products,id',
            'why_choose_us' => 'nullable|integer|exists:why_choose_uses,id',
            'sort_order' => 'nullable|integer',
        ]);

        $data = [
            'item' => $request->input('item'),
            'product_id' => $request->input('product_id') ?: null,
            'why_choose_us' => $request->input('why_choose_us') ?: null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('home_controls')->insert($data);

        return redirect()->route('admin.home_settings')->with('success', 'Home control entry added');
    }

    // Return JSON data for DataTables
    public function homeSettingsData(Request $request)
    {
        // Log request for debugging DataTables AJAX issues
        Log::info('homeSettingsData called', ['params' => $request->all(), 'ip' => $request->ip()]);

        $query = DB::table('home_controls')
            ->leftJoin('products', 'home_controls.product_id', '=', 'products.id')
            ->leftJoin('why_choose_uses', 'home_controls.why_choose_us', '=', 'why_choose_uses.id')
            ->select('home_controls.*', 'products.name as product_name', 'why_choose_uses.title as why_title');

        // filter by type: product or why
        $type = $request->input('type');
        if ($type === 'product') {
            $query->where(function ($q) {
                $q->where('home_controls.item', 'product')->orWhereNotNull('home_controls.product_id');
            });
        } elseif ($type === 'why') {
            $query->where(function ($q) {
                $q->where('home_controls.item', 'like', '%why%')->orWhereNotNull('home_controls.why_choose_us');
            });
        }

        // DataTables parameters
        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('home_controls.item', 'like', "%{$search}%")
                  ->orWhere('products.name', 'like', "%{$search}%")
                  ->orWhere('why_choose_uses.title', 'like', "%{$search}%");
            });
        }

        try {
            $total = $query->count();
            $data = $query->orderBy('home_controls.id', 'desc')
                          ->offset($start)
                          ->limit($length)
                          ->get();

            Log::info('homeSettingsData result', ['type' => $type, 'total' => $total, 'returned' => count($data)]);

            return response()->json([
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('homeSettingsData error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Show edit form
    public function homeSettingsEdit($id)
    {
        $hc = DB::table('home_controls')->where('id', $id)->first();
        if (! $hc) abort(404);
        $products = Product::orderBy('name')->get(['id', 'name']);
        $why = DB::table('why_choose_uses')->orderBy('title')->get(['id', 'title']);
        return view('admin.homesettingedit', compact('hc', 'products', 'why'));
    }

    // Update
    public function homeSettingsUpdate(Request $request, $id)
    {
        $request->validate([
            'item' => 'required|string',
            'product_id' => 'nullable|integer|exists:products,id',
            'why_choose_us' => 'nullable|integer|exists:why_choose_uses,id',
        ]);

        DB::table('home_controls')->where('id', $id)->update([
            'item' => $request->input('item'),
            'product_id' => $request->input('product_id') ?: null,
            'why_choose_us' => $request->input('why_choose_us') ?: null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.home_settings')->with('success', 'Updated');
    }

    // Delete
    public function homeSettingsDestroy($id)
    {
        DB::table('home_controls')->where('id', $id)->delete();
        return response()->json(['status' => 'ok']);
    }
   
    
}
