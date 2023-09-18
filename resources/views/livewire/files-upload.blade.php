<div>
    <div
        class="flex h-screen justify-center items-center"
        x-data="drop_file_component()">
        <div
            class="py-6 w-96 rounded border-dashed border-2 flex flex-col justify-center items-center"
            x-bind:class="dropingFile ? 'bg-gray-400 border-gray-500' : 'border-gray-500 bg-gray-200'"
            x-on:drop="dropingFile = false"
            x-on:drop.prevent="
                handleFileDrop($event)
            "
            x-on:dragover.prevent="dropingFile = true"
            x-on:dragleave.prevent="dropingFile = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <div class="text-center" wire:loading.remove wire.target="files">Drop Your Files Here</div>
            <div class="mt-1" wire:loading.flex wire.target="files">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <div>Processing Files</div>
            </div>
        </div>
    </div>

    <script>
        function drop_file_component() {
            return {
                dropingFile: false,
                handleFileDrop(e) {
                    if (event.dataTransfer.files.length > 0) {
                        const files = e.dataTransfer.files;
                        @this.uploadMultiple('files', files,
                            (uploadedFilename) => {}, () => {}, (event) => {}
                        )
                    }
                }
            };
        }
    </script>
</div>