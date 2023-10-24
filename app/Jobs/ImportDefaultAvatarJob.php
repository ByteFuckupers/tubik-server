<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Components\ImportDefaultAvatar;
use App\Models\User;


class ImportDefaultAvatarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $importAvatar = new ImportDefaultAvatar();
        $randomNumber = mt_rand(1, 100000);
        $requestUrl = "?seed=" . $randomNumber;
        $response = $importAvatar->client->request('GET', $requestUrl);
        $svgContent = $response->getBody()->getContents();

        $filename = 'avatar/default/' . $randomNumber . '.svg';
        if (!Storage::disk('public')->exists($filename)) {
            Storage::disk('public')->put($filename, $svgContent);
        }

        User::query()->where(['id' => $this->user->id])->update([
            'image' => $filename,
        ]);
    }
}
