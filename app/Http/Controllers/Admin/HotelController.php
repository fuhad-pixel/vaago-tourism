<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\HotelRoomRate;
use App\Services\HotelService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    protected $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    /**
     * Display a listing of hotels.
     */
    public function index()
    {
        $hotels = $this->hotelService->getAllHotels();
        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new hotel.
     */
    public function create()
    {
        $destinations = Destination::all();
        $categories = ['3 Star', '4 Star', '5 Star', 'Luxury', 'Premium', 'Budget'];
        return view('admin.hotels.create', compact('destinations', 'categories'));
    }

    /**
     * Store a newly created hotel.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'hotel_name' => 'required|string|max:255',
            'category' => 'required|in:3 Star,4 Star,5 Star,Luxury,Premium,Budget',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'star_rating' => 'nullable|integer|min:1|max:5',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'room_rates' => 'nullable|array',
            'room_rates.*.room_type' => 'required_with:room_rates|string|max:255',
            'room_rates.*.meal_plan' => 'nullable|string|max:255',
            'room_rates.*.season' => 'nullable|string|max:255',
            'room_rates.*.cost_price' => 'required_with:room_rates|numeric|min:0',
            'room_rates.*.selling_price' => 'required_with:room_rates|numeric|min:0',
        ]);

        $this->hotelService->createHotel($data);

        return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
    }

    /**
     * Show the form for editing the hotel.
     */
    public function edit(Hotel $hotel)
    {
        $hotel->load('roomRates');
        $destinations = Destination::all();
        $categories = ['3 Star', '4 Star', '5 Star', 'Luxury', 'Premium', 'Budget'];
        return view('admin.hotels.edit', compact('hotel', 'destinations', 'categories'));
    }

    /**
     * Update the hotel.
     */
    public function update(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'hotel_name' => 'required|string|max:255',
            'category' => 'required|in:3 Star,4 Star,5 Star,Luxury,Premium,Budget',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'star_rating' => 'nullable|integer|min:1|max:5',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $this->hotelService->updateHotel($hotel, $data);

        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
    }

    /**
     * Remove the hotel.
     */
    public function destroy(Hotel $hotel)
    {
        $this->hotelService->deleteHotel($hotel);
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }

    /**
     * Remove hotel image.
     */
    public function deleteImage($id)
    {
        $hotel = Hotel::findOrFail($id);
        if ($this->hotelService->deleteHotelImage($hotel)) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    /**
     * Store a new room rate.
     */
    public function storeRoomRate(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'room_type' => 'required|string|max:255',
            'meal_plan' => 'nullable|string|max:255',
            'season' => 'nullable|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $this->hotelService->addRoomRate($hotel, $data);

        return redirect()->route('hotels.edit', $hotel->id)->with('success', 'Room rate added successfully.');
    }

    /**
     * Remove a room rate.
     */
    public function destroyRoomRate(Hotel $hotel, HotelRoomRate $rate)
    {
        if ($rate->hotel_id !== $hotel->id) {
            abort(403);
        }
        
        $this->hotelService->deleteRoomRate($rate);
        
        return redirect()->route('hotels.edit', $hotel->id)->with('success', 'Room rate deleted successfully.');
    }
}
