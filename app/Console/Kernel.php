<?php

namespace App\Console;

use App\Models\Connection;
use App\Models\ConnectionLampung;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    public $stokjombang;
    public $stoklampung;

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->everyMinute();
       
        $schedule->call(function () {
        
            $this->stokJombang();
            $this->stokLampung();
            
        })->everyMinute();
    }

    public function stokJombang(){
        try{
            $stmt = Connection::connect()->prepare("SELECT * FROM vstokpj");
            $stmt->execute();   
            $this->stokjombang =$stmt->fetchAll();
       
            foreach($this->stokjombang as $stok){                
                DB::table('products')
                ->where('code',  $stok['KodeBarang'])
                ->update(['stok1' => $stok['Stok'] ]);               
            }

        }  catch(\Exception $e){
            Log::error(
                "Gagal diupdate pada tanggal "
                .date('Y-m-d H:i:s')
            );
        }
      
    }

    public function stokLampung(){
        try{
            $stmt = ConnectionLampung::connect()->prepare("SELECT * FROM stok");
            $stmt->execute();   
            $this->stoklampung =$stmt->fetchAll();
            foreach($this->stoklampung as $stok){                
                DB::table('products')
                ->where('code',  $stok['KodeBarang'])
                ->update(['stok2' => $stok['Stok'] ]);               
            }
        }  catch(\Exception $e){
            Log::error(
                "Gagal diupdate pada tanggal "
                .date('Y-m-d H:i:s')
            );
        }
      
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
