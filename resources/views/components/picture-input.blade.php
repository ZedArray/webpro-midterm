<div class="flex items-center" x-data="picturePreview()">
    <div class="rounded-full bg-gray-200 mr-2">
        <img id="preview" src="img/default.jpg" alt="" class="w-24 h-24 rounded-full object-cover">
    </div>
    <div>
        <x-secondary-button x-on:click="document.getElementById('picture').click()" class="relative">
            <div class="flex items-center">
                <svg class="w-[24px] h-[24px] mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/>
                  </svg>
                Upload Picture                  
            </div>
            <input x-on:change="showPreview(event)" accept="image/png, image/jpeg" type="file" name="picture" id="picture" class="absolute inset-0 -z-10 opacity-0">
        </x-secondary-button>
    </div>
    <script>
        function picturePreview() {
            return {
                showPreview(event) {
                    if (event.target.files.length > 0) {
                        var src = URL.createObjectURL(event.target.files[0]);
                        document.getElementById('preview').src = src;
                    }
                }
            }
        }
    </script>
</div>