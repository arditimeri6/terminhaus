<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\Encrypter;
use Config;

class MailSetupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (\Schema::hasTable('mail_setups')) {
            $mail = DB::table('mail_setups')->orderBy('created_at', 'desc')->first();
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'driver' => 'smtp',
                    'host' => $mail->host,
                    'port' => $mail->port,
                    'username' => $mail->username,
                    'password' => decrypt($mail->password),
                    'from' => array('address' => 'test@gmail.com', 'name' => 'test'),
                    'encryption' => 'ssl',
                    'sendmail' => '/usr/sbin/sendmail -bs',
                    'pretend' => false,
                );
                Config::set('mail', $config);
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
