<x-app-layout>
  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="text-xl font-semibold mb-6">Nouvelle réservation</h2>

          @if ($errors->has('conflit'))
            <div class="mb-4 p-4 rounded bg-red-100 border border-red-300 text-red-700">
              {{ $errors->first('conflit') }}
            </div>
          @endif

          <form action="{{ route('reservation.store') }}" method="post" class="space-y-4">
            @csrf
            @method('post')

            <div>
              <label for="salle_id" class="block text-sm font-medium text-gray-700 mb-1">Nom de la salle</label>
              <select name="salle_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @foreach ($reservations as $reservation)
                  <option value="{{ $reservation->salle_id }}">
                    {{ $reservation->salle->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
              <input type="date" name="date" value="{{ old('date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Heure de début</label>
                <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              </div>

              <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Heure de fin</label>
                <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              </div>
            </div>

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            <div class="flex justify-end mt-6">
              <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Réserver
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
