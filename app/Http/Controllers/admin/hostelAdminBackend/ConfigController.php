<?php

namespace App\Http\Controllers\admin\hostelAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\hostelAdminBackend\ConfigRequest;
use App\Models\HostelConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $hostelId = session('current_hostel_id');
        $configs = HostelConfig::where('hostel_id', $hostelId)
        ->pluck('value', 'key')->toArray();
        return view('admin.hostelAdminBackend.config.index', compact('configs'));
    }

    public function update(ConfigRequest $request)
    {
        $hostelId = session('current_hostel_id');
        $oldNavbarLogo = HostelConfig::getValue('navbar_logo', $hostelId);
        $oldFooterLogo = HostelConfig::getValue('footer_logo', $hostelId);
        $fields = [
            'about_title',
            'about_description',
            'google_map_embed',
            'contact_phone_1',
            'contact_phone_2',
            'physical_address',
            'social_whatsapp',
            'social_facebook',
            'social_instagram',
            'footer_description',
        ];
        if ($request->hasFile('navbar_logo')) {
            $oldNavbarLogoPath = public_path('storage/images/hostelConfigImages/' . $oldNavbarLogo);
            if ($oldNavbarLogo && file_exists($oldNavbarLogoPath)) {
                unlink($oldNavbarLogoPath);
            }
            $fileName = time() . '_' . $request->file('navbar_logo')->getClientOriginalName();
            $request->file('navbar_logo')->move(public_path('storage/images/hostelConfigImages'), $fileName);
            HostelConfig::setValue('navbar_logo', $fileName, $hostelId);
        }

        if ($request->hasFile('footer_logo')) {
            $oldFooterLogoPath = public_path('storage/images/hostelConfigImages/' . $oldFooterLogo);
            if ($oldFooterLogo && file_exists($oldFooterLogoPath)) {
                unlink($oldFooterLogoPath);
            }
            $fileName = time() . '_' . $request->file('footer_logo')->getClientOriginalName();
            $request->file('footer_logo')->move(public_path('storage/images/hostelConfigImages'), $fileName);
            HostelConfig::setValue('footer_logo', $fileName, $hostelId);
        }

        foreach ($fields as $field) {
            HostelConfig::setValue($field, $request->input($field), $hostelId);
        }

        $notification = notificationMessage('success', 'Configuration', 'updated');
        return redirect()->back()->with($notification);
    }
}
