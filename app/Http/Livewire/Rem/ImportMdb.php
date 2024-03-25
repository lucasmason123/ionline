<?php

namespace App\Http\Livewire\Rem;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use ZipArchive;

class ImportMdb extends Component
{
    use WithFileUploads;

    public $file;
    public $info = [];

    protected $rules = [
        'file' => 'required|mimes:zip|max:62288',
    ];

    protected $messages = [
        'file.required' => 'El nombre es requerido.',
        'file.mimes' => 'Al archivo subido debe ser de tipo ZIP.',
        'file.max' => 'No puede ser mayor a 62MB',
    ];

    public function save()
    {
        $this->validate();

        // $filename = '02A21022024.zip';

        $this->info['mdb-export'] = shell_exec("mdb-export --version");

        $filename = $this->file->getClientOriginalName();
        $this->file->storeAs('rems', $filename, 'local');
        $this->info['step1'] = 'Archivo almacenado temporalmente';

        // Descomprimir el archivo subido que es .zip
        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/rems/'.$filename));
        if ($res === TRUE) {
            $zip->extractTo(storage_path('app/rems'));
            $zip->close();
            $this->info['step2'] = 'Archivo descomprimido';

            // replace .zip to .mdb
            $filename = str_replace('.zip', '.mdb', $filename);
            $fullpath = storage_path('app/rems/'.$filename);

            // check if file exists
            if (file_exists($fullpath)) {
                $this->info['step3'] = 'Archivo mdb encontrado';
                $command = "mdb-export $fullpath Registros | cut -d',' -f6 | head -n 2 | tail -n 1";
                $output = shell_exec($command);
    
                // elimina del output "2024" las doble comillas
                $year = str_replace('"', '', trim($output));
                $this->info['step4'] = "Año a procesar: $year";

                // $year tiene que estar entre el año actual y el anterior
                if ($year > date('Y') || $year < date('Y') - 1) {
                    $this->info['step5'] = 'Error: Año incorrecto, debe estar entre el año actual y el anterior';
                    return;
                }
                $tabla = $year.'rems';

                $command = "mdb-export -I mysql $fullpath Datos | sed 's/INTO `Datos`/INTO `$tabla`/'";
                $output = shell_exec($command);
                $this->info['step5'] = "Obteniendo los datos de la tabla Datos";

                $connection = DB::connection('mysql_rem');

                // vaciar la tabla $tabla de mysql
                $connection->table($tabla)->truncate();
                $this->info['step6'] = "Vaciada la tabla $tabla";

                // Procesar la salida y ejecutar cada instrucción SQL generada por mdb-export
                foreach (explode("\n", $output) as $sql) {
                    if (!empty($sql)) {
                        // Ejecutar el SQL en la $tabla
                        try {
                            $connection->unprepared($sql);
                        } catch (\Exception $e) {
                            $this->error("Error ejecutando SQL: " . $e->getMessage());
                            return;
                        }
                    }
                }
                $this->info['step7'] = "Cargados los Datos a la tabla $tabla";
                $this->info['Fin'] = "Proceso terminado exitosamente";
            }
            else {
                $this->info['step3'] = 'Error: El archivo mdb no existe';
                return;
            }
        } else {
            $this->info['step2'] = 'Error: al descomprimir el archivo: '. $res;
        }

    }

    public function render()
    {
        return view('livewire.rem.import-mdb');
    }
}
