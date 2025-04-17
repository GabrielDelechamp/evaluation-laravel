<x-app-layout>
  @if ($errors->has('conflit'))
      <div class="mb-4 p-4 rounded bg-red-100 border border-red-300 text-red-700">
          {{ $errors->first('conflit') }}
      </div>
  @endif

  <form action="{{ route('reservation.store') }}" method="post" class="space-y-4">
      @csrf
      @method('post')

      <div>
          <label for="salle_id" class="block font-medium text-gray-700">Nom de la salle</label>
          <select name="salle_id" class="w-full p-2 border border-gray-300 rounded">
              @foreach ($reservations as $reservation)
                  <option value="{{ $reservation->salle_id }}">
                      {{ $reservation->salle->name }}
                  </option>
              @endforeach
          </select>
      </div>

      <div>
          <label for="date" class="block font-medium text-gray-700">Date</label>
          <input type="date" name="date" value="{{ old('date') }}" class="w-full p-2 border border-gray-300 rounded">
      </div>

      <div>
          <label for="start_time" class="block font-medium text-gray-700">Heure de début</label>
          <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full p-2 border border-gray-300 rounded">
      </div>

      <div>
          <label for="end_time" class="block font-medium text-gray-700">Heure de fin</label>
          <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full p-2 border border-gray-300 rounded">
      </div>

      <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
          Envoyer
      </button>
  </form>
</x-app-layout>
