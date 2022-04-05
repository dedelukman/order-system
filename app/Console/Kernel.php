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

            $this->productTemp();
            $this->productNew();
            $this->priceUpdate();
        
            $this->stokJombang();
            $this->stokLampung();
            
        })->everyMinute();
        // twiceDaily(9, 12);
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


    public function productTemp(){
        try{
            $stmt = Connection::connect()->prepare("SELECT KodeBarang, NamaBarang, HJ, HET2 FROM barang WHERE KodeJenisBarang='PJ' AND (HJ>0 OR HET2>0) ");
            $stmt->execute();   
            $this->productTemp =$stmt->fetchAll();
            DB::table('product_temperory')->delete();
            foreach($this->productTemp as $product){                
                DB::table('product_temperory')->insert([
                    'code' => $product['KodeBarang'],
                    'name' => $product['NamaBarang'],
                    'hj' => $product['HJ'],
                    'het2' => $product['HET2'],
                ]);
                              
            }
        
            
        }  catch(\Exception $e){
            Log::error(
                "Gagal diupdate pada tanggal "
                .date('Y-m-d H:i:s')
            );
        }
    }

    public function productNew(){
        DB::statement("INSERT INTO products
        SELECT  null, substring(a.code,2,1) AS category_id, a.code, a.name, a.hj, a.het2, 0, 0, replace(trim(lower(a.name)), ' ', '-') photo, 
        replace(trim(lower(a.name)), ' ', '-') slug,replace(trim(lower(a.name)), ' ', '-') descript ,1,null, null, null
        FROM product_temperory a
        LEFT JOIN products b ON a.code=b.code
        WHERE b.code is null
        ");
    }

    public function priceUpdate(){
        DB::statement("UPDATE products a,
        (SELECT a.code, a.hj, a.het2 FROM product_temperory a
        LEFT JOIN products b ON a.code=b.code
        WHERE a.hj!=b.hj  OR a.het2!=b.het2) b
        SET a.hj=b.hj, a.het2=b.het2
        WHERE a.code=b.code
        ");
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
