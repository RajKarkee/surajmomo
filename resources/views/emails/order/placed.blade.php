@component('mail::message')
    # 🍽️ New Order Received - #{{ $order->order_code ?? $order->id }}

    **Order placed on:** {{ optional($order->ordered_at ?? $order->created_at)->format('F j, Y \a\t g:i A') }}

    ---

    ## 👤 Customer Information

    **Name:** {{ $order->customer_name ?? 'N/A' }}
    **Phone:** [{{ $order->phone ?? 'N/A' }}](tel:{{ $order->phone ?? '' }})
    **Order Type:** {{ ucfirst($order->order_type ?? 'Personal') }}

    @if (!empty($order->business_name))
        **Business:** {{ $order->business_name }}
    @endif

    **Delivery Address:**
    {{ $order->address ?? 'N/A' }}

    @if (!empty($order->map_coordinates))
        @php
            // Prepare map image and Google Maps link if coordinates are available.
            $mapImageUrl = null;
            $googleMapsUrl = null;
            $appleMapsUrl = null;
            if (!empty($order->map_coordinates)) {
                // expect format: "lat,lng" (with possible spaces)
                $parts = array_map('trim', explode(',', $order->map_coordinates));
                $lat = $parts[0] ?? null;
                $lng = $parts[1] ?? null;
                if ($lat && $lng) {
                    $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($lat . ',' . $lng);
                    $appleMapsUrl = 'https://maps.apple.com/?q=' . urlencode($lat . ',' . $lng);

                    // Prefer Google Static Maps if API key provided in env or services config
                    $gmKey = env('GOOGLE_MAPS_API_KEY') ?: config('services.google_maps.key') ?? null;
                    if ($gmKey) {
                        $mapImageUrl =
                            'https://maps.googleapis.com/maps/api/staticmap?center=' .
                            urlencode($lat . ',' . $lng) .
                            '&zoom=16&size=600x400&scale=2&maptype=roadmap&markers=color:red%7Csize:large%7C' .
                            urlencode($lat . ',' . $lng) .
                            '&key=' .
                            $gmKey;
                    } else {
                        // Enhanced OpenStreetMap static map with better styling
                        $mapImageUrl =
                            'https://maps.geoapify.com/v1/staticmap?style=osm-bright&width=600&height=400&center=lonlat:' .
                            $lng .
                            ',' .
                            $lat .
                            '&zoom=15&marker=lonlat:' .
                            $lng .
                            ',' .
                            $lat .
                            ';color:%23ff0000;size:large&apiKey=demo';
                    }
                }
            }
        @endphp

        ## 📍 Customer Location

        @if ($mapImageUrl && $googleMapsUrl)
            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ $googleMapsUrl }}" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                    <img src="{{ $mapImageUrl }}" alt="Customer delivery location"
                        style="width:100%; max-width:600px; height:auto; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.15); border:2px solid #e1e5e9;">
                </a>
            </div>

            @component('mail::panel')
                **📱 Quick Actions for Delivery:**
                - 🌐 [Open in Google Maps]({{ $googleMapsUrl }})
                - 🍎 [Open in Apple Maps]({{ $appleMapsUrl }})
                - 📞 [Call Customer](tel:{{ $order->phone ?? '' }})
            @endcomponent
        @else
            @component('mail::panel')
                📍 **Location:** Address only (no GPS coordinates provided)
            @endcomponent
        @endif

    @endif

    ---

    ## 🛍️ Order Details

    @php
        // $order->cart is stored as JSON in the migration; ensure we have an array
        $items = [];
        if (is_string($order->cart)) {
            $decoded = json_decode($order->cart, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $items = $decoded;
            }
        } elseif (is_array($order->cart)) {
            $items = $order->cart;
        } elseif ($order->cart instanceof \Illuminate\Support\Collection) {
            $items = $order->cart->toArray();
        }
        $total = 0;
    @endphp

    | **Item** | **Qty** | **Price** | **Subtotal** |
    |:---------|--------:|----------:|-------------:|
    @foreach ($items as $item)
        @php
            $name = $item['name'] ?? ($item['title'] ?? 'Product');
            $qty = isset($item['quantity']) ? (int) $item['quantity'] : (int) ($item['qty'] ?? 1);
            $price = isset($item['price']) ? (float) $item['price'] : (float) ($item['unit_price'] ?? 0);
            $subtotal = $qty * $price;
            $total += $subtotal;
        @endphp
        | **{{ $name }}** | {{ $qty }} | Rs. {{ number_format($price, 2) }} |
        Rs. {{ number_format($subtotal, 2) }} |
    @endforeach
    | | | **TOTAL:** | **Rs. {{ number_format($order->total ?? $total, 2) }}** |

    ---

    @component('mail::button', ['url' => url('/admin/orders')])
        📋 View Order in Admin Panel
    @endcomponent

    ---

    @component('mail::subcopy')
        **Order Summary:**
        - Order ID: #{{ $order->order_code ?? $order->id }}
        - Customer: {{ $order->customer_name }}
        - Total: Rs. {{ number_format($order->total ?? $total, 2) }}
        - Status: ⏳ Pending

        **Next Steps:** Review the order details and begin preparation. Contact the customer if you need any clarifications.
    @endcomponent

    Best regards,<br>
    **{{ config('app.name') }} Order System**
@endcomponent
