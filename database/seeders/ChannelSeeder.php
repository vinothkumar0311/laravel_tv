<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::firstOrCreate(['name' => 'General']);

        $channels = [
            [
                'name' => 'RPlus Tv',
                'stream_url' => 'https://stream.wsplcloud.com/rplustv/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=RPlus',
            ],
            [
                'name' => 'T Tv',
                'stream_url' => 'https://stream.wsplcloud.com/ttvhd/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=T+TV',
            ],
            [
                'name' => 'Sai tv',
                'stream_url' => 'https://stream.wsplcloud.com/saitvhd/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=Sai',
            ],
            [
                'name' => 'Velavan Tv',
                'stream_url' => 'https://stream.wsplcloud.com/velavantv/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=Velavan',
            ],
            [
                'name' => 'Udhaya Tv',
                'stream_url' => 'https://stream.wsplcloud.com/udhaya/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=Udhaya',
            ],
            [
                'name' => 'PCN Tv',
                'stream_url' => 'https://stream.wsplcloud.com/pcntv/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=PCN',
            ],
            [
                'name' => 'Tirumal Tv',
                'stream_url' => 'https://stream.wsplcloud.com/tirumaltv/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=Tirumal',
            ],
            [
                'name' => 'Tenral Tv',
                'stream_url' => 'https://stream.wsplcloud.com/tenraltv/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=Tenral',
            ],
            [
                'name' => 'Thankam Tv',
                'stream_url' => 'https://stream.wsplcloud.com/thankamtv/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=Thankam',
            ],
            [
                'name' => 'Surya Tv',
                'stream_url' => 'https://stream.wsplcloud.com/suryatv/index.m3u8',
                'logo' => 'https://placehold.jp/150x150.png?text=Surya',
            ],
        ];

        foreach ($channels as $channelData) {
            Channel::create([
                'category_id' => $category->id,
                'name' => $channelData['name'],
                'description' => 'Live streaming of ' . $channelData['name'],
                'logo' => $channelData['logo'],
                'stream_url' => $channelData['stream_url'],
                'type' => 'live',
                'status' => true,
                'is_premium' => false,
            ]);
        }
    }
}
