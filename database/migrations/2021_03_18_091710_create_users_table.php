<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('active_company_id')->index()->nullable();
            $table->string('firstname',60)->nullable();
            $table->string('lastname',60)->nullable();
            $table->string('name')->nullable();
            $table->string('username',60)->nullable();
            $table->integer('language_id')->nullable();
            $table->integer('email')->nullable();
            $table->string('country_code',20)->nullable();
            $table->string('phone_code',20)->nullable();
            $table->string('phone',91)->nullable();
            $table->decimal('balance',11,2)->default(0);
            $table->decimal('interest_balance',11,2)->default(0);
            $table->string('image',191)->nullable();
            $table->string('driver',191)->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('two_fa')->default(0)->comment('0: two-FA off, 1: two-FA on');
            $table->boolean('two_fa_verify')->default(1)->comment('0: two-FA unverified, 1: two-FA verified');
            $table->string('two_fa_code',50)->nullable();
            $table->boolean('email_verification')->default(1);
            $table->boolean('sms_verification')->default(1);
            $table->string('verify_code',50)->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('password',191)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token',191)->nullable();
            $table->boolean('identity_verify')->default(0)->comment('0 => Not Applied, 1=> Applied, 2=> Approved, 3 => Rejected');
            $table->boolean('address_verify')->default(0)->comment('0 => Not Applied, 1=> Applied, 2=> Approved, 3 => Rejected');
            $table->timestamp('last_seen')->nullable();
            $table->string('timezone')->nullable();
            $table->integer('user_type')->default(2)->comment('1=> admin , 2=>sales center');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_bonuses');
    }
}
