{{-- Example of using global settings in any Blade view --}}

{{-- Method 1: Using the global variable shared by service provider --}}
<h1>{{ $globalSettings->site_name ?? 'Momo Restaurant' }}</h1>
<p>Contact: {{ $globalSettings->contact_email }}</p>
<p>Phone: {{ $globalSettings->contact_phone }}</p>
<p>Hours: {{ $globalSettings->time }}</p>

{{-- Method 2: Using helper functions --}}
<h1>{{ getSetting('site_name', 'Default Restaurant Name') }}</h1>
<p>Contact: {{ getSetting('contact_email') }}</p>

{{-- Method 3: Getting all settings as object --}}
@php $settings = getAllSettings(); @endphp
<p>Address: {{ $settings->address }}</p>

{{-- Example: Display logo if exists --}}
@if ($globalSettings->logo_path)
    <img src="{{ asset('storage/' . $globalSettings->logo_path) }}" alt="{{ $globalSettings->site_name }}" class="logo">
@endif

{{-- Example: Social media links --}}
@if ($globalSettings->facebook_link)
    <a href="{{ $globalSettings->facebook_link }}" target="_blank">
        <i class="fab fa-facebook"></i>
    </a>
@endif

@if ($globalSettings->twitter_link)
    <a href="{{ $globalSettings->twitter_link }}" target="_blank">
        <i class="fab fa-twitter"></i>
    </a>
@endif

@if ($globalSettings->instagram_link)
    <a href="{{ $globalSettings->instagram_link }}" target="_blank">
        <i class="fab fa-instagram"></i>
    </a>
@endif

{{-- Example: Using in JavaScript --}}
<script>
    const siteSettings = {
        siteName: '{{ $globalSettings->site_name ?? 'Default Name' }}',
        contactEmail: '{{ $globalSettings->contact_email }}',
        contactPhone: '{{ $globalSettings->contact_phone }}'
    };

    console.log('Site Name:', siteSettings.siteName);
</script>
