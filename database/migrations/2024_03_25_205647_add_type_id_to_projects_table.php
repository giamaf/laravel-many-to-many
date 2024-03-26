<?php

use App\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //! OPZIONE 1
            //todo Creo la colonna
            // $table->unsignedBigInteger('type_id')->nullable()->after('id');

            //todo Creo la chiave esterna
            // $table->foreign('type_id')->references('id')->on('types')->nullOnDelete();

            //! OPZIONE 2 - (Importante seguire le convenzioni) nullOnDelete alla fine
            $table->foreignId('type_id')->after('id')->nullable()->constrained()->nullOnDelete();

            //! Oppure (Importante seguire le convenzioni)
            // $table->foreignIdFor(Type::class)->after('id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Cancello la relazione
            //! OPZIONE 1
            // $table->dropForeign('projects_type_id_foreign');

            //! OPZIONE 2
            $table->dropForeignIdFor(Type::class);

            // Cancello la colonna
            $table->dropColumn('type_id');
        });
    }
};
