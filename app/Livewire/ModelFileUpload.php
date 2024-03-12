<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ModelFileUpload extends Component
{
    use WithFileUploads;

    // Refs:
    // https://livewire.laravel.com/docs/validation#customizing-error-messages
    // https://livewire.laravel.com/docs/uploads#storing-uploaded-files
    // #[Validate('file|max:12288', as: 'Archivo', message: 'Tipos de archivos aceptados: png/jpg/jpeg/webp. Tamaño máximo de archivo: 12.000 KB, o 12 MB')]
    #[Validate('image|max:1024|mimes:png,jpg,jpeg,webp')]
    public $uploadedFile = null;
    public string $result = 'Waiting for a file.';

    public function render()
    {
        return view('livewire.model-file-upload');
    }

    public function updatedUploadedFile()
    {
        // Validation - this works as soon as the file is added to the form, before submit, in the preview phase.
        // $this->validateUploadedFile();
    }

    protected function validateUploadedFile()
    {
        $rules = ['uploadedFile' => 'image|max:1024|mimes:png,jpg,jpeg,webp'];
        $messages = ['uploadedFile.*' => 'File size or format not accepted.']; // Expect to see this message for any error relating to uploadedFile
        try {
            $this->validate($rules, $messages, ['uploadedFile' => $this->uploadedFile]);
        }
        catch(\Throwable $ex) {
            $this->reset('uploadedFile');
            throw $ex;
        }
    }

    public function save(): void
    {
        // Validation - this works after clicking the Upload button.
        // However it allows the preview to pass without validation.
        // So, we must have function updatedUploadedFile() to catch changes to the input so that the file is validated before preview
        // and before uploading.
        // $this->validateUploadedFile();

        // Location depends on livewire config
        $pathToFile = \storage_path('app/livewire-tmp/'.$this->uploadedFile->getFilename());

        // $this->alertDebug('pathToFile = '.$pathToFile);
        if(!\file_exists($pathToFile)) {
            throw new \Exception('Error - Uploaded file does not exist!');
        }

        // Success
        $this->result = 'File uploaded';
    }

}
