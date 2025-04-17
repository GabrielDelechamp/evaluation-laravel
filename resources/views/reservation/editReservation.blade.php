<x-app-layout>
  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="text-xl font-semibold mb-6">Modifier la réservation</h2>

          @if ($errors->any())
            <div class="mb-4 p-4 rounded bg-red-100 border border-red-300 text-red-700">
              @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <form action="{{ route('reservation.update', $reservation->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
              <label for="salle_id" class="block text-sm font-medium text-gray-700 mb-1">Nom de la salle</label>
              <select name="salle_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @foreach ($reservations as $resa)
                  <option value="{{ $resa->salle->id }}" {{ $reservation->salle_id == $resa->salle->id ? 'selected' : '' }}>
                    {{ $resa->salle->name }}
                  </option>
                @endforeach
              </select>
            </div>

            <div>
              <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
              <input type="date" name="date" value="{{ $reservation->formattedDate() }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Heure de début</label>
                <input type="time" name="start_time" value="{{ $reservation->formattedStartTime() }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              </div>

              <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Heure de fin</label>
                <input type="time" name="end_time" value="{{ $reservation->formattedEndTime() }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              </div>
            </div>

            <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">

            <div class="flex justify-end mt-6">
              <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Mettre à jour
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
