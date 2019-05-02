<?php

namespace DataImport\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mockery\Exception;

class StoreToDB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    protected $table;
    protected $message;

    public function __construct($data, $table)
    {
        $this->data = $data;
        $this->table = $table;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            DB::table($this->table)->insert($this->data);
            $this->message = 'Data saved to database';
        }
        catch (Exception $ex){
            $this->message = '[Exception]: ' . $ex->getMessage();
        }
        Mail::to(config('dataImport.send_email_to'))->send(new DataImportMailable($this->message));
    }
}
