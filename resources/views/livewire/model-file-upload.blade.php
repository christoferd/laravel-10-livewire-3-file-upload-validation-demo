<div>
    <div style="max-width: 600px;">

        <div class="hidden" wire:loading.class.remove="hidden">
        <div class="lds-dual-ring"></div>
        </div>

        @error('uploadedFile')
        <div style="padding: 16px 24px; color: red;"><span class="error">{{ $message }}</span></div>
        @enderror

        <form wire:submit="save" class="border rounded my-3 p-3">
            @csrf
            <h2 class="mb-3">Upload Form</h2>
            <div>
                @if($uploadedFile)
                    <div class="flex flex-col gap-2 sm:flex-row sm:gap-3 mb-4">
                        <div>
                            <div class="text-xs pb-1 text-gray-500">Preview:</div>
                            <div>
                                @if($uploadedFile->isPreviewable())
                                    <img src="{{ $uploadedFile->temporaryUrl() }}" class="w-40 border rounded p-2" alt="imágen previa">
                                @else
                                    {!! $uploadedFile->getMimeType() !!}
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-xs pb-1 text-gray-500">Confirm:</div>
                            <button type="submit" class="flex flex-row gap-2 items-center"
                                    x-on:click="showUploadForm=false"
                            >
                                Upload
                            </button>
                        </div>
                    </div>
                @endif
                <input type="file" wire:model.live="uploadedFile">
            </div>
        </form>

        <div style="padding: 20px; border: 1px solid #ddd;">Result: {!! $result !!}</div>

    </div>
</div>
