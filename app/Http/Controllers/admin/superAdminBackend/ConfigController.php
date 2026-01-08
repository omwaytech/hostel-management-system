<?php

namespace App\Http\Controllers\admin\superAdminBackend;

use App\Http\Controllers\Controller;
use App\Http\Requests\superAdminBackend\ConfigRequest;
use App\Models\SystemConfig;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = SystemConfig::pluck('value', 'key')->toArray();
        return view('admin.superAdminBackend.config.index', compact('configs'));
    }

    public function update(ConfigRequest $request)
    {
        $oldNavbarLogo = SystemConfig::getValue('navbar_logo');
        $oldFooterLogo = SystemConfig::getValue('footer_logo');
        $oldBannerLogo = SystemConfig::getValue('banner_image');
        $oldBackgroundImage = SystemConfig::getValue('background_image');
        $oldAboutImage = SystemConfig::getValue('about_image');

        $fields = [
            'banner_title',
            'banner_subtitle',
            'hostel_listed',
            'happy_customers',
            'trusted_owners',
            'background_title',
            'background_description',
            'active_monthly_users',
            'contact_phone',
            'email_address',
            'physical_address',
            'social_facebook',
            'social_whatsapp',
            'footer_description',
        ];
        if ($request->hasFile('navbar_logo')) {
            $oldNavbarLogoPath = public_path('storage/images/adminConfigImages/' . $oldNavbarLogo);
            if ($oldNavbarLogo && file_exists($oldNavbarLogoPath)) {
                unlink($oldNavbarLogoPath);
            }
            $fileName = time() . '_' . $request->file('navbar_logo')->getClientOriginalName();
            $request->file('navbar_logo')->move(public_path('storage/images/adminConfigImages'), $fileName);
            SystemConfig::setValue('navbar_logo', $fileName);
        }

        if ($request->hasFile('footer_logo')) {
            $oldFooterLogoPath = public_path('storage/images/adminConfigImages/' . $oldFooterLogo);
            if ($oldFooterLogo && file_exists($oldFooterLogoPath)) {
                unlink($oldFooterLogoPath);
            }
            $fileName = time() . '_' . $request->file('footer_logo')->getClientOriginalName();
            $request->file('footer_logo')->move(public_path('storage/images/adminConfigImages'), $fileName);
            SystemConfig::setValue('footer_logo', $fileName);
        }

        if ($request->hasFile('banner_image')) {
            $oldBannerLogoPath = public_path('storage/images/adminConfigImages/' . $oldBannerLogo);
            if ($oldBannerLogo && file_exists($oldBannerLogoPath)) {
                unlink($oldBannerLogoPath);
            }
            $fileName = time() . '_' . $request->file('banner_image')->getClientOriginalName();
            $request->file('banner_image')->move(public_path('storage/images/adminConfigImages'), $fileName);
            SystemConfig::setValue('banner_image', $fileName);
        }

        if ($request->hasFile('background_image')) {
            $oldBackgroundImagePath = public_path('storage/images/adminConfigImages/' . $oldBackgroundImage);
            if ($oldBackgroundImage && file_exists($oldBackgroundImagePath)) {
                unlink($oldBackgroundImagePath);
            }
            $fileName = time() . '_' . $request->file('background_image')->getClientOriginalName();
            $request->file('background_image')->move(public_path('storage/images/adminConfigImages'), $fileName);
            SystemConfig::setValue('background_image', $fileName);
        }

        if ($request->hasFile('about_image')) {
            $oldAboutImagePath = public_path('storage/images/adminConfigImages/' . $oldAboutImage);
            if ($oldAboutImage && file_exists($oldAboutImagePath)) {
                unlink($oldAboutImagePath);
            }
            $fileName = time() . '_' . $request->file('about_image')->getClientOriginalName();
            $request->file('about_image')->move(public_path('storage/images/adminConfigImages'), $fileName);
            SystemConfig::setValue('about_image', $fileName);
        }

        foreach ($fields as $field) {
            SystemConfig::setValue($field, $request->input($field));
        }

        $notification = notificationMessage('success', 'Configuration', 'updated');
        return redirect()->back()->with($notification);
    }
}
