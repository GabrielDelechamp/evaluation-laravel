<x-app-layout>
  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="text-xl font-semibold mb-6">Modifier une salle</h2>
          <form action="{{route('salle.update', ['salle'=>$salle])}}" method='post' class="space-y-4">
            @csrf
            @method('put')
            <div class="grid grid-cols-1 gap-4">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="name" value="{{old('name', $salle->name)}}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              </div>
              <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacité</label>
                <input type="number" name="capacity" value="{{old('capacity', $salle->capacity)}}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              </div>
              <div>
                <label for="surface" class="block text-sm font-medium text-gray-700 mb-1">Surface</label>
                <input type="number" name="surface" value="{{old('surface', $salle->surface)}}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              </div>
            </div>
            <div class="flex justify-end mt-6">
              <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
