<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Add Image') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
        <form method="POST" action="/image" enctype="multipart/form-data">
          <div class="form-group">
            <input name="image_file" type="file" name="image_file" class="form-control-file" />
          </div>
          @if(count($errors) > 0)
            @foreach($errors->all() as $error)
              <span class="text-red-600">{{ $error }}</span>
            @endforeach
          @endif
          <br />

          <div class="form-group">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Image</button>
          </div>
          {{ csrf_field() }}
        </form>
      </div>
    </div>
  </div>
</x-app-layout>