<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_pic', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')
                ->constrained('rooms')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['room_id', 'user_id']);
        });

        // Pindahkan PIC lama dari rooms.pic_id ke tabel penghubung.
        DB::table('rooms')
            ->whereNotNull('pic_id')
            ->orderBy('id')
            ->get()
            ->each(function ($room) {
                DB::table('room_pic')->insert([
                    'room_id' => $room->id,
                    'user_id' => $room->pic_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

        // Hapus kolom PIC lama setelah relasi berhasil dipindahkan.
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pic_id');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('pic_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });

        DB::table('room_pic')
            ->orderBy('id')
            ->get()
            ->each(function ($assignment) {
                DB::table('rooms')
                    ->where('id', $assignment->room_id)
                    ->whereNull('pic_id')
                    ->update([
                        'pic_id' => $assignment->user_id,
                    ]);
            });

        Schema::dropIfExists('room_pic');
    }
};