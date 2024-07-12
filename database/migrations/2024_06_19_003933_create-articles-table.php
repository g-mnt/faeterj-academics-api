<?php

use App\ArticleStatusesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('document_path');
            $table->enum('status', ArticleStatusesEnum::values());
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
