<x-app-layout>
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
          <label for="salle_id" class="block font-medium text-gray-700">Nom de la salle</label>
          <select name="salle_id" class="w-full p-2 border border-gray-300 rounded">
            @foreach ($reservations as $resa)
                <option value="{{ $resa->salle->id }}" {{ $reservation->salle_id == $resa->salle->id ? 'selected' : '' }}>
                    {{ $resa->salle->name }}
                </option>
            @endforeach
        </select>

      </div>

      <div>
          <label for="date" class="block font-medium text-gray-700">Date</label>
          <input type="date" name="date" value="{{ $reservation->formattedDate() }}" class="w-full p-2 border border-gray-300 rounded">
      </div>

      <div>
          <label for="start_time" class="block font-medium text-gray-700">Heure de début</label>
          <input type="time" name="start_time" value="{{ $reservation->formattedStartTime() }}" class="w-full p-2 border border-gray-300 rounded">
      </div>

      <div>
          <label for="end_time" class="block font-medium text-gray-700">Heure de fin</label>
          <input type="time" name="end_time" value="{{ $reservation->formattedEndTime() }}" class="w-full p-2 border border-gray-300 rounded">
      </div>

      <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">

      <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
          Mettre à jour
      </button>
  </form>
</x-app-layout>
