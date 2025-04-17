<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Gestion des Reservations') }}
      </h2>
  </x-slot>


<x-button link="{{route('reservation.create')}}">Ajouter</x-button>
<table>
  <thead>
    <tr>
      <th>Nom de la salle</th>
      <th>Réservé par</th>
      <th>Heure de début</th>
      <th>Heure de fin</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($reservations as $reservation)
    <tr>
      <td>{{$reservation->salle->name}}</td>
      <td>{{$reservation->user->first_name}}</td>
      <td>{{$reservation->start_time}}</td>
      <td>{{$reservation->end_time}}</td>

      <td class='flex gap-2'>
        <x-button link="{{ route('reservation.edit', ['reservation' => $reservation]) }}" class="bg-yellow-500">Éditer</x-button>
        <form method="post" action="{{ route('reservation.destroy', ['reservation' => $reservation]) }}">
            @method('delete')
            @csrf
            <button type="submit" class="p-2 text-white bg-red-500 rounded-xl">Annuler</button>
        </form>
      </td>
    </tr>

    @endforeach
  </tbody>
</table>


</x-app-layout>
