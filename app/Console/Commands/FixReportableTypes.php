<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Report;

class FixReportableTypes extends Command
{
    protected $signature = 'fix:reportable-types';
    protected $description = 'Fix reportable_type values in the reports table';

    public function handle()
    {
        $this->info('Fixing reportable_type values in the reports table...');

        Report::where('reportable_type', 'post')
            ->update(['reportable_type' => \App\Models\Post::class]);

        Report::where('reportable_type', 'comment')
            ->update(['reportable_type' => \App\Models\Comment::class]);

        $this->info('Reportable types fixed successfully!');
    }
}