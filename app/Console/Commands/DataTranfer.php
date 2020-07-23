<?php

namespace App\Console\Commands;

use App\Services\DataTransfer\ArticleService;
use App\Services\DataTransfer\MemberService;
use Illuminate\Console\Command;

class DataTranfer extends Command
{
    private MemberService $memberService;

    private ArticleService $articleService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @param MemberService $memberService
     * @param ArticleService $articleService
     */
    public function __construct(
        MemberService $memberService,
        ArticleService $articleService
    ) {
        parent::__construct();
        $this->memberService = $memberService;
        $this->articleService = $articleService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->memberService->dataTransfer();
        $this->articleService->dataTransfer();
        $this->info('Data Transfer is completed');
    }
}
