<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    

                    <form  method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-2">
                            <x-label for="name" :value="__('Category Name')"/>

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required/>
                        </div>
                        <div class="mt-4">
                            <x-label for="category_photo" :value="__('Category Photo')"/>
                            <input id="category_photo" class="block mt-1 w-full" type="file" name="category_photo" required/>               
                        </div>
                        <div class="mt-4">
                            <x-label for="category_icon" :value="__('Category Icon')"/>
                            <input id="category_icon" class="block mt-1 w-full" type="file" name="category_icon" required/>               
                        </div>
                        <div class="mt-4">
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_publish" class="form-checkbox" value="1">
                                    <span class="ml-2">Status(Is Publish?)</span>
                                </label>
                            </div>
                        </div>

                       
                        <x-button class="mt-4">
                            {{ __('Submit') }}
                        </x-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
