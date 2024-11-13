<?php

use Illuminate\Support\Facades\Route;

Route::get('migration', function () {
    function camel_case($string) {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    $directory = database_path('migrations/');
    $modelDirectory = app_path('Models') . '/';
    $files = glob($directory . '*.php');

    foreach ($files as $key => $file) {
        if ($key > 2) {
            $contents = file_get_contents($file);
            if (preg_match('/\$table->id\(\);(.*?)\$table->timestamps\(\);/s', $contents, $matches)) {
                // Extract the matched block
                $block = $matches[1];

                // Find all strings inside $table-> method calls like $table->string('field_name');
                preg_match_all('/\$table->.*?\(\'(.*?)\'\)/', $block, $fieldMatches);

                $fields = $fieldMatches[1]; // All field names are in the second match group

                // Derive the table name and model name from the migration filename
                $migrationName = basename($file, '.php'); // e.g., 2023_09_12_100000_create_user_akses_table.php
                preg_match('/create_(.*)_table/', $migrationName, $tableNameMatch);

                if (isset($tableNameMatch[1])) {
                    $tableName = $tableNameMatch[1]; // e.g., user_akses
                    $modelName = ucfirst(camel_case($tableName)); // e.g., UserAkses

                    // Path to the model file
                    $modelFile = $modelDirectory . $modelName . '.php';

                    if (file_exists($modelFile)) {
                        $modelContent = file_get_contents($modelFile);

                        // Prepare the $fillable array with proper formatting
                        $fillableArray = "protected \$fillable = [\n        '" . implode("',\n        '", $fields) . "',\n    ];";

                        // Prepare the $table property string
                        $tableProperty = "protected \$table = '$tableName';";

                        // Find the position after "use HasFactory;"
                        if (preg_match('/use\s+HasFactory;\s*/', $modelContent, $useFactoryMatch, PREG_OFFSET_CAPTURE)) {
                            $insertPosition = $useFactoryMatch[0][1] + strlen($useFactoryMatch[0][0]);

                            // Prepare the combined string of $table and $fillable
                            $insertString = "\n    $tableProperty\n\n    $fillableArray\n";

                            // Insert the string after "use HasFactory;"
                            $modelContent = substr_replace($modelContent, $insertString, $insertPosition, 0);

                            // Write the updated content back to the model file
                            file_put_contents($modelFile, $modelContent);

                            echo "Updated model: $modelName with table: $tableName and fillable fields: " . implode(', ', $fields) . " <br>";
                        } else {
                            echo "No 'use HasFactory;' found in model: $modelName <br>";
                        }
                    } else {
                        echo "Model file not found for: $modelName <br>";
                    }
                }
            }
        }
    }
});
