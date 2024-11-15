<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([ 'display_name' =>  '(English) عنوان الموقع','display_name_en' => 'Site title (English)', 'key' => 'site_title', 'value' => 'Bloggi System', 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 1]);
        Setting::create([  'display_name' => '(English) شعار الموقع','display_name_en' => 'Site Slogan (English)', 'key' => 'site_slogan', 'value' => 'Amazing blog', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 2]);
        Setting::create([  'display_name' => '(English) وصف الموقع','display_name_en' => 'Site Description (English)', 'key' => 'site_description', 'value' => 'Bloggi Content management system', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 3]);
        Setting::create([  'display_name' => '(English) الكلمات المفتاحية','display_name_en' => 'Site Keywords (English)', 'key' => 'site_keywords', 'value' => 'Bloggi, blog, multi writer', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 4]);
        Setting::create([  'display_name' => '(English) ايميل الموقع','display_name_en' => 'Site Email (English)', 'key' => 'site_email', 'value' => 'admin@bloggi.test', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 5]);
        Setting::create([  'display_name' => '(English) حالة الموقع','display_name_en' => 'Site Status (English)', 'key' => 'site_status', 'value' => 'Active', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 6]);
        Setting::create([  'display_name' => '(English) اسم الاداري','display_name_en' => 'Admin Title (English)', 'key' => 'admin_title', 'value' => 'Bloggi', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 7]);
        Setting::create([  'display_name' => '(English) رقم الهاتف','display_name_en' => 'Phone Number (English)', 'key' => 'phone_number', 'value' => '05123456789', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 8]);
        Setting::create([  'display_name' => '(English) العنوان', 'display_name_en' => 'Address (English)', 'key' => 'address', 'value' => 'M57F+QM King Abdulaziz International Airport, Jeddah', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 9]);
        Setting::create([  'display_name' => '(English) خط العرض الخريطة','display_name_en' => 'Map Latitude (English)', 'key' => 'address_latitude', 'value' => '21.671914', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 10]);
        Setting::create([  'display_name' => '(English) خط الطول الخريطة','display_name_en' => 'Map Longitude (English)', 'key' => 'address_longitude', 'value' => '39.173875', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'en', 'ordering' => 11]);
        Setting::create([ 'display_name' => 'Google Maps API Key (English)', 'display_name_en' => 'Google Maps API Key (English)', 'key' => 'google_maps_api_key', 'value' => null, 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 1]);
        Setting::create([ 'display_name' => 'Google Recaptcha API Key (English)', 'display_name_en' => 'Google Recaptcha API Key (English)', 'key' => 'google_recaptcha_api_key', 'value' => null, 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 2]);
        Setting::create([ 'display_name' => 'Google Analytics Client ID (English)', 'display_name_en' => 'Google Analytics Client ID (English)', 'key' => 'google_analytics_client_id', 'value' => null, 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 3]);
        Setting::create([ 'display_name' => 'Facebook معرف (English)',  'display_name_en' => 'Facebook ID (English)', 'key' => 'facebook_id', 'value' => 'https://www.facebook.com/mindscms123', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 4]);
        Setting::create([ 'display_name' => 'Twitter معرف (English)',  'display_name_en' => 'Twitter ID (English)', 'key' => 'twitter_id', 'value' => 'https://twitter.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 5]);
        Setting::create([ 'display_name' => 'Instagram معرف (English)',  'display_name_en' => 'Instagram ID (English)', 'key' => 'instagram_id', 'value' => 'https://instagram.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 6]);
        Setting::create([ 'display_name' => 'Patreon معرف (English)',  'display_name_en' => 'Patreon ID (English)', 'key' => 'flickr_id', 'value' => 'https://www.patreon.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 7]);
        Setting::create([ 'display_name' => 'Youtube معرف (English)',  'display_name_en' => 'Youtube ID (English)', 'key' => 'youtube_id', 'value' => 'https://www.youtube.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'en', 'ordering' => 8]);


        Setting::create([ 'display_name' =>  '(عربي) عنوان الموقع','display_name_en' => 'Site title (عربي)', 'key' => 'site_title', 'value' => 'Bloggi System', 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 1]);
        Setting::create([  'display_name' => '(عربي) شعار الموقع','display_name_en' => 'Site Slogan (عربي)', 'key' => 'site_slogan', 'value' => 'Amazing blog', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 2]);
        Setting::create([  'display_name' => '(عربي) وصف الموقع','display_name_en' => 'Site Description (عربي)', 'key' => 'site_description', 'value' => 'Bloggi Content management system', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 3]);
        Setting::create([  'display_name' => '(عربي) الكلمات المفتاحية','display_name_en' => 'Site Keywords (عربي)', 'key' => 'site_keywords', 'value' => 'Bloggi, blog, multi writer', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 4]);
        Setting::create([  'display_name' => '(عربي) ايميل الموقع','display_name_en' => 'Site Email (عربي)', 'key' => 'site_email', 'value' => 'admin@bloggi.test', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 5]);
        Setting::create([  'display_name' => '(عربي) حالة الموقع','display_name_en' => 'Site Status (عربي)', 'key' => 'site_status', 'value' => 'Active', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 6]);
        Setting::create([  'display_name' => '(عربي) اسم الاداري','display_name_en' => 'Admin Title (عربي)', 'key' => 'admin_title', 'value' => 'Bloggi', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 7]);
        Setting::create([  'display_name' => '(عربي) رقم الهاتف','display_name_en' => 'Phone Number (عربي)', 'key' => 'phone_number', 'value' => '05123456789', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 8]);
        Setting::create([  'display_name' => '(عربي) العنوان', 'display_name_en' => 'Address (عربي)', 'key' => 'address', 'value' => 'M57F+QM King Abdulaziz International Airport, Jeddah', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 9]);
        Setting::create([  'display_name' => '(عربي) خط العرض الخريطة','display_name_en' => 'Map Latitude (عربي)', 'key' => 'address_latitude', 'value' => '21.671914', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 10]);
        Setting::create([  'display_name' => '(عربي) خط الطول الخريطة','display_name_en' => 'Map Longitude (عربي)', 'key' => 'address_longitude', 'value' => '39.173875', 'details' => null, 'type' => 'text', 'section' => 'general','lang' => 'ar', 'ordering' => 11]);
        Setting::create([ 'display_name' => 'Google Maps API Key (عربي)', 'display_name_en' => 'Google Maps API Key (عربي)', 'key' => 'google_maps_api_key', 'value' => null, 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 1]);
        Setting::create([ 'display_name' => 'Google Recaptcha API Key (عربي)', 'display_name_en' => 'Google Recaptcha API Key (عربي)', 'key' => 'google_recaptcha_api_key', 'value' => null, 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 2]);
        Setting::create([ 'display_name' => 'Google Analytics Client ID (عربي)', 'display_name_en' => 'Google Analytics Client ID (عربي)', 'key' => 'google_analytics_client_id', 'value' => null, 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 3]);
        Setting::create([ 'display_name' => 'Facebook معرف (عربي)',  'display_name_en' => 'Facebook ID (عربي)', 'key' => 'facebook_id', 'value' => 'https://www.facebook.com/mindscms123', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 4]);
        Setting::create([ 'display_name' => 'Twitter معرف (عربي)',  'display_name_en' => 'Twitter ID (عربي)', 'key' => 'twitter_id', 'value' => 'https://twitter.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 5]);
        Setting::create([ 'display_name' => 'Instagram معرف (عربي)',  'display_name_en' => 'Instagram ID (عربي)', 'key' => 'instagram_id', 'value' => 'https://instagram.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 6]);
        Setting::create([ 'display_name' => 'Patreon معرف (عربي)',  'display_name_en' => 'Patreon ID (عربي)', 'key' => 'flickr_id', 'value' => 'https://www.patreon.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 7]);
        Setting::create([ 'display_name' => 'Youtube معرف (عربي)',  'display_name_en' => 'Youtube ID (عربي)', 'key' => 'youtube_id', 'value' => 'https://www.youtube.com/mindscms', 'details' => null, 'type' => 'text', 'section' => 'social_accounts','lang' => 'ar', 'ordering' => 8]);

    }
}
