<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger para INSERT: Calcula la categoría al crear un atleta
        DB::unprepared('
            DROP TRIGGER IF EXISTS calcular_categoria_insert;
        ');
        
        DB::unprepared('
            CREATE TRIGGER calcular_categoria_insert
            BEFORE INSERT ON atletas
            FOR EACH ROW
            BEGIN
                IF NEW.fecha_nacimiento IS NOT NULL THEN
                    SET @edad = TIMESTAMPDIFF(YEAR, NEW.fecha_nacimiento, CURDATE());
                    
                    IF @edad <= 19 THEN
                        SET NEW.categoria = "Sub-18";
                    ELSEIF @edad <= 21 THEN
                        SET NEW.categoria = "Sub-20";
                    ELSEIF @edad <= 24 THEN
                        SET NEW.categoria = "Sub-23";
                    ELSE
                        SET NEW.categoria = "Senior";
                    END IF;
                END IF;
            END
        ');

        // Trigger para UPDATE: Recalcula la categoría si cambia la fecha de nacimiento
        DB::unprepared('
            DROP TRIGGER IF EXISTS calcular_categoria_update;
        ');
        
        DB::unprepared('
            CREATE TRIGGER calcular_categoria_update
            BEFORE UPDATE ON atletas
            FOR EACH ROW
            BEGIN
                IF NEW.fecha_nacimiento IS NOT NULL THEN
                    SET @edad = TIMESTAMPDIFF(YEAR, NEW.fecha_nacimiento, CURDATE());
                    
                    IF @edad <= 19 THEN
                        SET NEW.categoria = "Sub-18";
                    ELSEIF @edad <= 21 THEN
                        SET NEW.categoria = "Sub-20";
                    ELSEIF @edad <= 24 THEN
                        SET NEW.categoria = "Sub-23";
                    ELSE
                        SET NEW.categoria = "Senior";
                    END IF;
                END IF;
            END
        ');

        // Actualizar atletas existentes
        DB::statement('
            UPDATE atletas
            SET categoria = CASE
                WHEN fecha_nacimiento IS NULL THEN NULL
                WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) <= 19 THEN "Sub-18"
                WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) <= 21 THEN "Sub-20"
                WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) <= 24 THEN "Sub-23"

                ELSE "Senior"
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS calcular_categoria_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS calcular_categoria_update');
    }
};
