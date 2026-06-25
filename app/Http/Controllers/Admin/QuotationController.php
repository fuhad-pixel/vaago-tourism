<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        $quotations = \App\Models\Quotation::with('lead')->orderBy('id', 'desc')->get();
        return view('admin.quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new quotation.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $leads = \App\Models\Lead::all();
        $inclusions = \App\Models\AdditionalInclusion::all();
        $exclusions = \App\Models\AdditionalExclusion::all();
        $activities = \App\Models\Activity::all();
        $meals = \App\Models\Meal::all();
        $vehicles = \App\Models\Vehicle::all();
        $drivers = \App\Models\Driver::all();
        $hotels = \App\Models\Hotel::with('roomRates')->get();
        $destinations = \App\Models\Destination::all();
        $categories = \App\Models\Category::all(); // If highlights use categories or destinations

        return view('admin.quotations.create', compact(
            'leads',
            'inclusions',
            'exclusions',
            'activities',
            'meals',
            'vehicles',
            'drivers',
            'hotels',
            'destinations',
            'categories'
        ));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'status' => 'nullable|string',
            'currency' => 'nullable|string',
            'title' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'adults' => 'nullable|integer',
            'children' => 'nullable|integer',
            'infants' => 'nullable|integer',
            'days' => 'required',
            'terms_and_conditions' => 'nullable|string',
        ]);

        \DB::beginTransaction();
        try {
            $daysArray = is_string($request->days) ? json_decode($request->days, true) : $request->days;

            // Calculate totals
            $totalHotel = 0;
            $totalVehicle = 0;
            $totalActivity = 0;
            $extraCharges = 0;
            $discount = 0;
            $inclusions = [];
            $exclusions = [];

            foreach ($daysArray as $dayData) {
                $totalHotel += (float) ($dayData['hotelCost'] ?? 0);
                $totalVehicle += (float) ($dayData['vehicleCost'] ?? 0);
                $extraCharges += (float) ($dayData['extraCharges'] ?? 0);
                $discount += (float) ($dayData['discount'] ?? 0);

                if (isset($dayData['activities']) && is_array($dayData['activities'])) {
                    foreach ($dayData['activities'] as $act) {
                        $totalActivity += (float) ($act['cost'] ?? 0);
                    }
                }

                if (isset($dayData['inclusions']) && is_array($dayData['inclusions'])) {
                    $inclusions = array_merge($inclusions, $dayData['inclusions']);
                }

                if (isset($dayData['exclusions']) && is_array($dayData['exclusions'])) {
                    $exclusions = array_merge($exclusions, $dayData['exclusions']);
                }
            }

            $inclusions = array_values(array_unique($inclusions));
            $exclusions = array_values(array_unique($exclusions));

            $masterInclusions = \App\Models\AdditionalInclusion::pluck('name')->toArray();
            $masterExclusions = \App\Models\AdditionalExclusion::pluck('name')->toArray();

            $inclusions = array_values(array_intersect($inclusions, $masterInclusions));
            $exclusions = array_values(array_intersect($exclusions, $masterExclusions));

            $subTotal = $totalHotel + $totalVehicle + $totalActivity + $extraCharges - $discount;
            $gstPercentage = 5.00; // Can be fetched from company settings
            $gstAmount = round($subTotal * ($gstPercentage / 100), 2);
            $grandTotal = $subTotal + $gstAmount;

            $bannerImagePath = null;
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $filename = time() . '_' . \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/quotation_banner'), $filename);
                $bannerImagePath = 'uploads/quotation_banner/' . $filename;
            }

            // Generate a unique quotation code
            do {
                $code = 'VAAGO-' . strtoupper(\Illuminate\Support\Str::random(5));
            } while (\App\Models\Quotation::where('quotation_code', $code)->exists());

            $quotation = \App\Models\Quotation::create([
                'quotation_code' => $code,
                'lead_id' => $validated['lead_id'],
                'status' => $validated['status'] ?? 'Draft',
                'currency' => $validated['currency'] ?? 'INR',
                'title' => $validated['title'] ?? null,
                'banner_image' => $bannerImagePath,
                'adults' => $validated['adults'] ?? 0,
                'children' => $validated['children'] ?? 0,
                'infants' => $validated['infants'] ?? 0,
                'total_hotel_cost' => $totalHotel,
                'total_vehicle_cost' => $totalVehicle,
                'total_activity_cost' => $totalActivity,
                'extra_charges' => $extraCharges,
                'discount' => $discount,
                'sub_total' => $subTotal,
                'gst_percentage' => $gstPercentage,
                'gst_amount' => $gstAmount,
                'grand_total' => $grandTotal,
                'inclusions' => $inclusions,
                'exclusions' => $exclusions,
                'terms_and_conditions' => $validated['terms_and_conditions'] ?? null,
            ]);

            foreach ($daysArray as $dayData) {
                $dayImages = $dayData['images'] ?? ['destination' => [], 'custom' => []];
                $dayImages = $this->saveBase64Images($dayImages);

                \App\Models\QuotationDay::create([
                    'quotation_id' => $quotation->id,
                    'day_number' => $dayData['dayNumber'] ?? 1,
                    'date' => !empty($dayData['date']) ? $dayData['date'] : null,
                    'title' => $dayData['dayTitle'] ?? null,
                    'start_point' => $dayData['startPoint'] ?? null,
                    'start_point_id' => !empty($dayData['startPointId']) ? $dayData['startPointId'] : null,
                    'end_point' => $dayData['endPoint'] ?? null,
                    'end_point_id' => !empty($dayData['endPointId']) ? $dayData['endPointId'] : null,
                    'distance' => !empty($dayData['distance']) ? (int) $dayData['distance'] : 0,
                    'travel_time' => $dayData['travelTime'] ?? null,
                    'description' => $dayData['description'] ?? null,
                    'hotel_id' => !empty($dayData['hotelId']) ? $dayData['hotelId'] : null,
                    'hotel_name' => $dayData['hotelName'] ?? null,
                    'room_type_id' => !empty($dayData['roomTypeId']) ? $dayData['roomTypeId'] : null,
                    'room_type_name' => $dayData['roomTypeName'] ?? null,
                    'hotel_cost' => !empty($dayData['hotelCost']) ? (float) $dayData['hotelCost'] : 0,
                    'vehicle_name' => $dayData['vehicle'] ?? null,
                    'driver_name' => $dayData['driverName'] ?? null,
                    'driver_mobile' => $dayData['driverMobile'] ?? null,
                    'pickup_location' => $dayData['pickupLocation'] ?? null,
                    'drop_location' => $dayData['dropLocation'] ?? null,
                    'km_included' => !empty($dayData['kmIncluded']) ? (int) $dayData['kmIncluded'] : 0,
                    'extra_km_charge' => !empty($dayData['extraKmCharge']) ? (float) $dayData['extraKmCharge'] : 0,
                    'vehicle_cost' => !empty($dayData['vehicleCost']) ? (float) $dayData['vehicleCost'] : 0,
                    'extra_charges' => !empty($dayData['extraCharges']) ? (float) $dayData['extraCharges'] : 0,
                    'discount' => !empty($dayData['discount']) ? (float) $dayData['discount'] : 0,
                    'highlights' => $dayData['highlights'] ?? [],
                    'activities' => $dayData['activities'] ?? [],
                    'meals' => $dayData['meals'] ?? [],
                    'images' => $dayImages,
                ]);
            }

            \DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quotation saved successfully.',
                    'quotation_id' => $quotation->id
                ]);
            }

            return redirect('/admin/quotations')->with('success', 'Quotation saved successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save quotation: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to save quotation: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $quotation = \App\Models\Quotation::with('days')->findOrFail($id);

        $masterInclusions = \App\Models\AdditionalInclusion::pluck('name')->toArray();
        $masterExclusions = \App\Models\AdditionalExclusion::pluck('name')->toArray();

        $filteredInclusions = array_values(array_intersect($quotation->inclusions ?? [], $masterInclusions));
        $filteredExclusions = array_values(array_intersect($quotation->exclusions ?? [], $masterExclusions));

        $savedHighlights = $quotation->days->pluck('highlights')->flatten()->unique()->values()->toArray();

        $leads = \App\Models\Lead::all();
        $inclusions = \App\Models\AdditionalInclusion::all();
        $exclusions = \App\Models\AdditionalExclusion::all();
        $activities = \App\Models\Activity::all();
        $meals = \App\Models\Meal::all();
        $vehicles = \App\Models\Vehicle::all();
        $drivers = \App\Models\Driver::all();
        $hotels = \App\Models\Hotel::with('roomRates')->get();
        $destinations = \App\Models\Destination::all();
        $categories = \App\Models\Category::all();

        $formattedDays = $quotation->days->map(function ($day) use ($quotation, $filteredInclusions, $filteredExclusions) {
            $hotelImage = '';
            $hotelReviews = '';
            if ($day->hotel_id) {
                $hotel = \App\Models\Hotel::find($day->hotel_id);
                if ($hotel) {
                    $hotelImage = $hotel->image ? '/' . $hotel->image : '';
                    $hotelReviews = $hotel->category . ' | ' . ($hotel->star_rating ?? 3) . ' Star';
                }
            }
            return [
                'dayNumber' => $day->day_number,
                'date' => $day->date ? $day->date->format('Y-m-d') : '',
                'startPoint' => $day->start_point ?? '',
                'startPointId' => $day->start_point_id ?? '',
                'endPoint' => $day->end_point ?? '',
                'endPointId' => $day->end_point_id ?? '',
                'distance' => $day->distance ?? 0,
                'travelTime' => $day->travel_time ?? '',
                'dayTitle' => $day->title ?? '',
                'description' => $day->description ?? '',
                'hotelId' => $day->hotel_id ?? '',
                'hotelName' => $day->hotel_name ?? '',
                'hotelImage' => $hotelImage,
                'hotelReviews' => $hotelReviews,
                'roomTypeId' => $day->room_type_id ?? '',
                'roomTypeName' => $day->room_type_name ?? '',
                'highlights' => $day->highlights ?? [],
                'activities' => $day->activities ?? [],
                'imagesTab' => 'destination',
                'images' => $day->images ?? ['destination' => [], 'custom' => []],
                'vehicleId' => '',
                'vehicle' => $day->vehicle_name ?? '',
                'driverId' => '',
                'driverName' => $day->driver_name ?? '',
                'driverMobile' => $day->driver_mobile ?? '',
                'pickupLocation' => $day->pickup_location ?? '',
                'dropLocation' => $day->drop_location ?? '',
                'kmIncluded' => $day->km_included ?? 0,
                'extraKmCharge' => $day->extra_km_charge ?? 0,
                'vehicleCost' => (float)$day->vehicle_cost,
                'hotelCost' => (float)$day->hotel_cost,
                'extraCharges' => (float)$day->extra_charges,
                'discount' => (float)$day->discount,
                'meals' => $day->meals ?? [],
                'inclusions' => $filteredInclusions,
                'exclusions' => $filteredExclusions
            ];
        })->toArray();

        if (empty($formattedDays)) {
            $formattedDays = [
                [
                    'dayNumber' => 1,
                    'date' => '',
                    'startPoint' => '',
                    'startPointId' => '',
                    'endPoint' => '',
                    'endPointId' => '',
                    'distance' => 0,
                    'travelTime' => '',
                    'dayTitle' => '',
                    'description' => '',
                    'hotelId' => '',
                    'hotelName' => '',
                    'roomTypeId' => '',
                    'roomTypeName' => '',
                    'highlights' => [],
                    'activities' => [],
                    'imagesTab' => 'destination',
                    'images' => ['destination' => [], 'custom' => []],
                    'vehicleId' => '',
                    'vehicle' => '',
                    'driverId' => '',
                    'driverName' => '',
                    'driverMobile' => '',
                    'pickupLocation' => '',
                    'dropLocation' => '',
                    'kmIncluded' => 0,
                    'extraKmCharge' => 0,
                    'meals' => [],
                    'hotelCost' => 0,
                    'vehicleCost' => 0,
                    'extraCharges' => 0,
                    'discount' => 0,
                    'inclusions' => $filteredInclusions,
                    'exclusions' => $filteredExclusions
                ]
            ];
        }

        return view('admin.quotations.edit', compact(
            'quotation',
            'formattedDays',
            'leads',
            'inclusions',
            'exclusions',
            'activities',
            'meals',
            'vehicles',
            'drivers',
            'hotels',
            'destinations',
            'categories',
            'savedHighlights'
        ));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'status' => 'nullable|string',
            'currency' => 'nullable|string',
            'title' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'adults' => 'nullable|integer',
            'children' => 'nullable|integer',
            'infants' => 'nullable|integer',
            'days' => 'required',
            'terms_and_conditions' => 'nullable|string',
        ]);

        \DB::beginTransaction();
        try {
            $quotation = \App\Models\Quotation::findOrFail($id);
            $daysArray = is_string($request->days) ? json_decode($request->days, true) : $request->days;

            $totalHotel = 0;
            $totalVehicle = 0;
            $totalActivity = 0;
            $extraCharges = 0;
            $discount = 0;
            $inclusions = [];
            $exclusions = [];

            foreach ($daysArray as $dayData) {
                $totalHotel += (float) ($dayData['hotelCost'] ?? 0);
                $totalVehicle += (float) ($dayData['vehicleCost'] ?? 0);
                $extraCharges += (float) ($dayData['extraCharges'] ?? 0);
                $discount += (float) ($dayData['discount'] ?? 0);

                if (isset($dayData['activities']) && is_array($dayData['activities'])) {
                    foreach ($dayData['activities'] as $act) {
                        $totalActivity += (float) ($act['cost'] ?? 0);
                    }
                }

                if (isset($dayData['inclusions']) && is_array($dayData['inclusions'])) {
                    $inclusions = array_merge($inclusions, $dayData['inclusions']);
                }

                if (isset($dayData['exclusions']) && is_array($dayData['exclusions'])) {
                    $exclusions = array_merge($exclusions, $dayData['exclusions']);
                }
            }

            $inclusions = array_values(array_unique($inclusions));
            $exclusions = array_values(array_unique($exclusions));

            $masterInclusions = \App\Models\AdditionalInclusion::pluck('name')->toArray();
            $masterExclusions = \App\Models\AdditionalExclusion::pluck('name')->toArray();

            $inclusions = array_values(array_intersect($inclusions, $masterInclusions));
            $exclusions = array_values(array_intersect($exclusions, $masterExclusions));

            $subTotal = $totalHotel + $totalVehicle + $totalActivity + $extraCharges - $discount;
            $gstPercentage = 5.00;
            $gstAmount = round($subTotal * ($gstPercentage / 100), 2);
            $grandTotal = $subTotal + $gstAmount;

            $bannerImagePath = $quotation->banner_image;
            if ($request->hasFile('banner_image')) {
                if ($quotation->banner_image && file_exists(public_path($quotation->banner_image))) {
                    @unlink(public_path($quotation->banner_image));
                }
                $file = $request->file('banner_image');
                $filename = time() . '_' . \Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/quotation_banner'), $filename);
                $bannerImagePath = 'uploads/quotation_banner/' . $filename;
            }

            $quotation->update([
                'lead_id' => $validated['lead_id'],
                'status' => $validated['status'] ?? 'Draft',
                'currency' => $validated['currency'] ?? 'INR',
                'title' => $validated['title'] ?? null,
                'banner_image' => $bannerImagePath,
                'adults' => $validated['adults'] ?? 0,
                'children' => $validated['children'] ?? 0,
                'infants' => $validated['infants'] ?? 0,
                'total_hotel_cost' => $totalHotel,
                'total_vehicle_cost' => $totalVehicle,
                'total_activity_cost' => $totalActivity,
                'extra_charges' => $extraCharges,
                'discount' => $discount,
                'sub_total' => $subTotal,
                'gst_percentage' => $gstPercentage,
                'gst_amount' => $gstAmount,
                'grand_total' => $grandTotal,
                'inclusions' => $inclusions,
                'exclusions' => $exclusions,
                'terms_and_conditions' => $validated['terms_and_conditions'] ?? null,
            ]);

            // Clear old days
            \App\Models\QuotationDay::where('quotation_id', $quotation->id)->delete();

            // Create new days
            foreach ($daysArray as $dayData) {
                $dayImages = $dayData['images'] ?? ['destination' => [], 'custom' => []];
                $dayImages = $this->saveBase64Images($dayImages);

                \App\Models\QuotationDay::create([
                    'quotation_id' => $quotation->id,
                    'day_number' => $dayData['dayNumber'] ?? 1,
                    'date' => !empty($dayData['date']) ? $dayData['date'] : null,
                    'title' => $dayData['dayTitle'] ?? null,
                    'start_point' => $dayData['startPoint'] ?? null,
                    'start_point_id' => !empty($dayData['startPointId']) ? $dayData['startPointId'] : null,
                    'end_point' => $dayData['endPoint'] ?? null,
                    'end_point_id' => !empty($dayData['endPointId']) ? $dayData['endPointId'] : null,
                    'distance' => !empty($dayData['distance']) ? (int) $dayData['distance'] : 0,
                    'travel_time' => $dayData['travelTime'] ?? null,
                    'description' => $dayData['description'] ?? null,
                    'hotel_id' => !empty($dayData['hotelId']) ? $dayData['hotelId'] : null,
                    'hotel_name' => $dayData['hotelName'] ?? null,
                    'room_type_id' => !empty($dayData['roomTypeId']) ? $dayData['roomTypeId'] : null,
                    'room_type_name' => $dayData['roomTypeName'] ?? null,
                    'hotel_cost' => !empty($dayData['hotelCost']) ? (float) $dayData['hotelCost'] : 0,
                    'vehicle_name' => $dayData['vehicle'] ?? null,
                    'driver_name' => $dayData['driverName'] ?? null,
                    'driver_mobile' => $dayData['driverMobile'] ?? null,
                    'pickup_location' => $dayData['pickupLocation'] ?? null,
                    'drop_location' => $dayData['dropLocation'] ?? null,
                    'km_included' => !empty($dayData['kmIncluded']) ? (int) $dayData['kmIncluded'] : 0,
                    'extra_km_charge' => !empty($dayData['extraKmCharge']) ? (float) $dayData['extraKmCharge'] : 0,
                    'vehicle_cost' => !empty($dayData['vehicleCost']) ? (float) $dayData['vehicleCost'] : 0,
                    'extra_charges' => !empty($dayData['extraCharges']) ? (float) $dayData['extraCharges'] : 0,
                    'discount' => !empty($dayData['discount']) ? (float) $dayData['discount'] : 0,
                    'highlights' => $dayData['highlights'] ?? [],
                    'activities' => $dayData['activities'] ?? [],
                    'meals' => $dayData['meals'] ?? [],
                    'images' => $dayImages,
                ]);
            }

            \DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quotation updated successfully.',
                    'quotation_id' => $quotation->id
                ]);
            }

            return redirect('/admin/quotations')->with('success', 'Quotation updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update quotation: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Failed to update quotation: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            $quotation = \App\Models\Quotation::findOrFail($id);
            \App\Models\QuotationDay::where('quotation_id', $quotation->id)->delete();
            $quotation->delete();
            \DB::commit();
            return redirect('/admin/quotations')->with('success', 'Quotation deleted successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete quotation: ' . $e->getMessage());
        }
    }

    public function showPublic($lead_name, $quotation_code)
    {
        $quotation = \App\Models\Quotation::with(['days', 'lead'])->where('quotation_code', $quotation_code)->first();
        
        if (!$quotation && is_numeric($quotation_code)) {
            $quotation = \App\Models\Quotation::with(['days', 'lead'])->find($quotation_code);
        }

        if (!$quotation) {
            abort(404, 'Quotation not found.');
        }

        $vehicleNames = $quotation->days->pluck('vehicle_name')->filter()->unique();
        $vehicles = \App\Models\Vehicle::whereIn('vehicle_name', $vehicleNames)->get();

        $hotelIds = $quotation->days->pluck('hotel_id')->filter()->unique();
        $hotelsMap = \App\Models\Hotel::whereIn('id', $hotelIds)->get()->keyBy('id');

        return view('pages.quotation_public', compact('quotation', 'vehicles', 'hotelsMap'));
    }

    public function sendMail(Request $request, $id)
    {
        $quotation = \App\Models\Quotation::with(['days', 'lead'])->findOrFail($id);

        if (!$quotation->lead || !$quotation->lead->email) {
            return redirect()->back()->with('error', 'Failed to send mail: This quotation does not have an associated lead with a valid email address.');
        }

        // Configure SMTP dynamically from the database
        $smtp = \App\Models\SmtpSetting::first();
        if ($smtp && $smtp->mail_host) {
            config([
                'mail.mailers.smtp.transport' => $smtp->mail_mailer ?? 'smtp',
                'mail.mailers.smtp.host' => $smtp->mail_host,
                'mail.mailers.smtp.port' => $smtp->mail_port,
                'mail.mailers.smtp.username' => $smtp->mail_username,
                'mail.mailers.smtp.password' => $smtp->mail_password,
                'mail.mailers.smtp.encryption' => $smtp->mail_encryption,
                'mail.from.address' => $smtp->mail_from_address,
                'mail.from.name' => $smtp->mail_from_name,
            ]);
            \Illuminate\Support\Facades\Mail::purge('smtp');
        } else {
            \Log::warning('SMTP settings in database are empty. Using Laravel defaults.');
        }

        // Generate public URL
        $leadNameSlug = \Str::slug($quotation->lead->name ?? 'guest');
        $publicUrl = route('quotations.public', [
            'lead_name' => $leadNameSlug,
            'quotation_code' => $quotation->quotation_code ?? $quotation->id
        ]);

        $companySetting = \App\Models\CompanySetting::first() ?? new \App\Models\CompanySetting();

        try {
            \Illuminate\Support\Facades\Mail::to($quotation->lead->email)->send(
                new \App\Mail\QuotationMail($quotation, $companySetting, $publicUrl)
            );

            // Update status to Sent
            $quotation->update(['status' => 'Sent']);

            return redirect('/admin/quotations')->with('success', 'Quotation email sent successfully to ' . $quotation->lead->email);
        } catch (\Exception $e) {
            \Log::error('Quotation mail sending failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Mail sending failed: ' . $e->getMessage() . '. Please verify your SMTP settings.');
        }
    }

    private function saveBase64Images(array $images)
    {
        $processed = [];
        foreach ($images as $tab => $urls) {
            $processed[$tab] = [];
            if (is_array($urls)) {
                foreach ($urls as $url) {
                    if (is_string($url) && str_starts_with($url, 'data:image/')) {
                        if (preg_match('/^data:image\/(\w+);base64,/', $url, $type)) {
                            $data = substr($url, strpos($url, ',') + 1);
                            $extension = strtolower($type[1]);
                            if (!in_array($extension, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                                $extension = 'png';
                            }
                            $data = base64_decode($data);
                            if ($data !== false) {
                                $filename = time() . '_' . uniqid() . '.' . $extension;
                                $directory = public_path('uploads/quotation_gallery');
                                if (!file_exists($directory)) {
                                    mkdir($directory, 0755, true);
                                }
                                file_put_contents($directory . '/' . $filename, $data);
                                $processed[$tab][] = '/uploads/quotation_gallery/' . $filename;
                            } else {
                                $processed[$tab][] = $url;
                            }
                        } else {
                            $processed[$tab][] = $url;
                        }
                    } else {
                        $processed[$tab][] = $url;
                    }
                }
            }
        }
        return $processed;
    }
}
