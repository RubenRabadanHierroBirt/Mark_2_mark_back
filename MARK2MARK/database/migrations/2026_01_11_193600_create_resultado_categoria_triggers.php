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
        // Trigger para INSERT: Coge la categoría del atleta al crear un resultado
        DB::unprepared('
            DROP TRIGGER IF EXISTS set_resultado_categoria_insert;
        ');
        
        DB::unprepared('
            CREATE TRIGGER set_resultado_categoria_insert
            BEFORE INSERT ON resultados
            FOR EACH ROW
            BEGIN
                DECLARE atleta_categoria VARCHAR(20);
                
                -- Obtener la categoría del atleta
                SELECT categoria INTO atleta_categoria
                FROM atletas
                WHERE id = NEW.id_registro_atletico
                LIMIT 1;
                
                -- Asignar la categoría al resultado
                IF atleta_categoria IS NOT NULL THEN
                    SET NEW.categoria = atleta_categoria;
                END IF;
            END
        ');

        // Trigger para UPDATE: Actualiza la categoría si cambia el atleta
        DB::unprepared('
            DROP TRIGGER IF EXISTS set_resultado_categoria_update;
        ');
        
        DB::unprepared('
            CREATE TRIGGER set_resultado_categoria_update
            BEFORE UPDATE ON resultados
            FOR EACH ROW
            BEGIN
                DECLARE atleta_categoria VARCHAR(20);
                
                -- Solo actualizar si cambia el atleta referenciado
                IF NEW.id_registro_atletico != OLD.id_registro_atletico OR OLD.categoria IS NULL THEN
                    SELECT categoria INTO atleta_categoria
                    FROM atletas
                    WHERE id = NEW.id_registro_atletico
                    LIMIT 1;
                    
                    IF atleta_categoria IS NOT NULL THEN
                        SET NEW.categoria = atleta_categoria;
                    END IF;
                END IF;
            END
        ');

        // Actualizar resultados existentes con la categoría del atleta
        DB::statement('
            UPDATE resultados r
            INNER JOIN atletas a ON r.id_registro_atletico = a.id
            SET r.categoria = a.categoria
            WHERE a.categoria IS NOT NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS set_resultado_categoria_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS set_resultado_categoria_update');
    }
};
